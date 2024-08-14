<?php
class Encryption{


    public static function lock($input){
        $key="abcdefgh123456";
        $output=base64_encode(base64_encode(base64_encode($input)));
        return $output;
    }

    public static function unlock($input){
        $key="abcdefgh123456";
        $output=base64_decode(base64_decode(base64_decode($input)));
        return $output;
    }
}