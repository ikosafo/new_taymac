<?php
/**
 * Created by PhpStorm.
 * Date: 4/23/2018
 * Time: 9:46 AM
 */
class Redirecting {

    /**
     * @param $destinationurl
     */
    public static function location($destinationurl,$data=null,$name=null){
        if(is_null($data)){
        header('Location:'.URLROOT.'/'.$destinationurl);
        }else{
            $data=Encryption::lock($data);
            if(is_null($name)){ $name='data';}else{$name='error';}
            header('Location:'.URLROOT.'/'.$destinationurl.'?'.$name.'='.$data);
        }
    }

    public static function datalocation($destinationurl,$data=null,$array=null){
        $data=Encryption::lock($data);
        if(is_null($array)){
            header('Location:'.URLROOT.'/'.$destinationurl.'?data='.$data);
        }else{
        header('Location:'.URLROOT.'/'.$destinationurl.'?data='.$data.'&errorarray='.$array);
        }

    }
}