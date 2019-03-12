<?php

namespace App;

/**
 * Description of Lang
 *
 * @author acer
 */
class Lang {

    public static function getEmailAlreadyRegistered(){
    
        $msg = "Email sudah terdaftar";

        return $msg;
    }
    
    public static function getPhoneMustBeNumber(){

        $msg = "Nomor telepon harus angka";

        return $msg;
    }
    
    public static function getPhoneNumberAlreadyRegistered(){

        $msg = "Nomor telepon sudah terdaftar";

        return $msg;
    }
    
    public static function getPasswordDoesntMatch(){

        $msg = "Password tidak cocok";

        return $msg;
    }
    
     public static function getPasswordMinimum8Char(){

        $msg = "Password minimal 8 karakter";

        return $msg;
    }
    
    public static function getIdCardAlreadyRegistered(){

        $msg = "NIK sudah terdaftar";

        return $msg;
    }
    
    public static function getIdCardMin6Character(){

        $msg = "NIK minimal 6 karakter";

        return $msg;
    }
    
    public static function getNameRequired(){

        $msg = "Nama harus terisi";

        return $msg;
    }
    
    public static function getPhoneRequired(){

        $msg = "Nomor telepon harus terisi";

        return $msg;
    }
    
    public static function getNikRequired(){

        $msg = "NIK harus terisi";

        return $msg;
    }
    
    public static function getAddressRequired(){

        $msg = "Tolong isi alamat anda.";

        return $msg;
    }
    
    
    public static function getGenderRequired(){

        $msg = "Tolong pilih jenis kelamin.";

        return $msg;
    }
    
    public static function getProvinceRequired(){
        $msg = "Provinsi harus terisi.";

        return $msg;
    }
    
    public static function getDistrictRequired(){

        $msg = "Kota harus diisi.";

        return $msg;
    }
    
    public static function getBirthdateRequired(){
        $msg = "Tanggal lahir harus teriisi.";

        return $msg;
    }
    
    public static function getZipcodeRequired(){
        $msg = "Please fill your poscode.";

        return $msg;
    }
}
