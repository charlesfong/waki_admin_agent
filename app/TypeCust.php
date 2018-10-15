<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeCust extends Model
{
    protected $fillable = [
        'name', 'type_input', 'active',
    ];

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
