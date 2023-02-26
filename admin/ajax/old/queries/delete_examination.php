<?php
include('../../../config.php');
$e_id=$_POST['id_index'];

$mysqli->query("delete from examination_reg where examination_id = '$e_id'") or die(mysqli_error($mysqli));
echo 1;
?>
