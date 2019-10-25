<?php

namespace App;

use App\Traits\GenerateRandomString;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'surname', 'age', 'identity_number', 'passport_number', 'car_model', 'vehicle_plate', 'email', 'password', 'role', 'password_show', 'station_id', 'sync'
//    ];
    protected $guarded = [];

    protected $keyType = 'string';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function stations()
    {
        return $this->belongsToMany("App\Station", "admins_stations", "user_id", "station_id");
    }

    public function pages()
    {
        return $this->belongsToMany("App\Page", "admins_pages", "user_id", "page_id");
    }
}
