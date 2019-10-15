<?php

namespace App\Http\Controllers;

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
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        check  if super admin, then show all results

        if(Auth::user()->role == 1) {
            $stations = Station::all();
            $fuels = Fuel::with(["bonuses", "clients", "dispensers" => function($query) {
                $query->with("stations");
            }])->orderBy("fuels.id", "DESC")->paginate(self::PAGINATION);
        } else {
//            else show the results, which have been assigned by super admin before
            $fuels = $this->getFuels()['fuels'];
            $station_ids = $this->getFuels()['stations'];
            $stations = Station::whereIn("id", $station_ids)->get();
        }

        if(null != $request->station_id) {
            $fuels = Fuel::whereHas("dispensers", function($query) use ($request) {
                $query->whereHas("stations", function($query) use ($request) {
                    $query->whereIn("stations.id", [$request->station_id]);
                });
            })->with(["bonuses", "clients"])
                ->orderBy("fuels.id", "DESC")->paginate(self::PAGINATION);
        }

        elseif(null != $request->dispenser_id) {
            $fuels = Fuel::whereHas("dispensers", function($query) use ($request) {
                $query->where("dispenser_id", $request->dispenser_id)->with("stations");
            })->with(["bonuses", "clients"])
                ->orderBy("fuels.id", "DESC")->paginate(self::PAGINATION);
        }

        $dispensers = $this->getDispensers($request);
        return view('Fuel/index', compact("fuels", "stations", "request", "dispensers"));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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
        $fuels = Fuel::whereHas("dispensers", function($query) use ($station_ids) {
            $query->whereHas("stations", function($query) use ($station_ids) {
                $query->whereIn("stations.id", [$station_ids]);
            });
        })->with(["bonuses", "clients"])
            ->orderBy("id", "DESC")->paginate(self::PAGINATION);
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
