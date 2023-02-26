<?php
include('../../../config.php');
$id=$_POST['i_index'];

$query = $mysqli->query("select * from taymac_image_property where imageid = '$id'");
$res = $query->fetch_assoc();
$filename =  $res['image_location'];

$use = substr($filename,strpos($filename,"/")+1);

unlink("../../uploads/".$use);

$mysqli->query("delete from taymac_property where
                     imageid = '$id'") or die(mysqli_error($mysqli));

$mysqli->query("delete from taymac_image_property where
                     imageid = '$id'") or die(mysqli_error($mysqli));

echo 1;
?>