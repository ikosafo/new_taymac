<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$product = mysqli_real_escape_string($mysqli, $_POST['product']);
$input_kg = mysqli_real_escape_string($mysqli, $_POST['input_kg']);
$input_g = mysqli_real_escape_string($mysqli, $_POST['input_g']);
$input_price = mysqli_real_escape_string($mysqli, $_POST['input_price']);
$date_harvest = mysqli_real_escape_string($mysqli, $_POST['date_harvest']);

$mysqli->query("INSERT INTO `farm_harvest`
                (
                    `product`,
                    `input_kg`,
                    `input_g`,
                    `date_harvest`
                )
                VALUES (
                    '$product',
                    '$input_kg',
                    '$input_g',
                    '$date_harvest'
                        )") or die(mysqli_error($mysqli));


$mysqli->query("INSERT INTO `taymac_logs_mis`
        (`message`,
         `logdate`,
         `username`,
         `mac_address`,
         `ip_address`,
         `action`)
VALUES ('Added to farm harvest',
    '$today',
    '$username',
    '$mac_address',
    '$ip_add',
    'Successful')") or die(mysqli_error($mysqli));

echo 1;
