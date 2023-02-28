<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$funnel_name = mysqli_real_escape_string($mysqli, $_POST['funnel_name']);
$funnel_description = mysqli_real_escape_string($mysqli, $_POST['funnel_description']);
$theindex = mysqli_real_escape_string($mysqli, $_POST['theindex']);

$mysqli->query("UPDATE `farm_funnel`
SET
  `funnel_name` = '$funnel_name',
  `funnel_description` = '$funnel_description'

WHERE `id` = '$theindex'") or die(mysqli_error($mysqli));


$mysqli->query("INSERT INTO `taymac_logs_mis`
            (`message`,
             `logdate`,
             `username`,
             `mac_address`,
             `ip_address`,
             `action`)
VALUES ('Edited funnel',
        '$today',
        '$username',
        '$mac_address',
        '$ip_add',
        'Successful')") or die(mysqli_error($mysqli));

echo 1;
