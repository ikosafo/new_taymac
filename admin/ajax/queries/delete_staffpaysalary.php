<?php
include('../../../config.php');
$id = $_POST['i_index'];
$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];

$mysqli->query("delete from admin_staff_salary where id = '$id'") or die(mysqli_error($mysqli));

$mysqli->query("INSERT INTO `taymac_logs_mis`
            (`message`,
             `logdate`,
             `username`,
             `mac_address`,
             `ip_address`,
             `action`)
VALUES ('Deleted staff pay Salary',
        '$today',
        '$username',
        '$mac_address',
        '$ip_add',
        'Successful')") or die(mysqli_error($mysqli));

echo 1;
