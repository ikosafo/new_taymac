<?php
include('../../../config.php');

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

echo 1;
