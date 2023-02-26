<?php

include('../../../config.php');
$i_id=$_POST['i_index'];

$getdetails = $mysqli->query("select * from `account_login` where id = '$i_id'");
$resdetails = $getdetails->fetch_assoc();
$vemail = $resdetails['email_verified'];
if ($vemail == '0') {
    $mysqli->query("delete from `account_login` where id = '$i_id'") or die(mysqli_error($mysqli));
    echo 1;
}
else {
    echo 2;
}
