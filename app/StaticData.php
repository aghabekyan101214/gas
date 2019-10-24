<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaticData extends Model
{
    protected $keyType = 'string';
    protected $table = "statics";
    protected $guarded = [];
}
