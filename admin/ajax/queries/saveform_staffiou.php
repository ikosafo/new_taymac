<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$payment_for = mysqli_real_escape_string($mysqli, $_POST['payment_for']);
$payment_date = mysqli_real_escape_string($mysqli, $_POST['payment_date']);
$iou_amount = mysqli_real_escape_string($mysqli, $_POST['iou_amount']);
$theindex = mysqli_real_escape_string($mysqli, $_POST['theindex']);
$datetime = date("Y-m-d H:i:s");

$mysqli->query("INSERT INTO `admin_staff_iou`
            (
             `staff_id`,
             `payment_period`,
             `payment_date`,
             `payment_amount`,
             `dateupdated`)
VALUES (
        '$theindex',
        '$payment_for',
        '$payment_date',
        '$iou_amount',
        '$datetime')") or die(mysqli_error($mysqli));


$mysqli->query("INSERT INTO `taymac_logs_mis`
(`message`,
 `logdate`,
 `username`,
 `mac_address`,
 `ip_address`,
 `action`)
VALUES ('Added to staff (IOU)',
'$today',
'$username',
'$mac_address',
'$ip_add',
'Successful')") or die(mysqli_error($mysqli));

echo 1;
