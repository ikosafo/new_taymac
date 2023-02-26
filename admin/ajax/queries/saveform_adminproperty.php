<?php
include('../../../config.php');

$property_name = mysqli_real_escape_string($mysqli, $_POST['property_name']);
$property_type = mysqli_real_escape_string($mysqli, $_POST['property_type']);
$property_location = mysqli_real_escape_string($mysqli, $_POST['property_location']);
$property_address = mysqli_real_escape_string($mysqli, $_POST['property_address']);
$property_description = mysqli_real_escape_string($mysqli, $_POST['property_description']);
$datetime = date("Y-m-d H:i:s");

$mysqli->query("INSERT INTO `admin_taymac_property`
            (`property_name`,
             `property_type`,
             `property_location`,
             `property_address`,
             `property_description`)
VALUES ('$property_name',
        '$property_type',
        '$property_location',
        '$property_address',
        '$property_description')") or die(mysqli_error($mysqli));

echo 1;
