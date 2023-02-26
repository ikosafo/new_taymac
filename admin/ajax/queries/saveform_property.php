<?php
include('../../../config.php');

$property_status = mysqli_real_escape_string($mysqli, $_POST['property_status']);
$property_type = mysqli_real_escape_string($mysqli, $_POST['property_type']);
$property_location = mysqli_real_escape_string($mysqli, $_POST['property_location']);
$imageid = mysqli_real_escape_string($mysqli, $_POST['imageid']);
$datetime = date("Y-m-d H:i:s");

$mysqli->query("INSERT INTO `taymac_property`
            (`property_status`,
             `property_type`,
             `property_location`,
             `imageid`)
VALUES ('$property_status',
        '$property_type',
        '$property_location',
        '$imageid')") or die(mysqli_error($mysqli));

echo 1;
