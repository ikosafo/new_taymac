<?php
include('../../../config.php');
$p_id=$_POST['p_index'];

$mysqli->query("delete from permission where id = '$p_id'") or die(mysqli_error($mysqli));
echo 1;
?>
