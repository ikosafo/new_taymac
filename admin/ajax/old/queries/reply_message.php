<?php
include('../../../config.php');

$message_id = mysqli_real_escape_string($mysqli, $_POST['message_id']);
$reply = mysqli_real_escape_string($mysqli, $_POST['reply']);

$mysqli->query("UPDATE `messages`
SET `reply` = '$reply'
WHERE `id` = '$message_id'") or die(mysqli_error($mysqli));

echo 1;

?>