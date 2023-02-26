<?php
include('../../../config.php');
$d_id=$_POST['i_index'];

$mysqli->query("delete from date_config where id = '$d_id'") or die(mysqli_error($mysqli));
echo 1;
?>
