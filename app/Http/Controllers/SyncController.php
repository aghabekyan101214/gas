<?php

namespace App\Http\Controllers;

use App\Bonus;
use App\Client;
use App\Dispenser;
use App\Station;
use Illuminate\Support\Facades\DB;
use App\Fuel;
use App\User;
use Illuminate\Support\Facades\Log;

class SyncController extends Controller
{
    private static $conn;
    private static $conn2;

    const NOT_SYNCHRONIZED = 0;
    const SYNCHRONIZED = 1;
//    tables
    const FUELS_TABLE = "fuels";
    const USERS_TABLE = "users";
    const STATIONS_TABLE = "stations";
    const DISPENSERS_TABLE = "dispensers";
    const CLIENTS_TABLE = "clients";
    const BONUSES_TABLE = "bonuses";

    public function __construct()
    {
        self::$conn = DB::connection("mysql");
        self::$conn2 = DB::connection("mysql_2");
    }

    public static function start()
    {
        DB::beginTransaction();
        $self = new self();
        $self->syncUsers();
        $self->syncStations();
        $self->syncDispensers();
        $self->syncClients();
        $self->syncUpdateClients();
        $self->syncFuels();
        $self->syncBonuses();
        $self->syncUpdateFuels();
        DB::commit();
    }

    private function syncUsers()
    {
        $data = User::where("sync", self::NOT_SYNCHRONIZED);
        $users = $data->get();
        if (null != $users->first()) {
            try {

                foreach ($users as $user) {

                    self::$conn2->table(self::USERS_TABLE)->insert([
                        "id" => $user->id,
                        "name" => $user->name,
                        "surname" => $user->surname,
                        "email" => $user->email,
                        "role" => $user->role,
                        "password" => $user->password,
                        "password_show" => $user->password_show,
                        "sync" => $user->sync,
                        "remember_token" => $user->remember_token,
                        "created_at" => $user->created_at,
                        "updated_at" => $user->updated_at,
                    ]);

                }
                $data->update(["sync" => self::SYNCHRONIZED, "updated_at" => $user->updated_at]);
                \Log::info("Users Table Synchronized");
            } catch (\Exception $exception) {
                Log::info($exception);
            }
        }
    }

    private function syncStations()
    {
        $data = Station::where("sync", self::NOT_SYNCHRONIZED);
        $stations = $data->get();
        if (null != $stations->first()) {
            try {

                foreach ($stations as $station) {

                    self::$conn2->table(self::STATIONS_TABLE)->insert([
                        "id" => $station->id,
                        "name" => $station->name,
                        "created_at" => $station->created_at,
                        "updated_at" => $station->updated_at,
                    ]);

                }
                $data->update(["sync" => self::SYNCHRONIZED, "updated_at" => $station->updated_at]);
                \Log::info("Stations Table Synchronized");
            } catch (\Exception $exception) {
                Log::info($exception);
            }
        }

    }

    private function syncDispensers()
    {
        $data = Dispenser::where("sync", self::NOT_SYNCHRONIZED);
        $dispensers = $data->get();
        if (null != $dispensers->first()) {
            try {

                foreach ($dispensers as $dispenser) {

                    self::$conn2->table(self::DISPENSERS_TABLE)->insert([
                        "id" => $dispenser->id,
                        "name" => $dispenser->name,
                        "identificator" => $dispenser->identificator,
                        "station_id" => $dispenser->station_id,
                        "created_at" => $dispenser->created_at,
                        "updated_at" => $dispenser->updated_at,
                    ]);

                }
                $data->update(["sync" => self::SYNCHRONIZED, "updated_at" => $dispenser->updated_at]);
                \Log::info("Dispensers Table Synchronized");
            } catch (\Exception $exception) {
                Log::info($exception);
            }
        }
    }

    private function syncClients()
    {
        $data = Client::where("sync", self::NOT_SYNCHRONIZED);
        $clients = $data->get();
        if (null != $clients->first()) {
            try {

                foreach ($clients as $client) {

                    self::$conn2->table(self::CLIENTS_TABLE)->insert([
                        "id" => $client->id,
                        "name" => $client->name,
                        "surname" => $client->surname,
                        "birthday" => $client->birthday,
                        "car" => $client->car,
                        "license_plate" => $client->license_plate,
                        "bonus" => $client->bonus,
                        "qr" => $client->qr,
                        "passport" => $client->passport,
                        "created_at" => $client->created_at,
                        "updated_at" => $client->updated_at,
                    ]);

                }
                $data->update(["sync" => self::SYNCHRONIZED, "updated_at" => $client->updated_at]);
                \Log::info("Clients Table Synchronized");
            } catch (\Exception $exception) {
                Log::info($exception);
            }
        }
    }

    private function syncUpdateClients()
    {
        $data = Client::where("sync", self::SYNCHRONIZED)->whereColumn('updated_at', '>', 'created_at');
        $clients = $data->get();
        if (null != $clients->first()) {
            try {

                foreach ($clients as $client) {

                    self::$conn2->table(self::CLIENTS_TABLE)->where("id", $client->id)->update([
                        "name" => $client->name,
                        "surname" => $client->surname,
                        "birthday" => $client->birthday,
                        "car" => $client->car,
                        "license_plate" => $client->license_plate,
                        "bonus" => $client->bonus,
                        "qr" => $client->qr,
                        "passport" => $client->passport,
                        "created_at" => $client->created_at,
                        "updated_at" => $client->updated_at,
                    ]);

                }
                $data->update(["sync" => self::SYNCHRONIZED, "updated_at" => $client->created_at]);
                \Log::info("Clients Table Updated");
            } catch (\Exception $exception) {
                Log::info($exception);
            }
        }
    }

    private function syncFuels()
    {
        $data = Fuel::where("sync", self::NOT_SYNCHRONIZED);
        $fuels = $data->get();
        if (null != $fuels->first()) {
            try {

                foreach ($fuels as $fuel) {

                    self::$conn2->table(self::FUELS_TABLE)->insert([
                        "id" => $fuel->id,
                        "dispenser_id" => $fuel->dispenser_id,
                        "client_id" => $fuel->client_id,
                        "liter" => $fuel->liter,
                        "price" => $fuel->price,
                        "created_at" => $fuel->created_at,
                        "updated_at" => $fuel->updated_at,
                    ]);

                }
                $data->update(["sync" => self::SYNCHRONIZED, "updated_at" => $fuel->updated_at]);
                \Log::info("Fuels Table Synchronized");
            } catch (\Exception $exception) {
                Log::info($exception);
            }
        }
    }

    private function syncBonuses()
    {
        $data = Bonus::where("sync", self::NOT_SYNCHRONIZED);
        $bonuses = $data->get();
        if (null != $bonuses->first()) {
            try {

                foreach ($bonuses as $bonus) {

                    self::$conn2->table(self::BONUSES_TABLE)->insert([
                        "id" => $bonus->id,
                        "bonus" => $bonus->bonus,
                        "fuel_id" => $bonus->fuel_id,
                        "created_at" => $bonus->created_at,
                        "updated_at" => $bonus->updated_at,
                    ]);

                }
                $data->update(["sync" => self::SYNCHRONIZED, "updated_at" => $bonus->updated_at]);
                \Log::info("Bonuses Table Synchronized");
            } catch (\Exception $exception) {
                Log::info($exception);
            }
        }
    }

    private function syncUpdateFuels()
    {
        $data = Fuel::where("sync", self::SYNCHRONIZED)->whereColumn('updated_at', '>', 'created_at');
        $fuels = $data->get();
        if (null != $fuels->first()) {
            try {

                foreach ($fuels as $fuel) {

                    self::$conn2->table(self::FUELS_TABLE)->where("id", $fuel->id)->update([
                        "dispenser_id" => $fuel->dispenser_id,
                        "client_id" => $fuel->client_id,
                        "liter" => $fuel->liter,
                        "price" => $fuel->price,
                        "created_at" => $fuel->created_at,
                        "updated_at" => $fuel->updated_at,
                    ]);

                }
                $data->update(["sync" => self::SYNCHRONIZED, "updated_at" => $fuel->created_at]);
                \Log::info("Fuels Table Updated");
            } catch (\Exception $exception) {
                Log::info($exception);
            }
        }
    }


}
