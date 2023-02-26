<?php
include('../../../config.php');

$account_type = mysqli_real_escape_string($mysqli, $_POST['account_type']);
$source = mysqli_real_escape_string($mysqli, $_POST['source']);
$date = mysqli_real_escape_string($mysqli, $_POST['date']);
$amount = mysqli_real_escape_string($mysqli, $_POST['amount']);
$description = mysqli_real_escape_string($mysqli, $_POST['description']);


$mysqli->query("INSERT INTO `account_entry`
            (
             `account_type`,
             `source`,
             `date`,
             `amount`,
             `description`)
VALUES (
        '$account_type',
        '$source',
        '$date',
        '$amount',
        '$description')") or die(mysqli_error($mysqli));

echo 1;
