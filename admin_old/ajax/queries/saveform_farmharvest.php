<?php
include('../../../config.php');

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

echo 1;
