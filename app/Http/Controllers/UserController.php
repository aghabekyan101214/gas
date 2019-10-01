<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\User;
Use Auth;
use App\Station;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{

    public function index()
    {
        $data["users"] = User::with("stations")->where('role', '!=', Auth::user()->role)->get();
        return view('User/index', compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $data = array(
            "stations" => Station::all(),
        );
        return view('User/create', compact("data"));
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
            'name'              => 'required|max:255',
            'email'             => 'required|unique:users,email|max:255',
            'surname'           => 'required|max:255',
            'station_id'        => 'required|integer',
            'password'          => 'required|min:6|max:255',
        ]);

        User::create( [
            'name'              =>  $request->name,
            'surname'           =>  $request->surname,
            'email'             =>  $request->email,
            'station_id'        =>  $request->station_id,
            'password'          =>  bcrypt('password'),
            'password_show'     =>  $request->password,
            'role'              =>  2
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
        $admin = User::with("stations")->findOrFail($id);
        $data = array(
            'result' => $admin,
            "stations" => Station::all(),
        );
        return view('user.edit', compact("data"));
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
        $user = User::findOrFail($id);

        $request->validate([
            'name'              => 'required|max:255',
            'email'             => $user->email == $request->email ? 'required|max:255' : 'required|max:255|unique:users,email',
            'surname'           => 'required|max:255',
            'station_id'        => 'required|integer',
            'password'          => 'required|min:6|max:255',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->surname = $request->surname;
        $user->station_id = $request->station_id;
        $user->password = bcrypt('password');
        $user->password_show = $request->password;
        $user->save();

       return redirect("/admin/users");
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
