<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$funnel_name = mysqli_real_escape_string($mysqli, $_POST['funnel_name']);
$funnel_description = mysqli_real_escape_string($mysqli, $_POST['funnel_description']);

$mysqli->query("INSERT INTO `farm_funnel`
                (
                    `funnel_name`,
                    `funnel_description`
                )
                VALUES (
                    '$funnel_name',
                    '$funnel_description'
                        )") or die(mysqli_error($mysqli));


$mysqli->query("INSERT INTO `taymac_logs_mis`
        (`message`,
         `logdate`,
         `username`,
         `mac_address`,
         `ip_address`,
         `action`)
VALUES ('Added to farm funnel',
    '$today',
    '$username',
    '$mac_address',
    '$ip_add',
    'Successful')") or die(mysqli_error($mysqli));

echo 1;
