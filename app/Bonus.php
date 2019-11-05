<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $keyType = 'string';

    public function fuels()
    {
        return $this->belongsTo("App\Fuel", "fuel_id");
    }
}
