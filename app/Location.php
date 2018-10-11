<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name', 'country', 'active', 
    ];

    public function dataOutsite()
    {
        return $this->hasMany('App\DataOutsite');
    }
}
