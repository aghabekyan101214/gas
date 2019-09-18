<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'surname' => "Super",
            'role' => 2,
            'age' => 100,
            'passport_number' => 111111111,
            'car_model' => "kawasaki",
            'vehicle_plate' => "13 DK 994",
            'identity_number' => 454545454454,
            'email' => 'admin' . '@gmail.com',
            'password' => bcrypt('admin'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
