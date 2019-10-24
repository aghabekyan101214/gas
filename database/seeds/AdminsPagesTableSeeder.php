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
            array("id" => GenerateRandomString::generate(), "name" => "admins"),
            array("id" => GenerateRandomString::generate(), "name" => "stations"),
            array("id" => GenerateRandomString::generate(), "name" => "dispensers"),
            array("id" => GenerateRandomString::generate(), "name" => "static-data"),
            array("id" => GenerateRandomString::generate(), "name" => "fuels"),
            array("id" => GenerateRandomString::generate(), "name" => "clients"),
            array("id" => GenerateRandomString::generate(), "name" => "bonuses"),
            array("id" => GenerateRandomString::generate(), "name" => "fuels-limit"),
        );
        Page::insert($data);
    }
}
