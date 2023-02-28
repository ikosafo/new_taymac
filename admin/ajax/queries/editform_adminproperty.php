<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$property_name = mysqli_real_escape_string($mysqli, $_POST['property_name']);
$property_type = mysqli_real_escape_string($mysqli, $_POST['property_type']);
$property_location = mysqli_real_escape_string($mysqli, $_POST['property_location']);
$property_address = mysqli_real_escape_string($mysqli, $_POST['property_address']);
$property_description = mysqli_real_escape_string($mysqli, $_POST['property_description']);
$theindex = mysqli_real_escape_string($mysqli, $_POST['theindex']);

$mysqli->query("UPDATE `admin_taymac_property`
SET
  `property_name` = '$property_name',
  `property_type` = '$property_type',
  `property_location` = '$property_location',
  `property_address` = '$property_address',
  `property_description` = '$property_description'

WHERE `id` = '$theindex'") or die(mysqli_error($mysqli));


$mysqli->query("INSERT INTO `taymac_logs_mis`
            (`message`,
             `logdate`,
             `username`,
             `mac_address`,
             `ip_address`,
             `action`)
VALUES ('Edited property',
        '$today',
        '$username',
        '$mac_address',
        '$ip_add',
        'Successful')") or die(mysqli_error($mysqli));

echo 1;
