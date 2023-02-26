<?php
include('../../../config.php');
$i_id=$_POST['i_index'];

$getapp = $mysqli->query("select * from temporal_special_cases where id = '$i_id'");
$appid = $getapp->fetch_assoc();
$random_code = $appid['random_code'];

$getcountappid = $mysqli->query("select * from provisional where applicant_id = '$random_code'");
if (mysqli_num_rows($getcountappid) == "1") {
    echo "Can't delete";
}
else {
    $mysqli->query("delete from temporal_special_cases where id='$i_id'") or die(mysqli_error($mysqli));
    echo 1;
}


?>
