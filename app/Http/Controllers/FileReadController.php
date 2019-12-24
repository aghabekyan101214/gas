<?php

namespace App\Http\Controllers;

use App\FileRead;
use App\Traits\GenerateRandomString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Dispenser;
use Illuminate\Database\Eloquent\Builder;
use App\Fuel;

class FileReadController extends Controller
{

    const PATH = "/home/karen/station/";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function start($count = 1)
    {
        $path = self::PATH;
        if($count > 10) return;
        if(!is_dir($path)) {
            return;
        }
        $files = scandir($path);
        \Log::info($files);
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
        $data = explode("\n", $data);
        if(isset($data[0])) {
            $dispenser = Dispenser::where("identificator", $data[0])->first();
            if(null == $dispenser) return;
            $fuel = new Fuel([
                "id" => GenerateRandomString::generate(),
                "dispenser_id" => $dispenser->id,
                "liter" => floatval($data[1]),
                "price" => floatval($data[2])
            ]);
            return $fuel->save();
        }
    }
}
