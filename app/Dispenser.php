<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispenser extends Model
{
    public function stations()
    {
        return $this->belongsTo("App\Station", "station_id");
    }

    public function fuels()
    {
        return $this->hasMany("App\Fuel", "dispenser_id", "id");
    }
}
