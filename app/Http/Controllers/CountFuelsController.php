<?php

namespace App\Http\Controllers;

use App\Client;
use App\Dispenser;
use App\Station;
use Illuminate\Http\Request;
use App\Fuel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\StaticData;
use Illuminate\Support\Facades\DB;
use App\ExceedSeen;

class CountFuelsController extends Controller
{

    const CACHE_SECONDS = 0;
    const PAGINATION = 100;
    private static $count;

    public function __construct()
    {
        self::$count = StaticData::first()->filling_max_quantity ?? 3;
    }

    public function index(Request $request)
    {
        if(Auth::user()->role == 1) {
            $stations = Station::all();
        } else {
//            else show the results, which have been assigned by super admin before
            $station_ids = $this->getFuels()['stations'];
            $stations = Station::whereIn("id", $station_ids)->get();
        }
        $data = self::count();
        $this->setToSeen(count($data));
        $dispensers = $this->getDispensers($request);
        $clients = Client::all();
        $current_count = 0;
        $seen_count = 0;
        return view("exceeds.index", compact("data", "dispensers", "clients", "stations", "request", "current_count", "seen_count"));
    }

//    Simple function counting the fuel limit exceed

    public static function count()
    {
        $count = self::$count ?? 3;
        $today = explode(" ", Carbon::today())[0];
        $value = Cache::remember('fuelCount', self::CACHE_SECONDS, function () use($count, $today) {
            $fuels = Fuel::whereDate("created_at", $today)->whereRaw("client_id in (select client_id from fuels where date(created_at) = '".$today."' group by client_id HAVING count(*) >= $count )")->whereHas("bonuses", function($query){
                $query->where("bonus", ">", 0);
            })->with(['clients', 'dispensers'])->orderBy("created_at", "desc")->get();
            return $fuels;
        });
        return $value;
    }

//    Simple function checking if the count in db is equal with new data

    public static function checkCount()
    {
        $count = self::count();
        $countDb = ExceedSeen::whereDate("created_at", Carbon::today())->first();
        if(count($count) != $countDb) {
            self::addToExceedSeenTable($count);
        }
    }

//    get dispensers for admin or super admin

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

    //    get fuels for admin or super admin

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

//    No comment :)

    private function setToSeen($count)
    {
        $static = StaticData::first();
        $static->exceed_seen = 1;
        $static->seen_count = $count;
        $static->save();
    }

//    Inserts the order count into db if it has not inserted yet

    private static function addToExceedSeenTable($count)
    {
        $countDb = ExceedSeen::whereDate("created_at", Carbon::today())->first();
        if(null == $countDb) {
            $countDb = new ExceedSeen();
        } else {
            if($countDb->count == $count) {
                return;
            }
        }
        $countDb->count = $count;
        $countDb->save();
    }
}
