<?php

namespace App\Http\Controllers;

use App\Client;
use App\Dispenser;
use App\Fuel;
use App\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FuelController extends Controller
{

    const PAGINATION = 100;

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $station_ids = null;
//        check  if super admin, then show all results
        if (Auth::user()->role == 1) {
            $stations = Station::all();
        } else {
//            else show the results, which have been assigned by super admin before
            $station_ids = $this->getFuels()['stations'];
            $stations = Station::whereIn("id", $station_ids)->get();
        }
        $fuels = Fuel::whereHas("dispensers", function ($query) use ($request, $station_ids) {
            if (null != $request->dispenser_id) {
                $query->where("dispenser_id", $request->dispenser_id)->whereHas("stations", function ($query) use ($request) {
                    if (null != $request->station_id) $query->whereIn("stations.id", [$request->station_id]);
                });
            }
            $query->whereHas("stations", function ($query) use ($request, $station_ids) {
                if (null != $station_ids) {
                    $query->whereIn("stations.id", $station_ids);
                } elseif (null != $request->station_id) {
                    $query->where("stations.id", $request->station_id);
                }
            });
        });
        if (null != $request->client_id) {
            $fuels->whereHas("clients", function ($query) use ($request) {
                if (null != $request->client_id) $query->where("client_id", $request->client_id);
            });
        } else {
            $fuels->with("clients");
        }
        if (null != $request->from) {
            $request->from != $request->to ? $fuels->whereDate("created_at", ">=", $request->from)->whereDate("created_at", "<=", $request->to) : $fuels->whereDate("created_at", $request->from);
        } else {
            $fuels->whereDate("created_at", date('Y-m-d', time()));
        }
        if (null != $request->bonus_type) {
            $mark = $request->bonus_type == 1 ? ">" : "<";
            $fuels->whereHas("bonuses", function ($query) use ($request, $mark) {
                $query->where("bonus", $mark, 0);
            });
            $fuels->with(["bonuses" => function($query) use($request, $mark) {
                $query->where("bonus", $mark, 0);
            }]);
        } else {
            $fuels->with("bonuses");
        }
        $fuels = $fuels->orderBy("fuels.created_at", "DESC")->paginate(self::PAGINATION);


        $dispensers = $this->getDispensers($request);
        $clients = Client::all();
        return view('Fuel/index', compact("fuels", "stations", "request", "dispensers", "clients"));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getFuels()
    {
        $stations = DB::table("admins_stations")->select("station_id")->where("user_id", Auth::user()->id)->get();
        $station_ids = array();
        foreach ($stations as $s) {
            $station_ids[] = $s->station_id;
        }
        $fuels = Fuel::whereHas("dispensers", function ($query) use ($station_ids) {
            $query->whereHas("stations", function ($query) use ($station_ids) {
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
        if (Auth::user()->role == 1) {
            if (null == $request->station_id) {
                return Dispenser::all();
            }
            return Dispenser::where("station_id", $request->station_id)->get();
        } else {
            if (null == $request->station_id) {
                $station_ids = $this->getFuels()['stations'];
                return Dispenser::whereIn("station_id", $station_ids)->get();
            }
            return Dispenser::where("station_id", $request->station_id)->get();
        }

    }
}
