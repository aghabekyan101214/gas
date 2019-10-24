<?php

namespace App\Http\Controllers;

use App\Traits\GenerateRandomString;
use Illuminate\Http\Request;
Use App\User;
Use Auth;
use App\Station;
use Illuminate\Support\Facades\DB;
use App\Page;

class UserController extends Controller
{

    public function index()
    {
        $data["users"] = User::with("stations")->where('role', '!=', Auth::user()->role)->where('role', '!=', 1)->get();
        return view('user/index', compact("data"));
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
            "pages" => Page::all(),
        );
        return view('user/create', compact("data"));
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
            'password'          => 'required|min:6|max:255',
        ]);

        DB::beginTransaction();

//        generating random id for user because it didnt work with sync
        $userId = GenerateRandomString::generate();

        $user = new User();
        $user->id = $userId;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->password_show = $request->password;
        $user->role = 2;
        $user->save();

        if(null != $request->station_id) {
            foreach($request->station_id as $station_id) {

                DB::table("admins_stations")->insert([
                    "id" => GenerateRandomString::generate(),
                    "station_id" => $station_id,
                    "user_id" => $userId
                ]);
            }
        }
        if(null != $request->pages) {
            foreach($request->pages as $page) {

                DB::table("admins_pages")->insert([
                    "id" => GenerateRandomString::generate(),
                    "page_id" => $page,
                    "user_id" => $userId
                ]);
            }
        }

        DB::commit();

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
        $chosen = DB::table('admins_stations')->select("station_id")->where("user_id", $id)->get();
        $chosenPagesDb = DB::table('admins_pages')->select("page_id")->where("user_id", $id)->get();
        $chosenIds = [];
        $chosenPages = [];
        foreach ($chosen as $c) {
            $chosenIds[] = $c->station_id;
        }
        foreach ($chosenPagesDb as $c) {
            $chosenPages[] = $c->page_id;
        }
        $data = array(
            'result' => $admin,
            "stations" => Station::all(),
            "chosen" => $chosenIds,
            "pages" => Page::all(),
            "chosenPages" => $chosenPages
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
            'email'             => $user->email == $request->email ? 'required|max:255' : 'required|unique:users,email|max:255',
            'surname'           => 'required|max:255',
            'password'          => 'required|min:6|max:255',
        ]);

        DB::beginTransaction();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->surname = $request->surname;
        $user->password = bcrypt($request->password);
        $user->password_show = $request->password;
        $user->save();

        $user->stations()->detach();
        $user->pages()->detach();

        if(null != $request->station_id) {
            foreach($request->station_id as $station_id) {

                DB::table("admins_stations")->insert([
                    "id" => GenerateRandomString::generate(),
                    "station_id" => $station_id,
                    "user_id" => $id
                ]);
            }
        }
        if(null != $request->pages) {
            foreach($request->pages as $page) {

                DB::table("admins_pages")->insert([
                    "id" => GenerateRandomString::generate(),
                    "page_id" => $page,
                    "user_id" => $id
                ]);
            }
        }

        DB::commit();

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
