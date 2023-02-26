<?php
include('../../../config.php');

$story_text = mysqli_real_escape_string($mysqli, $_POST['story_text']);
$id_index = mysqli_real_escape_string($mysqli, $_POST['id_index']);

$mysqli->query("UPDATE `taymac_story`
SET
  `story_text` = '$story_text'

WHERE `id` = '$id_index'") or die(mysqli_error($mysqli));

echo 1;
