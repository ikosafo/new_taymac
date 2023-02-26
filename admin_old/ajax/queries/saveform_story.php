<?php
include('../../../config.php');

$story_text = mysqli_real_escape_string($mysqli, $_POST['story_text']);
$gettext = $mysqli->query("select * from taymac_story LIMIT 1");
$resid = $gettext->fetch_assoc();
$theid = $resid['id'];
$count = mysqli_num_rows($gettext);

if ($count == "0"){
    $mysqli->query("INSERT INTO `taymac_story`
            (`story_text`)
VALUES ('$story_text')") or die(mysqli_error($mysqli));
    echo 1;
}

else {
    $mysqli->query("UPDATE `taymac_story`
SET
  `story_text` = '$story_text'

WHERE `id` = '$theid'") or die(mysqli_error($mysqli));
    echo 2;
}


