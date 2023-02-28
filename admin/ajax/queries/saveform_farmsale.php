<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$product = mysqli_real_escape_string($mysqli, $_POST['product']);
$input_kg = mysqli_real_escape_string($mysqli, $_POST['input_kg']);
$input_g = mysqli_real_escape_string($mysqli, $_POST['input_g']);
$input_price = mysqli_real_escape_string($mysqli, $_POST['input_price']);
$date_sale = mysqli_real_escape_string($mysqli, $_POST['date_sale']);

$mysqli->query("INSERT INTO `farm_sales`
                (
                    `product`,
                    `input_kg`,
                    `input_g`,
                    `input_price`,
                    `date_sale`
                )
                VALUES (
                    '$product',
                    '$input_kg',
                    '$input_g',
                    '$input_price',
                    '$date_sale'
                        )") or die(mysqli_error($mysqli));


$mysqli->query("INSERT INTO `taymac_logs_mis`
(`message`,
 `logdate`,
 `username`,
 `mac_address`,
 `ip_address`,
 `action`)
VALUES ('Added to farm sale',
'$today',
'$username',
'$mac_address',
'$ip_add',
'Successful')") or die(mysqli_error($mysqli));

echo 1;
