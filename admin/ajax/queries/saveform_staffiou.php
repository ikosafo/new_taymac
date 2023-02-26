<?php
include('../../../config.php');

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

echo 1;
