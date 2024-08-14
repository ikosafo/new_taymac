<?php

namespace libraries;

class Api {

    private $apikey;
    
    public $returnJson;

    public function getApikey(){

        return $this->apikey;
    }

    public function setApikey($apiKey){
        $this->apikey = $apiKey;
        return $this;
    }

    public function retunJson($status,$data){

        $arr = ['status'=>$status,'result'=>$data];

        return json_encode($arr);
    }
}