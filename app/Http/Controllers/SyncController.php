<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Fuel;

class SyncController extends Controller
{
    private static $conn;
    private static $conn2;

    public function __construct()
    {
        self::$conn = DB::connection("mysql");
        self::$conn2 = DB::connection("mysql_2");
    }

    public static function start()
    {
        self::syncFuels();
    }

    private static function syncFuels()
    {
        $newUsers = self::$conn2->table("fuels")->where(["sync" => 0])->get();
        DB::beginTransaction();
        if(null != $newUsers) {
            self::$conn->table("users")->insert();
        }
        DB::commit();
    }



}
