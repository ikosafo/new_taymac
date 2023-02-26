<?php
include('../../../config.php');

$realtor_text = mysqli_real_escape_string($mysqli, $_POST['realtor_text']);
$flaticon = mysqli_real_escape_string($mysqli, $_POST['flaticon']);


$mysqli->query("INSERT INTO `taymac_realtor`
            (`realtor_text`,
             `flat_icon`)
VALUES ('$realtor_text',
        '$flaticon')") or die(mysqli_error($mysqli));

echo 1;
