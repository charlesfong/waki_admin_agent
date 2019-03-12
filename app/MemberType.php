<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberType extends Model
{
    
    public static $normal = 1;
    public static $guest = 2;
    public static $member = 3;
    public static $agent = 4;
    public static $vvip = 5;
    
    protected $fillable = [
        'name', 'active',
    ];

    public function member()
    {
        return $this->hasMany('App\Member');
    }
    public function price()
    {
        return $this->hasMany('App\Price');
    }
}
