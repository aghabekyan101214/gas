<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SyncController extends Controller
{
    private static $conn;

    public function __construct()
    {
        self::$conn = DB::connection("mysql_2");
    }

    public static function start()
    {
        $d = self::$conn->table("users")->paginate(50);
        dd($d);
    }

}
