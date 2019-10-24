<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Fuel;

class SyncController extends Controller
{
    private static $conn;
    private static $conn2;

    const FUELS_TABLE = "fuels";

    public function __construct()
    {
        self::$conn = DB::connection("mysql");
        self::$conn2 = DB::connection("mysql_2");
    }

    public static function start()
    {
        DB::beginTransaction();
        self::syncFuels();
        DB::commit();
    }

    private static function syncFuels()
    {
        $fuelsModel = self::$conn->table(self::FUELS_TABLE)->where(["sync" => 0]);
        $newFuels = $fuelsModel->get(["dispenser_id", "client_id", "liter", "price", "created_at", "updated_at"]);

        if(null != $newFuels) {
            foreach ($newFuels as $fuel) {
                self::$conn2->table(self::FUELS_TABLE)->insert((array) $fuel);
            }
            $fuelsModel->update(['sync' => 1]);
        }
    }



}
