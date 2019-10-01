<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dispenser;
use App\Fuel;

class BonusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $dispenser = Dispenser::withCount(["fuels"])->where("identificator", $request->identificator)->first();
        $rows = isset($dispenser->fuels_count) ? $dispenser->fuels_count : 0;
//        $this->set($request, $rows);
        $dispenser = Dispenser::with(["fuels" => function($query) {
            $query->orderBy("id", "desc")->first();
        }])->where("identificator", $request->identificator)->first();
        dd($dispenser->fuels[0]->id);
    }

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
}
