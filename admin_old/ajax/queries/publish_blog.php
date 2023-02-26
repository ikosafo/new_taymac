<?php
include('../../../config.php');
$id=$_POST['i_index'];

$mysqli->query("UPDATE `taymac_blog`
SET
  `status` = '1'

WHERE `imageid` = '$id'") or die(mysqli_error($mysqli));

echo 1;
?>