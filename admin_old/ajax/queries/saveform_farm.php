<?php
include('../../../config.php');

$farm_text = mysqli_real_escape_string($mysqli, $_POST['farm_text']);
$gettext = $mysqli->query("select * from taymac_farm LIMIT 1");
$resid = $gettext->fetch_assoc();
$theid = $resid['id'];
$count = mysqli_num_rows($gettext);

if ($count == "0"){
    $mysqli->query("INSERT INTO `taymac_farm`
            (`farm_text`)
VALUES ('$farm_text')") or die(mysqli_error($mysqli));
    echo 1;
}

else {
    $mysqli->query("UPDATE `taymac_farm`
SET
  `farm_text` = '$farm_text'

WHERE `id` = '$theid'") or die(mysqli_error($mysqli));
    echo 2;
}


