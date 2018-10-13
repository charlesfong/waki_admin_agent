<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'code', 'name', 'country', 'active',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function cso()
    {
        return $this->hasMany('App\Cso');
    }

    public function mpc()
    {
        return $this->hasMany('App\Mpc');
    }

    public function data_therapy()
    {
        return $this->hasMany('App\DataTherapy');
    }

    public function data_outsite()
    {
        return $this->hasMany('App\DataOutsite');
    }

    public function history_undangan()
    {
        return $this->hasMany('App\HistoryUndangan');
    }
}
