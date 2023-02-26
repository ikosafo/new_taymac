<?php
include('../../../config.php');

$health_text = mysqli_real_escape_string($mysqli, $_POST['health_text']);
$id_index = mysqli_real_escape_string($mysqli, $_POST['id_index']);

$mysqli->query("UPDATE `taymac_health`
SET
  `health_text` = '$health_text'

WHERE `id` = '$id_index'") or die(mysqli_error($mysqli));

echo 1;
