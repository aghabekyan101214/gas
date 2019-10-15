<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class QrController extends Controller
{
    public function index($quantity, $count = 0)
    {
        if($count > $quantity) {
            return;
        }
        $qr = rand().uniqid().time();
        \QrCode::format("png")
            ->size(250)->errorCorrection('H')
            ->generate($qr, public_path('qr-codes/'.$qr.'.png'));
        $count ++;
        $this->index($quantity, $count);
        return $this->downloadZip();
    }

    private function downloadZip()
    {
        $headers = ["Content-Type"=>"application/zip"];
        $fileName = "qr-codes.zip"; // name of zip
        \Zipper::make(public_path('/documents/'.$fileName)) //file path for zip file
        ->add(public_path()."/qr-codes/")->close(); //files to be zipped
        $this->deleteGeneratedQrs();
        return response()
            ->download(public_path('/documents/'.$fileName),$fileName, $headers)
            ->deleteFileAfterSend();
    }

    private function deleteGeneratedQrs()
    {
        $files = scandir(public_path("qr-codes"));
        foreach ($files as $file) {
            if($file != "." && $file != "..") {
                unlink(public_path("qr-codes/$file"));
            }
        }
    }
}
