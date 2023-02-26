<?php

include('../../../config.php');
$i_id=$_POST['i_index'];
$today = date("Y-m-d H:i:s");
$username = $_SESSION['username'];

ob_start();
system('ipconfig /all');
$mycom=ob_get_contents();
ob_clean();
$findme = 'physique';
$pmac = strpos($mycom, $findme);
$mac_address = substr($mycom,($pmac+33),17);

function getRealIpAddr()
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
$ip_add = getRealIpAddr();

$getdetails = $mysqli->query("select * from `provisional` where provisionalid = '$i_id'");
$resdetails = $getdetails->fetch_assoc();
$applicant_id = $resdetails['applicant_id'];


if ($username == 'sey') {

    $mysqli->query("INSERT INTO deleted
    SELECT * FROM provisional
    WHERE provisionalid = '$i_id'");
    
    $mysqli->query("INSERT INTO `deleted_reg`
    (`user`,
    `appdeleted`,
    `applicant_id`,
    `datetime`,
    `reg_type`)
    VALUES (
    '$username',
    '$i_id',
    '$applicant_id',
    '$today',
    'Permanent')") or die(mysqli_error($mysqli));
    
    
    
    $mysqli->query("INSERT INTO `logs_mis`
    (`message`,
    `logdate`,
    `username`,
    `mac_address`,
    `ip_address`,
    `action`)
    VALUES ('Deleted Permanent registration for applicant with Applicant ID $applicant_id',
    '$today',
    '$username',
    '$mac_address',
    '$ip_add',
    'Successful')") or die(mysqli_error($mysqli));
    
    
    $mysqli->query("DELETE FROM `provisional` WHERE provisionalid = '$i_id'") or die(mysqli_error($mysqli));

    echo 1;


}

else {

        $mysqli->query("INSERT INTO `logs_mis`
        (`message`,
        `logdate`,
        `username`,
        `mac_address`,
        `ip_address`,
        `action`)
        VALUES ('Attempted to delete Permanent registration for applicant with Applicant ID $applicant_id',
        '$today',
        '$username',
        '$mac_address',
        '$ip_add',
        'Failed')") or die(mysqli_error($mysqli));
        echo 2;
}


