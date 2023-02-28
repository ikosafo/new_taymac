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
$datetime = date("Y-m-d H:i:s");

$mysqli->query("INSERT INTO `admin_taymac_sm`
            (
             `sm_type`,
             `sm_type_other`,
             `sm_tenant`,
             `sm_currency`,
             `sm_amount`,
             `sm_date`,
             `sm_description`,
             `dateupdated`
             )
VALUES (
        '$sm_type',
        '$sm_type_other',
        '$sm_tenant',
        '$sm_currency',
        '$sm_amount',
        '$sm_date',
        '$sm_description',
        '$datetime'
        )") or die(mysqli_error($mysqli));


$mysqli->query("INSERT INTO `taymac_logs_mis`
                (`message`,
                `logdate`,
                `username`,
                `mac_address`,
                `ip_address`,
                `action`)
        VALUES ('Added to service and maintenance',
                '$today',
                '$username',
                '$mac_address',
                '$ip_add',
                'Successful')") or die(mysqli_error($mysqli));

echo 1;
