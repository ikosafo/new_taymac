<?php
include('../../../config.php');

$farm_text = mysqli_real_escape_string($mysqli, $_POST['farm_text']);
$id_index = mysqli_real_escape_string($mysqli, $_POST['id_index']);

$mysqli->query("UPDATE `taymac_farm`
SET
  `farm_text` = '$farm_text'

WHERE `id` = '$id_index'") or die(mysqli_error($mysqli));

echo 1;
