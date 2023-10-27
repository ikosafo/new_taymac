<?php
include("../../../config.php");

$username = $_POST['username'];
$currentpass = $_POST['currentpassword'];
$currentpassword = md5($currentpass);
$newpass = $_POST['newpassword'];
$confirmpass = $_POST['confirmpassword'];
$newpassword = md5($newpass);

$res = $mysqli->query("SELECT * FROM taymac_mis_users WHERE `username` = '$username'
                                       AND `password` = '$currentpassword'");
$getdetails = $res->fetch_assoc();
$rowcount = mysqli_num_rows($res);
$today = date("Y-m-d H:i:s");

if ($newpass != $confirmpass) {
    echo 3;
} else if ($rowcount == "0") {
    $mysqli->query("INSERT INTO `taymac_logs_mis`
            (`message`,
             `logdate`,
             `username`,
             `mac_address`,
             `ip_address`,
             `action`)
VALUES ('Could not reset password',
        '$today',
        '$username',
        '$mac_address',
        '$ip_add',
        'Failed')") or die(mysqli_error($mysqli));
    echo 2;
} else {

    $mysqli->query("UPDATE `taymac_mis_users`
    SET `password` = '$newpassword'
    WHERE `username` = '$username'");

    $mysqli->query("INSERT INTO `taymac_logs_mis`
            (`message`,
             `logdate`,
             `username`,
             `mac_address`,
             `ip_address`,
             `action`)
VALUES ('Reset Password Successfully',
        '$today',
        '$username',
        '$mac_address',
        '$ip_add',
        'Successful')") or die(mysqli_error($mysqli));
    echo 1;
}
