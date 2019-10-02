<?php

namespace App\Http\Controllers;

use App\FileRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Dispenser;
use Illuminate\Database\Eloquent\Builder;
use App\Fuel;
use mysql_xdevapi\Exception;

class FileReadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function start($count = 1)
    {
        $path = public_path("info/station$count/");
        if(!is_dir($path)) {
            return;
        }
        $files = scandir($path);

        foreach ($files as $file) {
            if($file != "." && $file != "..") {
                (new self())->read($path.$file);
            }
        }

        $count++;
        self::start($count);
    }

    private function read($filePath)
    {
        $myFile = fopen($filePath, "r");
        $data = fread($myFile, filesize($filePath));
        fclose($myFile);
        if(null != $data || $data) {
            $insert = $this->insert($data);
            if($insert) unlink($filePath);
        }
    }

    private function insert($data)
    {
        $data = explode(" ", $data);
        if(isset($data[0])) {
            $dispenser = Dispenser::where("identificator", $data[0])->first();
            $fuel = new Fuel([
                "dispenser_id" => $dispenser->id,
                "liter" => $data[1],
                "price" => $data[2]
            ]);
            return $fuel->save();
        }
    }
}
