<?php
include('../../../config.php');

$fp_description = mysqli_real_escape_string($mysqli, $_POST['fp_description']);
$property_status = mysqli_real_escape_string($mysqli, $_POST['property_status']);
$property_type = mysqli_real_escape_string($mysqli, $_POST['property_type']);
$property_location = mysqli_real_escape_string($mysqli, $_POST['property_location']);
$imageid = mysqli_real_escape_string($mysqli, $_POST['imageid']);
$datetime = date("Y-m-d H:i:s");

$mysqli->query("INSERT INTO `taymac_fp`
            (
            `fp_description`,
             `property_status`,
             `property_type`,
             `property_location`,
             `imageid`)
VALUES ('$fp_description',
        '$property_status',
        '$property_type',
        '$property_location',
        '$imageid')") or die(mysqli_error($mysqli));

echo 1;
