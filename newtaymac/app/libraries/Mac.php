<?php

class Mac {

    public $mac_address;

    public function __construct(){
        ob_start();
        system('ipconfig /all');
        $mycom=ob_get_contents();
        ob_clean();
        $findme = 'physique';
        $pmac = strpos($mycom, $findme);
        $this->mac_address = substr($mycom,($pmac+33),17);

    }
      public function getRealIpAddr()
        {
            if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
            {
                $ip_address=$_SERVER['HTTP_CLIENT_IP'];
            }
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
            {
                $ip_address=$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
                $ip_address=$_SERVER['REMOTE_ADDR'];
            }
            return $ip_address;

    }

    public function getMacAddress(){
        return $this->mac_address;
    }
}