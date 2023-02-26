<?php
include('../../../config.php');

$funnel_name = mysqli_real_escape_string($mysqli, $_POST['funnel_name']);
$funnel_description = mysqli_real_escape_string($mysqli, $_POST['funnel_description']);
$theindex = mysqli_real_escape_string($mysqli, $_POST['theindex']);

$mysqli->query("UPDATE `farm_funnel`
SET
  `funnel_name` = '$funnel_name',
  `funnel_description` = '$funnel_description'

WHERE `id` = '$theindex'") or die(mysqli_error($mysqli));

echo 1;
