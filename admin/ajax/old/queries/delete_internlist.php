<?php

include('../../../config.php');
$i_id = $_POST['i_index'];
$today = date("Y-m-d H:i:s");
$username = $_SESSION['username'];
$getpin = $mysqli->query("select * from internshiplist where internid = '$i_id'");
$respin = $getpin->fetch_assoc();
$thepin = $respin['pin'];

ob_start();
system('ipconfig /all');
$mycom = ob_get_contents();
ob_clean();
$findme = 'physique';
$pmac = strpos($mycom, $findme);
$mac_address = substr($mycom, ($pmac + 33), 17);

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}
$ip_add = getRealIpAddr();


$mysqli->query("INSERT INTO `logs_mis`
(`message`,
`logdate`,
`username`,
`mac_address`,
`ip_address`,
`action`)
VALUES ('Deleted an intern with PIN: $thepin',
'$today',
'$username',
'$mac_address',
'$ip_add',
'Successful')") or die(mysqli_error($mysqli));


$mysqli->query("delete from internshiplist where internid='$i_id'") or die(mysqli_error($mysqli));
