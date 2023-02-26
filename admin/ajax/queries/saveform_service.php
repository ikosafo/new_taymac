<?php
include('../../../config.php');

$service_name = mysqli_real_escape_string($mysqli, $_POST['service_name']);


$mysqli->query("INSERT INTO `taymac_service`
            (`service_name`)
VALUES ('$service_name')") or die(mysqli_error($mysqli));

echo 1;
