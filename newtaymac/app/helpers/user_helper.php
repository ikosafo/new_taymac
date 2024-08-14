<?php


// This function helps to generate API keys

function generateApikey($id){

    mt_srand((double)microtime()*10000);
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $hyphen = chr(45);
    $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
    $guid = $uuid.'-'.$id;
    $str = array("{", "}");
    return str_replace($str, "", $guid);


}


//This function redirects users
function redirect($destinationurl){
    header('Location:'.URLROOT.'/'.$destinationurl);
}

// check user status (active or inactive)
function checkStatus($status){
    if($status == 1) echo 'Active'; else echo 'Locked';
}

function checkActiveStatus($status){
  if($status == 'true'){
      echo "checked='checked'";
  }
}
// check admin status where admin or superadmin
function checkAdminStatus($adminstatus){
    if($adminstatus > 1){
        echo "checked='checked'";
    }
}

function checkapistatus($value){
    if($value ==  '1'){
        echo "checked='checked'";
    }
}

// generate inital passwords for new users
function randomPassword() {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $characters .= "!$%&=?#@";
    $pass = array(); //remember to declare $pass as an array
    $charLength = strlen($characters) - 1; //put the length -1 in cache
    for ($i = 0; $i < 10; $i++) {
        $n = rand(0, $charLength);
        $pass[] = $characters[$n];
    }
    return implode($pass).rand(0,9); //turn the array into a string
}

function checkpasswordstrength($pwd) {
     $message  = [];

    if (strlen($pwd) < 10) {
        $message[] = "Minimum of 10 characters required";
    }
    if (!preg_match("#[0-9]+#", $pwd)) {
        $message[]= "Password must include at least one number";
    }
    if (!preg_match("#[a-zA-Z]+#", $pwd)) {
        $message []= "Password must include at least one letter";
    }
    if (!preg_match("#[A-Z]#", $pwd)) {
        $message []= "Password must include at least one uppercase letter";
    }
    if (!preg_match("#[\W]+#", $pwd)) {
        $message []= "Password must include at least one special character";
    }
    else{
       $message  = 'Success';
    }

    return $message ;
}


function accountType($isprimary){
    if($isprimary == 1){
        return 'Primary Account';
    }
    if($isprimary == null){
        return 'Secondary Account';
    }
}

?>
