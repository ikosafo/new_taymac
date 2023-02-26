<?php
include('../../../config.php');

$pm_text = mysqli_real_escape_string($mysqli, $_POST['pm_text']);
$id_index = mysqli_real_escape_string($mysqli, $_POST['id_index']);

$mysqli->query("UPDATE `taymac_pm`
SET
  `pm_text` = '$pm_text'

WHERE `id` = '$id_index'") or die(mysqli_error($mysqli));

echo 1;
