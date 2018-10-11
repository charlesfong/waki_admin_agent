<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryUndangan extends Model
{
    protected $fillable = [
        'date', 'province', 'district', 'bank_id', 'branch_id', 'cso_id', 'type_cust_id', 'data_undangan_id', 'active', 
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

    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }
}
