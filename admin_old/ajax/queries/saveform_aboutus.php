<?php
include('../../../config.php');

$aboutus_text = mysqli_real_escape_string($mysqli, $_POST['aboutus_text']);
$gettext = $mysqli->query("select * from taymac_aboutus LIMIT 1");
$resid = $gettext->fetch_assoc();
$theid = $resid['id'];
$count = mysqli_num_rows($gettext);

if ($count == "0"){
    $mysqli->query("INSERT INTO `taymac_aboutus`
            (`aboutus`)
VALUES ('$aboutus_text')") or die(mysqli_error($mysqli));
    echo 1;
}

else {
    $mysqli->query("UPDATE `taymac_aboutus`
SET
  `aboutus` = '$aboutus_text'

WHERE `id` = '$theid'") or die(mysqli_error($mysqli));
    echo 2;
}


