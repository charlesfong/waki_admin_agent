<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataUndangan extends Model
{
    protected $fillable = [
        'code', 'registration_date', 'name', 'birth_date', 'address', 'phone', 'active',
    ];

    public function history_undangan()
    {
        return $this->hasMany('App\HistoryUndangan');
    }
}
