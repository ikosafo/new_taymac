<?php
include('../../../config.php');

$client_name = mysqli_real_escape_string($mysqli, $_POST['client_name']);

$mysqli->query("INSERT INTO `taymac_ppclient`
            (`client_name`)
VALUES ('$client_name')") or die(mysqli_error($mysqli));

echo 1;
