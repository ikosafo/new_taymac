<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$otheractivity_name = mysqli_real_escape_string($mysqli, $_POST['otheractivity_name']);
$date_activity = mysqli_real_escape_string($mysqli, $_POST['date_activity']);
$activity_description = mysqli_real_escape_string($mysqli, $_POST['activity_description']);
$datetime = date('Y-m-d H:i:s');

$mysqli->query("INSERT INTO `farm_otheractivity`
            (
             `activity`,
             `date_activity`,
             `activity_description`,
             `dateperiod`)
VALUES (
        '$otheractivity_name',
        '$date_activity',
        '$activity_description',
        '$datetime')") or die(mysqli_error($mysqli));

$mysqli->query("INSERT INTO `taymac_logs_mis`
(`message`,
 `logdate`,
 `username`,
 `mac_address`,
 `ip_address`,
 `action`)
VALUES ('Added to farm (other activities)',
'$today',
'$username',
'$mac_address',
'$ip_add',
'Successful')") or die(mysqli_error($mysqli));

echo 1;
