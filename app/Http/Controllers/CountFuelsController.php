<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fuel;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\StaticData;

class CountFuelsController extends Controller
{

    const CACHE_SECONDS = 60;
    private static $count;

    public function __construct()
    {
        self::$count = StaticData::first()->filling_max_quantity ?? 3;
    }

    public function index()
    {
        $data = self::count();
        return view("exceeds.index", compact("data"));
    }

    public static function count()
    {
        $count = self::$count;
        $today = explode(" ", Carbon::today())[0];
        $value = Cache::remember('fuelCount', self::CACHE_SECONDS, function () use($count, $today) {
            $fuels = Fuel::whereDate("created_at", $today)->whereRaw("client_id in (select client_id from fuels where date(created_at) = '".$today."' group by client_id HAVING count(*) >= $count )")->with(['clients', 'dispensers', 'bonuses'])->get();
            return $fuels;
        });

        return $value;
    }
}
