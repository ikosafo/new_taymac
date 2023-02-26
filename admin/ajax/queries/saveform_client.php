<?php
include('../../../config.php');

$client_name = mysqli_real_escape_string($mysqli, $_POST['client_name']);
$client_text = mysqli_real_escape_string($mysqli, $_POST['client_text']);


$mysqli->query("INSERT INTO `taymac_client_feedback`
            (`client_name`,
             `client_text`)
VALUES ('$client_name',
        '$client_text')") or die(mysqli_error($mysqli));

echo 1;
