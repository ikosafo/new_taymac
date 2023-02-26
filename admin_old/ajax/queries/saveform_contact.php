<?php
include('../../../config.php');

$contact_address = mysqli_real_escape_string($mysqli, $_POST['contact_address']);
$contact_phone = mysqli_real_escape_string($mysqli, $_POST['contact_phone']);
$contact_mobile = mysqli_real_escape_string($mysqli, $_POST['contact_mobile']);
$contact_email = mysqli_real_escape_string($mysqli, $_POST['contact_email']);
$contact_website = mysqli_real_escape_string($mysqli, $_POST['contact_website']);
$contact_post = mysqli_real_escape_string($mysqli, $_POST['contact_post']);

$getnum = $mysqli->query("select * from taymac_contact");
$countnum = mysqli_num_rows($getnum);

if ($countnum == "0") {

    $mysqli->query("INSERT INTO `taymac_contact`
            (`address`,
             `phone`,
             `mobile`,
             `email`,
             `postbox`,
             `website`)
VALUES ('$contact_address',
        '$contact_phone',
        '$contact_mobile',
        '$contact_email',
        '$contact_post',
        '$contact_website')") or die(mysqli_error($mysqli));

    echo 1;
}
else {
    echo 2;
}


