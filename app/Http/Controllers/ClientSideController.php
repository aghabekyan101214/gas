<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientSideController extends Controller
{
    public function index()
    {
        return view("clientSide.index");
    }

    public function getCLientByQr(Request $request)
    {
        $client = Client::where("qr", $request->qr)->first();
        if(null != $client) {
            return view("clientSide.getClient", compact("client"));
        }
        return 0;
    }
}
