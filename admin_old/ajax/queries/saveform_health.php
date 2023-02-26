<?php
include('../../../config.php');

$health_text = mysqli_real_escape_string($mysqli, $_POST['health_text']);
$gettext = $mysqli->query("select * from taymac_health LIMIT 1");
$resid = $gettext->fetch_assoc();
$theid = $resid['id'];
$count = mysqli_num_rows($gettext);

if ($count == "0"){
    $mysqli->query("INSERT INTO `taymac_health`
            (`health_text`)
VALUES ('$health_text')") or die(mysqli_error($mysqli));
    echo 1;
}

else {
    $mysqli->query("UPDATE `taymac_health`
SET
  `health_text` = '$health_text'

WHERE `id` = '$theid'") or die(mysqli_error($mysqli));
    echo 2;
}


