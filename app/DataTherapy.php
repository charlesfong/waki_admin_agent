<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataTherapy extends Model
{
    protected $fillable = [
        'code', 'registration_date', 'name', 'address', 'phone', 'province', 'district', 'branch_id', 'cso_id', 'type_cust_id', 'active',
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
}
