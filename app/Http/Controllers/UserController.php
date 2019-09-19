<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\User;
Use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["title"] = "Users";
        $data["users"] = User::where('role', '!=', Auth::user()->role)->get();
        return view('User/index', compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('User/create');
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
            'age'               => 'required|numeric|max:255',
            'name'              => 'required|max:255',
            'email'             => 'required|unique:users,email|max:255',
            'surname'           => 'required|max:255',
            'car_model'         => 'required|max:255',
            'vehicle_plate'     => 'required|max:255',
            'identity_number'   => 'required|max:255',
            'passport_number'   => 'required|max:255',
        ]);

        User::create( [
            'name'              =>  $request->name,
            'surname'           =>  $request->surname,
            'email'             =>  $request->email,
            'age'               =>  $request->age,
            'identity_number'   =>  $request->identity_number,
            'passport_number'   =>  $request->passport_number,
            'car_model'         =>  $request->car_model,
            'vehicle_plate'     =>  $request->vehicle_plate,
            'password'          =>  bcrypt('password'),
        ] );

        return redirect('/admin/users');
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
        dd($id);
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
