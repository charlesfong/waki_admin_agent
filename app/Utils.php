<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Utils extends Model
{
    //
    // country id, my, phl, th 
    public static $country = "my";
        
    public static function sendSms($destination, $text){
        $headers = [
            'Authorization' => 'Bearer x6qcavYzC2AEVj93s7YJmpMUoIGluiLyfqvKWuXIRU',
            'Content-Type' => 'application/json',
        ];
        $client = new \GuzzleHttp\Client();
       
        $body = '{ "source": "Wakimart", "destination": "'.$destination.'", "text": "'.$text.'", "encoding": "AUTO" }';
        
        $res = $client->post('https://api.wavecell.com/sms/v1/WAKimart_9eEBB_hq/single', [
            'headers' =>  $headers,
            'body' => $body
            ]);
    }
    
    public static function phoneNumberFormat($phone){
        $phone = preg_replace('/[^A-Za-z0-9\-]/', '', $phone);
        if($phone[0]==0){
           $phone =  substr($phone, 1); 
        }
        if($phone[0]=="0"){
           $phone =  substr($phone, 1); 
        }
        
        if(Utils::$country=='id'){
            if(substr($phone, 0, 2) != 62 || substr($phone, 0, 2) != "62"){
                $phone = "62".$phone;
            }
        }else if(Utils::$country=='my'){
            if(substr($phone, 0, 2) != 60 || substr($phone, 0, 2) != "60"){
                $phone = "60".$phone;
            }
        }else if(Utils::$country=='phl'){
            if(substr($phone, 0, 2) != 63 || substr($phone, 0, 2) != "63"){
                $phone = "63".$phone;
            }
        }else if(Utils::$country=='th'){
            if(substr($phone, 0, 2) != 66 || substr($phone, 0, 2) != "66"){
                $phone = "66".$phone;
            }
        }
        return $phone;
    }
    
    
    
    public static function getDefaultWakimartMemberId(){
        $id = '';
        if(Utils::$country=='id'){
            $id = 17;
        }else if(Utils::$country=='my'){
            $id = 522;
        }else if(Utils::$country=='phl'){
            
        }else if(Utils::$country=='th'){
            
        }
        
        $resId = Info::find(1)->default_referral_checkout_id;
        if($resId!=null && !empty($resId)){
            $id = $resId;
        }else{
            $id = $resId;
        }
        return $id;
    }
    
    public static function getWakimartEmail(){
        $email = '';
        if(Utils::$country=='id'){
            $email = 'wakimart.id@gmail.com';
        }else if(Utils::$country=='my'){
            $email = 'wakimart.ask1@gmail.com';
        }else if(Utils::$country=='phl'){
            
        }else if(Utils::$country=='th'){
            
        }
        $res = Info::find(1)->email;
        if($res!=null && !empty($res)){
            $email = $res;
        }else{
            $email = $res;
        }
        return $email;
    }
    public static function getWakimartEmailForCheckout(){
        $email = '';
        if(Utils::$country=='id'){
            $email = 'wakimart.id@gmail.com';
        }else if(Utils::$country=='my'){
            $email = 'wakimart.order1@gmail.com';
        }else if(Utils::$country=='phl'){
            
        }else if(Utils::$country=='th'){
            
        }
        $res = Info::find(1)->email_for_checkout;
        if($res!=null && !empty($res)){
            $email = $res;
        }else{
            $email = $res;
        }
        return $email;
    }
    
    public static function getWhatsapp(){
        $whatsapp = '';
        if(Utils::$country=='id'){
            $whatsapp = '6281234511881';
        }else if(Utils::$country=='my'){
            $whatsapp = '60165922059';
        }else if(Utils::$country=='phl'){
            
        }else if(Utils::$country=='th'){
            
        }
        $res = Info::find(1)->whatsapp;
        if($res!=null && !empty($res)){
            $whatsapp = $res;
        }else{
            $whatsapp = $res;
        }
        return $whatsapp;
    }
    public static function getFacebookLink(){
        $facebookLink = '';
        if(Utils::$country=='id'){
            $facebookLink = 'https://web.facebook.com/wakimart.id';
        }else if(Utils::$country=='my'){
            $facebookLink = 'https://web.facebook.com/wakimart';
        }else if(Utils::$country=='phl'){
            
        }else if(Utils::$country=='th'){
            
        }
        $res = Info::find(1)->facebook_link;
        if($res!=null && !empty($res)){
            $facebookLink = $res;
        }else{
            $facebookLink = $res;
        }
        return $facebookLink;
    }
    public static function getInstagramLink(){
        $instagram = '';
        if(Utils::$country=='id'){
            $instagram = 'https://www.instagram.com/wakimart.id/';
        }else if(Utils::$country=='my'){
            $instagram = 'https://www.instagram.com/wakimart/';
        }else if(Utils::$country=='phl'){
            
        }else if(Utils::$country=='th'){
            
        }
        $res = Info::find(1)->instagram_link;
        if($res!=null && !empty($res)){
            $instagram = $res;
        }else{
            $instagram = $res;
        }
        return $instagram;
    }
    public static function getBank(){
        $bank = '';
        if(Utils::$country=='id'){
            $bank = 'BCA';
        }else if(Utils::$country=='my'){
            $bank = 'CIMB';
        }else if(Utils::$country=='phl'){
            
        }else if(Utils::$country=='th'){
            
        }
        $res = Info::find(1)->bank;
        if($res!=null && !empty($res)){
            $bank = $res;
        }else{
            $bank = $res;
        }
        return $bank;
    }
    public static function getBankImage(){
        $bankImage = '';
        if(Utils::$country=='id'){
            $bankImage = 'https://ci4.googleusercontent.com/proxy/XPrtEk4Wo3VxKsGTkT1MlmvywHW4XuQEsJVVRQY28dLCXgLS8H733O6WRsUQVZ1BXUS3s75-fHRwyjAH=s0-d-e1-ft#https://ecs7.tokopedia.net/img/bca-va.png';
        }else if(Utils::$country=='my'){
            
        }else if(Utils::$country=='phl'){
            
        }else if(Utils::$country=='th'){
            
        }
        $res = Info::find(1)->bank_image;
        if($res!=null && !empty($res)){
            $bankImage = $res;
        }else{
            $bankImage = $res;
        }
        return $bankImage;
    }
    public static function getBankName(){
        $bankAccountName = '';
        if(Utils::$country=='id'){
            $bankAccountName = 'Waki Mandiri CV';
        }else if(Utils::$country=='my'){
            $bankAccountName = 'Waki Mart Sdn Bhd';
        }else if(Utils::$country=='phl'){
            
        }else if(Utils::$country=='th'){
            
        }
        $res = Info::find(1)->bank_account_name;
        if($res!=null && !empty($res)){
            $bankAccountName = $res;
        }else{
            $bankAccountName = $res;
        }
        return $bankAccountName;
    }
    public static function getBankAccountNo(){
        $bankAccountNo = '';
        if(Utils::$country=='id'){
            $bankAccountNo = '0871352088';
        }else if(Utils::$country=='my'){
            $bankAccountNo = '8009503752';
        }else if(Utils::$country=='phl'){
            
        }else if(Utils::$country=='th'){
            
        }
        $res = Info::find(1)->bank_account_no;
        if($res!=null && !empty($res)){
            $bankAccountNo = $res;
        }else{
            $bankAccountNo = $res;
        }
        return $bankAccountNo;
    }
}
