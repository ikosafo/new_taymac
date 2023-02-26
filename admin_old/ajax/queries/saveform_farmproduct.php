<?php
include('../../../config.php');

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

echo 1;
