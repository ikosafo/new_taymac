<?php
include('../../../config.php');

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

echo 1;
