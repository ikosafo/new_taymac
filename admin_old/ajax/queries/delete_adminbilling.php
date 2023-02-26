<?php
include('../../../config.php');
$id=$_POST['i_index'];

$mysqli->query("delete from admin_taymac_billing where id = '$id'") or die(mysqli_error($mysqli));

echo 1;
?>