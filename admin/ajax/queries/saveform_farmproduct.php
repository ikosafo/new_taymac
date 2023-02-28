<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$product_name = mysqli_real_escape_string($mysqli, $_POST['product_name']);
$product_type = mysqli_real_escape_string($mysqli, $_POST['product_type']);
$product_type_other = mysqli_real_escape_string($mysqli, $_POST['product_type_other']);

$mysqli->query("INSERT INTO `farm_products`
            (
             `product_name`,
             `product_type`,
             `product_type_other`)
VALUES (
        '$product_name',
        '$product_type',
        '$product_type_other')") or die(mysqli_error($mysqli));

$mysqli->query("INSERT INTO `taymac_logs_mis`
(`message`,
 `logdate`,
 `username`,
 `mac_address`,
 `ip_address`,
 `action`)
VALUES ('Added to farm products',
'$today',
'$username',
'$mac_address',
'$ip_add',
'Successful')") or die(mysqli_error($mysqli));

echo 1;
