<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'name', 'active',
    ];

    public function historyUndangan()
    {
        return $this->hasMany('App\HistoryUndangan');
    }
}
