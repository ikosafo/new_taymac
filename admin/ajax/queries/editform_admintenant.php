<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$tenant_name = mysqli_real_escape_string($mysqli, $_POST['tenant_name']);
$tenant_property = mysqli_real_escape_string($mysqli, $_POST['tenant_property']);
$date_started = mysqli_real_escape_string($mysqli, $_POST['date_started']);
$date_completed = mysqli_real_escape_string($mysqli, $_POST['date_completed']);
$tenant_telephone = mysqli_real_escape_string($mysqli, $_POST['tenant_telephone']);
$tenant_email = mysqli_real_escape_string($mysqli, $_POST['tenant_email']);
$tenant_description = mysqli_real_escape_string($mysqli, $_POST['tenant_description']);
$payment_rate = mysqli_real_escape_string($mysqli, $_POST['payment_rate']);
$theindex = mysqli_real_escape_string($mysqli, $_POST['theindex']);

$getpropertyid = $mysqli->query("select * from admin_taymac_property where property_name = '$tenant_property'");
$resid = $getpropertyid->fetch_assoc();
$propid = $resid['id'];

$mysqli->query("UPDATE `admin_taymac_tenant`
SET
  `tenant_name` = '$tenant_name',
  `tenant_property` = '$propid',
  `date_started` = '$date_started',
  `date_completed` = '$date_completed',
  `tenant_telephone` = '$tenant_telephone',
  `tenant_email` = '$tenant_email',
  `tenant_description` = '$tenant_description',
  `payment_rate` = '$payment_rate'

WHERE `id` = '$theindex'") or die(mysqli_error($mysqli));

$mysqli->query("INSERT INTO `taymac_logs_mis`
            (`message`,
             `logdate`,
             `username`,
             `mac_address`,
             `ip_address`,
             `action`)
VALUES ('Edited tenant information',
        '$today',
        '$username',
        '$mac_address',
        '$ip_add',
        'Successful')") or die(mysqli_error($mysqli));

echo 1;
