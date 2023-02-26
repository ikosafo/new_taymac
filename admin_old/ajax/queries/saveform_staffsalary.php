<?php
include('../../../config.php');

$payment_for = mysqli_real_escape_string($mysqli, $_POST['payment_for']);
$payment_date = mysqli_real_escape_string($mysqli, $_POST['payment_date']);
$gross_salary = mysqli_real_escape_string($mysqli, $_POST['gross_salary']);
$allowance = mysqli_real_escape_string($mysqli, $_POST['allowance']);
$overtime = mysqli_real_escape_string($mysqli, $_POST['overtime']);
$compensation = mysqli_real_escape_string($mysqli, $_POST['compensation']);
$iou_salary = mysqli_real_escape_string($mysqli, $_POST['iou_salary']);
$income_tax = mysqli_real_escape_string($mysqli, $_POST['income_tax']);
$ssnit = mysqli_real_escape_string($mysqli, $_POST['ssnit']);
$welfare = mysqli_real_escape_string($mysqli, $_POST['welfare']);
$theindex = mysqli_real_escape_string($mysqli, $_POST['theindex']);

$credit = $gross_salary + $allowance + $overtime + $compensation;
$debit = $iou_salary + $income_tax + $ssnit + $welfare;
$total = $credit - $debit;

$datetime = date("Y-m-d H:i:s");

$mysqli->query("INSERT INTO `admin_staff_salary`
            (
             `staff_id`,
             `payment_period`,
             `payment_date`,
             `dateupdated`,
             `gross_salary`,
             `allowance`,
             `overtime`,
             `compensation`,
             `iou_salary`,
             `income_tax`,
             `ssnit`,
             `welfare`,
             `total`)
VALUES (
        '$theindex',
        '$payment_for',
        '$payment_date',
        '$datetime',
        '$gross_salary',
        '$allowance',
        '$overtime',
        '$compensation',
        '$iou_salary',
        '$income_tax',
        '$ssnit',
        '$welfare',
        '$total')") or die(mysqli_error($mysqli));

echo 1;
