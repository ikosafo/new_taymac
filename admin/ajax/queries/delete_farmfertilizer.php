<?php
include('../../../config.php');
$id=$_POST['i_index'];

$mysqli->query("delete from farm_fertilizer where id = '$id'") or die(mysqli_error($mysqli));

echo 1;
?>