<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryUndangan extends Model
{
    protected $fillable = [
        'date', 'bank_name', 'province', 'district', 'branch_id', 'cso_id', 'type_cust_id', 'data_undangan_id', 'active', 
    ];

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    
    public function cso()
    {
        return $this->belongsTo('App\Cso');
    }

    public function typeCust()
    {
        return $this->belongsTo('App\TypeCust');
    }

    public function dataUndangan()
    {
        return $this->belongsTo('App\DataUndangan');
    }
}
