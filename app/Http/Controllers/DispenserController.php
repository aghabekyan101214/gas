<?php

namespace App\Http\Controllers;

use App\Dispenser;
use Illuminate\Http\Request;
use App\Station;

class DispenserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            "dispensers" => Dispenser::with("stations")->get(),
        );
        return view("dispensers.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            "stations" => Station::all()
        );
        return view("dispensers.create", compact("data"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|max:100',
            'identificator' => 'required|unique:dispensers,identificator',
            'station_id'    => 'required|integer'
        ]);

        $dispenser = new Dispenser();
        $dispenser->name = $request->name;
        $dispenser->identificator = $request->identificator;
        $dispenser->station_id = $request->station_id;
        $dispenser->save();

        return redirect("admin/dispensers");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dispenser  $dispenser
     * @return \Illuminate\Http\Response
     */
    public function show(Dispenser $dispenser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dispenser  $dispenser
     * @return \Illuminate\Http\Response
     */
    public function edit(Dispenser $dispenser)
    {
        return view("dispensers.edit", compact("dispenser"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dispenser  $dispenser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dispenser $dispenser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dispenser  $dispenser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dispenser $dispenser)
    {
        //
    }
}
