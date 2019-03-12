<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberPartner extends Model
{
    protected $fillable = [
        'email', 'phone', 'name', 'gender', 'birth_date', 'active',
    ];

    public function member()
    {
        return $this->hasOne('App\Member');
    }
}
