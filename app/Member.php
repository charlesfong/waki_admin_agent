<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\VerifyEmail;
use App\Notifications\MemberResetPasswordNotification;
use App\Utils;

class Member extends Authenticatable
{
    use Notifiable;

    protected $guard = 'member';

    protected $table = 'members';

    protected $fillable = [
        'code', 'email', 'nik','phone', 'name', 'password', 'address', 'province', 'district', 'zipcode', 'gender', 'birth_date', 'nik_image', 'active', 'member_type_id', 'agent_id', 'member_partner_id', 'agent_code', 'agent_type_id', 
    ];

    protected $hidden = ['password',  'remember_token'];

    public function cart()
    {
        return $this->hasMany('App\Cart');
    }
    public function review()
    {
        return $this->hasMany('App\Review');
    }
    public function member_type()
    {
        return $this->belongsTo('App\MemberType');
    }
    public function agent()
    {
        return $this->belongsTo('App\Member');
    }
    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }
    public function agent_type()
    {
        return $this->belongsTo('App\AgentType');
    }
    public function member_partner()
    {
        return $this->belongsTo('App\MemberPartner');
    }
    public function sendEmailVerificationNotification()
    {
        //$this->notify(new VerifyEmail); // my notification
    }
    
    public function sendRegistrationSuccess($member){
        $this->notify(new Notifications\MemberRegistrationSuccess($member));
        $pass = substr($member->nik,-6);
        Utils::sendSms($member->phone, "Wakimart \n"
                . "Register Success \n"
                . "your password is: ".$pass);
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MemberResetPasswordNotification($token));
    }
    
    public function agentChilds(){
        return $this->hasMany('App\Member','agent_id');
    }
}
