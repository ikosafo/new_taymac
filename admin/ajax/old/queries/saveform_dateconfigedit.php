<?php
include('../../../config.php');

$date_started = mysqli_real_escape_string($mysqli, $_POST['date_started']);
$date_completed = mysqli_real_escape_string($mysqli, $_POST['date_completed']);
$reg_type = mysqli_real_escape_string($mysqli, $_POST['reg_type']);
$config_id = mysqli_real_escape_string($mysqli, $_POST['config_id']);

$datetime = date("Y-m-d H:i:s");

$mysqli->query("UPDATE `date_config`
SET
  `date_started` = '$date_started',
  `date_completed` = '$date_completed'

WHERE `id` = '$config_id'") or die(mysqli_error($mysqli));

echo 1;

?>