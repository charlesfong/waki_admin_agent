<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $table = 'info';

    protected $fillable = [
        'country', 'email', 'email_for_checkout', 'phone', 'whatsapp', 
        'facebook_link', 'instagram_link', 'bank', 'bank_image', 
        'bank_account_name', 'bank_account_no',
    ];
    
}
