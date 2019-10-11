<?php

use Illuminate\Database\Seeder;
use App\Page;

class AdminsPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array("name" => "users"),
            array("name" => "stations"),
            array("name" => "dispensers"),
            array("name" => "static-data"),
            array("name" => "fuels"),
            array("name" => "clients"),
        );
        Page::insert($data);
    }
}
