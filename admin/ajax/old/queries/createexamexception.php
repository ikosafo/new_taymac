<?php
include('../../../config.php');
$examination_id = $_POST['examination_id'];

$getapp = $mysqli->query("UPDATE `examination_reg`
SET `createpemex` = '1'
WHERE `examination_id` = '$examination_id'");

echo 1;
