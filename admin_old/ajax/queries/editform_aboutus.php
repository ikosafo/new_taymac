<?php
include('../../../config.php');

$aboutus_text = mysqli_real_escape_string($mysqli, $_POST['aboutus_text']);
$id_index = mysqli_real_escape_string($mysqli, $_POST['id_index']);

$mysqli->query("UPDATE `taymac_aboutus`
SET
  `aboutus` = '$aboutus_text'

WHERE `id` = '$id_index'") or die(mysqli_error($mysqli));

echo 1;
