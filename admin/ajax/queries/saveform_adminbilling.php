<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$billing_type = mysqli_real_escape_string($mysqli, $_POST['billing_type']);
$billing_type_other = mysqli_real_escape_string($mysqli, $_POST['billing_type_other']);
$billing_tenant = mysqli_real_escape_string($mysqli, $_POST['billing_tenant']);
$billing_currency = mysqli_real_escape_string($mysqli, $_POST['billing_currency']);
$billing_period = mysqli_real_escape_string($mysqli, $_POST['billing_period']);
$billing_amount = mysqli_real_escape_string($mysqli, $_POST['billing_amount']);
$billing_months = mysqli_real_escape_string($mysqli, $_POST['billing_months']);
$billing_date = mysqli_real_escape_string($mysqli, $_POST['billing_date']);
$billing_delivered = mysqli_real_escape_string($mysqli, $_POST['billing_delivered']);
$billing_description = mysqli_real_escape_string($mysqli, $_POST['billing_description']);
$billing_total = $billing_months * $billing_amount;
$datetime = date("Y-m-d H:i:s");

$mysqli->query("INSERT INTO `admin_taymac_billing`
            (`billing_type`,
             `billing_type_other`,
             `billing_tenant`,
             `billing_currency`,
             `billing_period`,
             `billing_amount`,
             `billing_months`,
             `billing_date`,
             `billing_delivered`,
             `billing_description`,
             `billing_total`,
             `dateupdated`
             )
VALUES ('$billing_type',
        '$billing_type_other',
        '$billing_tenant',
        '$billing_currency',
        '$billing_period',
        '$billing_amount',
        '$billing_months',
        '$billing_date',
        '$billing_delivered',
        '$billing_description',
        '$billing_total',
        '$datetime'
        )") or die(mysqli_error($mysqli));

$mysqli->query("INSERT INTO `taymac_logs_mis`
        (`message`,
        `logdate`,
        `username`,
        `mac_address`,
        `ip_address`,
        `action`)
        VALUES ('Added to billing',
        '$today',
        '$username',
        '$mac_address',
        '$ip_add',
        'Successful')") or die(mysqli_error($mysqli));

echo 1;
