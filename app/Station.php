<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    public function users()
    {
        return $this->belongsToMany("App\User", "admins_stations", "station_id", "user_id");
    }
}
