<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$pesticide_name = mysqli_real_escape_string($mysqli, $_POST['pesticide_name']);
$tunnel = mysqli_real_escape_string($mysqli, $_POST['tunnel']);
$product = mysqli_real_escape_string($mysqli, $_POST['product']);
$input_kg = mysqli_real_escape_string($mysqli, $_POST['input_kg']);
$input_g = mysqli_real_escape_string($mysqli, $_POST['input_g']);
$date_activity = mysqli_real_escape_string($mysqli, $_POST['date_activity']);
$activity_description = mysqli_real_escape_string($mysqli, $_POST['activity_description']);
$datetime = date('Y-m-d H:i:s');

$mysqli->query("INSERT INTO `farm_pesticide`
            (
             `pesticide_name`,
             `tunnel`,
             `product`,
             `input_kg`,
             `input_g`,
             `date_activity`,
             `activity_description`,
             `dateperiod`)
VALUES (
        '$pesticide_name',
        '$tunnel',
        '$product',
        '$input_kg',
        '$input_g',
        '$date_activity',
        '$activity_description',
        '$datetime'
        )") or die(mysqli_error($mysqli));


$mysqli->query("INSERT INTO `taymac_logs_mis`
(`message`,
 `logdate`,
 `username`,
 `mac_address`,
 `ip_address`,
 `action`)
VALUES ('Added to pesticides',
'$today',
'$username',
'$mac_address',
'$ip_add',
'Successful')") or die(mysqli_error($mysqli));

echo 1;
