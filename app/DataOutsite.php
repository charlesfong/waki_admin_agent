<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataOutsite extends Model
{
    protected $fillable = [
        'code', 'registration_date', 'name', 'phone', 'province', 'district', 'location_id', 'branch_id', 'cso_id', 'type_cust_id', 'active',
    ];

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    
    public function cso()
    {
        return $this->belongsTo('App\Cso');
    }

    public function type_cust()
    {
        return $this->belongsTo('App\TypeCust');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
