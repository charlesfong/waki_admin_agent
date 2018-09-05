<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeCust extends Model
{
    protected $fillable = [
        'name', 'type_input', 'active',
    ];

    public function dataTherapy()
    {
        return $this->hasMany('App\DataTherapy');
    }

    public function dataOutsite()
    {
        return $this->hasMany('App\DataOutsite');
    }

    public function historyUndangan()
    {
        return $this->hasMany('App\HistoryUndangan');
    }
}
