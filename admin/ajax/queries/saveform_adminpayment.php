<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$receiver_name = mysqli_real_escape_string($mysqli, $_POST['receiver_name']);
$payment_amount = mysqli_real_escape_string($mysqli, $_POST['payment_amount']);
$payment_date = mysqli_real_escape_string($mysqli, $_POST['payment_date']);
$payment_purpose = mysqli_real_escape_string($mysqli, $_POST['payment_purpose']);
$payment_description = mysqli_real_escape_string($mysqli, $_POST['payment_description']);
$datetime = date("Y-m-d H:i:s");

$mysqli->query("INSERT INTO `admin_taymac_payment`
            (
             `receiver_name`,
             `payment_amount`,
             `payment_date`,
             `payment_purpose`,
             `payment_description`,
             `dateupdated`)
VALUES (
        '$receiver_name',
        '$payment_amount',
        '$payment_date',
        '$payment_purpose',
        '$payment_description',
        '$datetime')") or die(mysqli_error($mysqli));


$mysqli->query("INSERT INTO `taymac_logs_mis`
            (`message`,
             `logdate`,
             `username`,
             `mac_address`,
             `ip_address`,
             `action`)
VALUES ('Added to payment',
        '$today',
        '$username',
        '$mac_address',
        '$ip_add',
        'Successful')") or die(mysqli_error($mysqli));

echo 1;
