<?php
include('../../../config.php');

$header_text = mysqli_real_escape_string($mysqli, $_POST['header_text']);
$slider_text = mysqli_real_escape_string($mysqli, $_POST['slider_text']);
$property_status = mysqli_real_escape_string($mysqli, $_POST['property_status']);
$property_type = mysqli_real_escape_string($mysqli, $_POST['property_type']);
$property_location = mysqli_real_escape_string($mysqli, $_POST['property_location']);
$imageid = mysqli_real_escape_string($mysqli, $_POST['imageid']);
$datetime = date("Y-m-d H:i:s");

$mysqli->query("INSERT INTO `taymac_slider`
            (`header_text`,
             `slider_text`,
             `property_status`,
             `property_type`,
             `property_location`,
             `imageid`)
VALUES ('$header_text',
        '$slider_text',
        '$property_status',
        '$property_type',
        '$property_location',
        '$imageid')") or die(mysqli_error($mysqli));

echo 1;
