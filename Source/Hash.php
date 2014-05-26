<?php
class Hash {
    public static function make($string, $salt = ''){
        return hash('sha256', $string, $salt);
    }

    // max of 22 length
    public static function salt($length){
        return substr(uniqid('', true), 0, $length);
    }

    public static function unique(){
        return self::make(uniqid());
    }
}