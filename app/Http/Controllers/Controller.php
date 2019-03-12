<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Utils;
use App\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function __construct() {
        // $this->middleware('auth:member');
        
    }   
    
    public function fetchCompanyInfo(){
        $res = Info::find(1)->country;
        if($res!=null && !empty($res)){
            Utils::$country = Info::find(1)->country;
        }else{
            Redirect::to('pageerror')->send();
        }
    }
    
}
