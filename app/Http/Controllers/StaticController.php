<?php

namespace App\Http\Controllers;

use App\Traits\GenerateRandomString;
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
            'filling_max_quantity' => 'required|integer',
        ]);

        $data = StaticData::first();
        if(null == $data) {
            $data = new StaticData();
            $data->id = GenerateRandomString::generate();
        }
        $data->bonus = $request->bonus;
        $data->filling_max_quantity = $request->filling_max_quantity;
        $data->save();

        return redirect("admin/static-data");
    }

}
