<?php
include('../../../config.php');

$currentpassword = mysqli_real_escape_string($mysqli, $_POST['currentpassword']);
$newpassword = mysqli_real_escape_string($mysqli, $_POST['newpassword']);
$password = md5($newpassword);
$compassword = md5($currentpassword);

$userid = $_SESSION['user_id'];
$getpassword = $mysqli->query("select * from taymac_mis_users where user_id = '$userid'");
$respassword = $getpassword->fetch_assoc();
$compassword2 = $respassword['password'];

if ($compassword == $compassword2) {

    $mysqli->query("UPDATE `taymac_mis_users`
SET `password` = '$password'

WHERE `user_id` = '$userid'") or die(mysqli_error($mysqli));
    echo 1;
}

else {
    echo 2;
}


