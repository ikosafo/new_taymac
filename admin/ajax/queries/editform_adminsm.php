<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$sm_type = mysqli_real_escape_string($mysqli, $_POST['sm_type']);
$sm_type_other = mysqli_real_escape_string($mysqli, $_POST['sm_type_other']);
$sm_tenant = mysqli_real_escape_string($mysqli, $_POST['sm_tenant']);
$sm_currency = mysqli_real_escape_string($mysqli, $_POST['sm_currency']);
$sm_amount = mysqli_real_escape_string($mysqli, $_POST['sm_amount']);
$sm_date = mysqli_real_escape_string($mysqli, $_POST['sm_date']);
$sm_description = mysqli_real_escape_string($mysqli, $_POST['sm_description']);
$theindex = mysqli_real_escape_string($mysqli, $_POST['theindex']);

$gettenantid = $mysqli->query("select * from admin_taymac_tenant where tenant_name = '$sm_tenant'");
$resid = $gettenantid->fetch_assoc();
$tenantid = $resid['id'];

$mysqli->query("UPDATE `admin_taymac_sm`
SET
  `sm_type` = '$sm_type',
  `sm_type_other` = '$sm_type_other',
  `sm_tenant` = '$tenantid',
  `sm_currency` = '$sm_currency',
  `sm_amount` = '$sm_amount',
  `sm_date` = '$sm_date',
  `sm_description` = '$sm_description'


WHERE `id` = '$theindex'") or die(mysqli_error($mysqli));


$mysqli->query("INSERT INTO `taymac_logs_mis`
            (`message`,
             `logdate`,
             `username`,
             `mac_address`,
             `ip_address`,
             `action`)
VALUES ('Edited service and maintenance',
        '$today',
        '$username',
        '$mac_address',
        '$ip_add',
        'Successful')") or die(mysqli_error($mysqli));

echo 1;
