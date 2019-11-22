<?php

use Illuminate\Database\Seeder;
use App\Page;
use App\Traits\GenerateRandomString;

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
            array("id" => 1, "name" => "admins"),
            array("id" => 2, "name" => "stations"),
            array("id" => 3, "name" => "dispensers"),
            array("id" => 4, "name" => "static-data"),
            array("id" => 5, "name" => "fuels"),
            array("id" => 6, "name" => "clients"),
            array("id" => 7, "name" => "bonuses"),
            array("id" => 8, "name" => "redeems"),
            array("id" => 9, "name" => "fuels-limit"),
        );
        Page::insert($data);
    }
}
