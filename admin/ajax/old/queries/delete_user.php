<?php
include('../../../config.php');

$i_id=$_POST['i_index'];
$user_id=$_POST['user_index'];

$mysqli->query("delete from mis_users where id='$i_id'") or die(mysqli_error($mysqli));

$mysqli->query("delete from permission where user_id = '$user_id'") or die(mysqli_error($mysqli));
echo 1;
?>
