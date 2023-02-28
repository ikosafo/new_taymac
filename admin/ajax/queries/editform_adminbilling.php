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
$theindex = mysqli_real_escape_string($mysqli, $_POST['theindex']);
$billing_total = $billing_months * $billing_amount;

$gettenantid = $mysqli->query("select * from admin_taymac_tenant where tenant_name = '$billing_tenant'");
$resid = $gettenantid->fetch_assoc();
$tenantid = $resid['id'];

$mysqli->query("UPDATE `admin_taymac_billing`
SET
  `billing_type` = '$billing_type',
  `billing_type_other` = '$billing_type_other',
  `billing_tenant` = '$tenantid',
  `billing_currency` = '$billing_currency',
  `billing_period` = '$billing_period',
  `billing_amount` = '$billing_amount',
  `billing_months` = '$billing_months',
  `billing_date` = '$billing_date',
  `billing_delivered` = '$billing_delivered',
  `billing_description` = '$billing_description',
  `billing_total` = '$billing_total'


WHERE `id` = '$theindex'") or die(mysqli_error($mysqli));


$mysqli->query("INSERT INTO `taymac_logs_mis`
            (`message`,
             `logdate`,
             `username`,
             `mac_address`,
             `ip_address`,
             `action`)
VALUES ('Edited billing',
        '$today',
        '$username',
        '$mac_address',
        '$ip_add',
        'Successful')") or die(mysqli_error($mysqli));

echo 1;
