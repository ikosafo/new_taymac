<?php
include('../../../config.php');

$contact_address = mysqli_real_escape_string($mysqli, $_POST['contact_address']);
$contact_phone = mysqli_real_escape_string($mysqli, $_POST['contact_phone']);
$contact_mobile = mysqli_real_escape_string($mysqli, $_POST['contact_mobile']);
$contact_email = mysqli_real_escape_string($mysqli, $_POST['contact_email']);
$contact_website = mysqli_real_escape_string($mysqli, $_POST['contact_website']);
$id_index = mysqli_real_escape_string($mysqli, $_POST['id_index']);
$contact_post = mysqli_real_escape_string($mysqli, $_POST['contact_post']);


$mysqli->query("UPDATE `taymac_contact`
SET
  `address` = '$contact_address',
  `phone` = '$contact_phone',
  `mobile` = '$contact_mobile',
  `email` = '$contact_email',
  `website` = '$contact_website',
  `postbox` = '$contact_post'


WHERE `id` = '$id_index'") or die(mysqli_error($mysqli));

echo 1;
