<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            "clients" => Client::orderBy("id", "desc")->get(),
        );
        return view("clients.index", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("clients.create");
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
            'name'    => 'required|max:70',
            'surname' => 'required|max:100',
            'qr'      => 'required|unique:clients,qr'
        ]);

        $client = new Client();
        $client->name = $request->name;
        $client->surname = $request->surname;
        $client->birthday = $request->birthday !== null ? strtotime($request->birthday) : null;
        $client->car = $request->car;
        $client->license_plate = $request->license_plate;
        $client->qr = $request->qr;
        $client->save();

        return redirect("admin/clients");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view("clients.edit", compact("client"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name'    => 'required|max:70',
            'surname' => 'required|max:100',
            'qr'      => $client->qr == $request->qr ? 'required' : 'required|unique:clients,qr',
        ]);

        $client->name = $request->name;
        $client->surname = $request->surname;
        $client->birthday = $request->birthday !== null ? strtotime($request->birthday) : null;
        $client->car = $request->car;
        $client->license_plate = $request->license_plate;
        $client->qr = $request->qr;
        $client->save();

        return redirect("admin/clients");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }

}
