<?php
include('../../../config.php');

$input_name = mysqli_real_escape_string($mysqli, $_POST['input_name']);
$input_type = mysqli_real_escape_string($mysqli, $_POST['input_type']);
$input_type_other = mysqli_real_escape_string($mysqli, $_POST['input_type_other']);

$mysqli->query("INSERT INTO `farm_inputs`
            (
             `input_name`,
             `input_type`,
             `input_type_other`)
VALUES (
        '$input_name',
        '$input_type',
        '$input_type_other')") or die(mysqli_error($mysqli));

echo 1;
