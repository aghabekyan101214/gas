<?php

namespace App\Http\Controllers;

use App\Station;
use Illuminate\Http\Request;
use App\Dispenser;
use App\Fuel;
use App\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Bonus;
use App\StaticData;
use App\Traits\GenerateRandomString;

class BonusController extends Controller
{

    private $bonus_percent = 0;
    private $min_bonus = 5;
    const PAGINATION = 100;

    public function __construct()
    {
        $staticData = StaticData::first();
        if(null != $staticData) {
            $this->bonus_percent = $staticData->bonus;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $station_ids = null;
//        check  if super admin, then show all results
        if(Auth::user()->role == 1) {
            $stations = Station::all();
        } else {
//            else show the results, which have been assigned by super admin before
            $station_ids = $this->getFuels()['stations'];
            $stations = Station::whereIn("id", $station_ids)->get();
        }

        $fuels = Fuel::whereHas("dispensers", function($query) use ($request, $station_ids) {
            if(null != $request->dispenser_id) {
                $query->where("dispenser_id", $request->dispenser_id)->whereHas("stations", function($query) use($request) {
                    if(null != $request->station_id) $query->whereIn("stations.id", [$request->station_id]);
                });
            }
            $query->whereHas("stations", function ($query) use ($request, $station_ids) {
                if (null != $station_ids) {
                    $query->whereIn("stations.id", $station_ids);
                } elseif (null != $request->station_id) {
                    $query->where("stations.id", $request->station_id);
                }
            });
        })->whereHas("clients", function($query) use($request) {
            if(null != $request->client_id) $query->where("client_id", $request->client_id);
        });
        $fuels->whereHas("bonuses", function($query) {
            $query->where("bonuses.bonus", '>', 0);
        });
        $fuels->with(["bonuses" => function($query) use($request) {
            $query->where("bonus", ">", 0);
        }]);
        if(null != $request->from) {
            $request->from != $request->to ? $fuels->whereDate("created_at", ">=", $request->from)->whereDate("created_at", "<=", $request->to) : $fuels->whereDate("created_at", $request->from);
        } else {
            $fuels->whereDate("created_at", date('Y-m-d', time()));
        }
        $fuels = $fuels->orderBy("fuels.created_at", "DESC")->paginate(self::PAGINATION);
        $dispensers = $this->getDispensers($request);
        $clients = Client::all();
        return view('Bonus.bonuses', compact("fuels", "stations", "request", "dispensers", "clients", "bonus"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function store(Request $request, $redeem = null)
    {
        $dispenser = Dispenser::withCount(["fuels"])->where("identificator", $request->identificator)->first();
        $rows = isset($dispenser->fuels_count) ? $dispenser->fuels_count : 0;
        $client = Client::where("qr", $request->qr)->first();
        if($client->bonus < $request->liter) return 0;
        $this->set($request, $rows);
        $dispenser = Dispenser::with(["fuels" => function($query) {
            $query->orderBy("created_at", "desc")->first();
        }])->where("identificator", $request->identificator)->first();

        DB::beginTransaction();

//        add client to current filling
        $f = Fuel::with(['bonuses' => function ($query) {
            $query->orderBy("created_at", "desc")->first();
        }])->find($dispenser->fuels[0]->id);

//        if more than one time is requested from one dispenser
        if($f->client_id != null) {
            if($f->bonuses->request_time > $request->time) {
                return array(
                    "bonus" => number_format(ClientController::getClientsBonus($client->id), 2)
                );
            }
        }

        $fuel = Fuel::find($dispenser->fuels[0]->id);
        $fuel->client_id = $client->id;
        $fuel->save();
//        give the client bonus
        if(null == $f->client_id){

            $current_bonus = ClientController::getClientsBonus($fuel->client_id);

            if(null != $redeem) {

                if($current_bonus >= $this->min_bonus) {
                    $bonus = new Bonus();
                    $bonus->id = GenerateRandomString::generate();
                    $bonus->fuel_id = $fuel->id;
                    $bonus->request_time = $request->time;
                    $bonus->bonus = $fuel->liter >= $current_bonus ? -$current_bonus : (-$fuel->liter);
                    $bonus->save();
                }

            }


            if( (null != $redeem && $current_bonus < $fuel->liter) || (null == $redeem) ) {

                $bonus = new Bonus();
                $bonus->id = GenerateRandomString::generate();
                $bonus->fuel_id = $fuel->id;
                $bonus->request_time = $request->time;
                $bonus->bonus = (null == $redeem) ? ($fuel->liter * $this->bonus_percent) / 100 : ( ( ($fuel->liter - $current_bonus) * $this->bonus_percent  ) / 100 );
                $bonus->save();
            }
        }

        if($f->client_id != null) {
            if($f->bonuses->request_time < $request->time) {
                $oldClient = Client::find($f->client_id);
                $oldClient->bonus = ClientController::getClientsBonus($oldClient->id);
                $oldClient->save();
            }
        }

//        keep the data in clients table
        $bonus = ClientController::getClientsBonus($client->id);
        $client->bonus = $bonus;
        $client->save();
        DB::commit();
        $data = array(
            "bonus" => number_format($client->bonus, 2)
        );
        if(null != $redeem) {
            $price = ($fuel->liter - $current_bonus) * $fuel->price;
            $data["price"] = ($price > 0) ? intval($price) : 0;
        }
        return $data;
    }

//    Wait till the new fuel will be inserted in db

    private function set(Request $request, $oldDbRows, $currentDbRows = null, $returnData = null)
    {
        if($oldDbRows < $currentDbRows) {
            return $returnData;
        }

        $dispenser = Dispenser::withCount(["fuels"])->where("identificator", $request->identificator)->first();
        $rows = isset($dispenser->fuels_count) ? $dispenser->fuels_count : 0;
        sleep(2);
        $this->set($request, $oldDbRows, $rows);
    }

    public function redeem(Request $request)
    {
        return $this->store($request, 1);
    }

    private function getFuels()
    {
        $stations = DB::table("admins_stations")->select("station_id")->where("user_id", Auth::user()->id)->get();
        $station_ids = array();
        foreach ($stations as $s) {
            $station_ids[] = $s->station_id;
        }
        $fuels = Fuel::whereHas("dispensers", function($query) use ($station_ids) {
            $query->whereHas("stations", function($query) use ($station_ids) {
                $query->whereIn("stations.id", [$station_ids]);
            });
        })->with(["bonuses", "clients"])
            ->orderBy("created_at", "DESC")->paginate(self::PAGINATION);
        $data = array(
            "fuels" => $fuels,
            "stations" => $station_ids
        );
        return $data;
    }

    private function getDispensers(Request $request)
    {
        if(Auth::user()->role == 1) {
            if(null == $request->station_id) {
                return Dispenser::all();
            }
            return Dispenser::where("station_id", $request->station_id)->get();
        } else {
            if(null == $request->station_id) {
                $station_ids = $this->getFuels()['stations'];
                return Dispenser::whereIn("station_id", $station_ids)->get();
            }
            return Dispenser::where("station_id", $request->station_id)->get();
        }

    }
}
