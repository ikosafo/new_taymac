<?php
include('../../../config.php');

$pm_text = mysqli_real_escape_string($mysqli, $_POST['pm_text']);
$gettext = $mysqli->query("select * from taymac_pm LIMIT 1");
$resid = $gettext->fetch_assoc();
$theid = $resid['id'];
$count = mysqli_num_rows($gettext);

if ($count == "0"){
    $mysqli->query("INSERT INTO `taymac_pm`
            (`pm_text`)
VALUES ('$pm_text')") or die(mysqli_error($mysqli));
    echo 1;
}

else {
    $mysqli->query("UPDATE `taymac_pm`
SET
  `pm_text` = '$pm_text'

WHERE `id` = '$theid'") or die(mysqli_error($mysqli));
    echo 2;
}


