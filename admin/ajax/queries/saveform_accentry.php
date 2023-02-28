<?php
include('../../../config.php');

$today = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
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


$mysqli->query("INSERT INTO `taymac_logs_mis`
            (`message`,
             `logdate`,
             `username`,
             `mac_address`,
             `ip_address`,
             `action`)
VALUES ('Added to account entry',
        '$today',
        '$username',
        '$mac_address',
        '$ip_add',
        'Successful')") or die(mysqli_error($mysqli));

echo 1;
