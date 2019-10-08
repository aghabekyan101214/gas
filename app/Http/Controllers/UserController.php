<?php

namespace App\Http\Controllers;

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
        $data["users"] = User::with("stations")->where('role', '!=', Auth::user()->role)->get();
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

        $user = new User();
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->password_show = $request->password;
        $user->role = 2;
        $user->save();
        $user->stations()->sync($request->station_id);
        $user->pages()->sync($request->pages);

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
        $user->stations()->sync($request->station_id);
        $user->pages()->sync($request->pages);

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
