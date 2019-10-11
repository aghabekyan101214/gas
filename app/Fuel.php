<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    protected $guarded = [];

    public function clients()
    {
        return $this->belongsTo("App\Client", "client_id", "id");
    }

    public function dispensers()
    {
        return $this->belongsTo("App\Dispenser", "dispenser_id", "id");
    }

    public function bonuses()
    {
        return $this->hasOne("App\Bonus", "fuel_id", "id");
    }

}
