<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentType extends Model
{
    
    public static $headquarter = 1;
    public static $subHeadquarter = 2;
    public static $parentAgent = 3;
    public static $subParentAgent = 4;
    public static $agentPublic = 5;
    
    protected $fillable = [
        'name', 'active', 
    ];

    public function member()
    {
        return $this->hasMany('App\Member');
    }
}
