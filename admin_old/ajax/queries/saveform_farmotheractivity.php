<?php
include('../../../config.php');

$otheractivity_name= mysqli_real_escape_string($mysqli, $_POST['otheractivity_name']);
$date_activity = mysqli_real_escape_string($mysqli, $_POST['date_activity']);
$activity_description = mysqli_real_escape_string($mysqli, $_POST['activity_description']);
$datetime = date('Y-m-d H:i:s');

$mysqli->query("INSERT INTO `farm_otheractivity`
            (
             `activity`,
             `date_activity`,
             `activity_description`,
             `dateperiod`)
VALUES (
        '$otheractivity_name',
        '$date_activity',
        '$activity_description',
        '$datetime')") or die(mysqli_error($mysqli));

echo 1;