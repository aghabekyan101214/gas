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
            'email' => 'admin' . '@gmail.com',
            'password' => bcrypt('admin'),
            'password_show' => 'admin',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
