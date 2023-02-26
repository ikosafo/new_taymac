<?php
include('../../../config.php');

$otheractivity_name= mysqli_real_escape_string($mysqli, $_POST['otheractivity_name']);
$date_activity = mysqli_real_escape_string($mysqli, $_POST['date_activity']);
$activity_description = mysqli_real_escape_string($mysqli, $_POST['activity_description']);
$theindex = mysqli_real_escape_string($mysqli, $_POST['theindex']);
$datetime = date('Y-m-d H:i:s');

$mysqli->query("UPDATE `farm_otheractivity`
SET
  `activity` = '$otheractivity_name',
  `date_activity` = '$date_activity',
  `activity_description` = '$activity_description'

WHERE `id` = '$theindex'") or die(mysqli_error($mysqli));

echo 1;