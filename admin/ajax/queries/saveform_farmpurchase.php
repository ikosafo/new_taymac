<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$fertilizer_name = mysqli_real_escape_string($mysqli, $_POST['fertilizer_name']);
$input_kg = mysqli_real_escape_string($mysqli, $_POST['input_kg']);
$input_g = mysqli_real_escape_string($mysqli, $_POST['input_g']);
$input_cost_f = mysqli_real_escape_string($mysqli, $_POST['input_cost_f']);
$input_type = mysqli_real_escape_string($mysqli, $_POST['input_type']);
$date_pf = mysqli_real_escape_string($mysqli, $_POST['date_pf']);

$mysqli->query("INSERT INTO `farm_purchases`
            (
             `item_name`,
             `input_kg`,
             `input_g`,
             `input_cost`,
             `input_type`,
             `date_pf`)
VALUES (
        '$fertilizer_name',
        '$input_kg',
        '$input_g',
        '$input_cost_f',
        '$input_type',
        '$date_pf')") or die(mysqli_error($mysqli));

$mysqli->query("INSERT INTO `taymac_logs_mis`
(`message`,
 `logdate`,
 `username`,
 `mac_address`,
 `ip_address`,
 `action`)
VALUES ('Added to farm purchases',
'$today',
'$username',
'$mac_address',
'$ip_add',
'Successful')") or die(mysqli_error($mysqli));

echo 1;
