<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StaticData;

class StaticController extends Controller
{
    public function index()
    {
        $data = StaticData::first();
        return view("staticData.index", compact("data"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bonus' => 'required|numeric',
        ]);

        $data = StaticData::first();
        if(null == $data) {
            $data = new StaticData();
        }
        $data->bonus = $request->bonus;
        $data->save();

        return redirect("admin/static-data");
    }

}
