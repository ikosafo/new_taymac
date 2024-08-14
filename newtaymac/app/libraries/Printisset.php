<?php
class Printisset extends Encryption{

    public static function printing(){
     if(isset($_GET['data'])){
         $data=$_GET['data'];
         return parent::unlock($data);
     }else{
         return '';
     }
    }

    public static function error(){
        if(isset($_GET['error'])){
            $data=$_GET['error'];
            return parent::unlock($data);
        }else{
            return '';
        }
       }
}