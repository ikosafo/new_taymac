<?php

include('../../../config.php');

$applicant_id = mysqli_real_escape_string($mysqli, $_POST['applicant_id']);
$query = $mysqli->query("select * from provisional where applicant_id = '$applicant_id'");
$result = $query->fetch_assoc();
$full_name = $result['first_name']." ".$result['surname'];
$email_address = $result['email_address'];
$provisional_pin = $result['provisional_pin'];
$exam_index_number = $result['exam_index_number'];
$professionid = $result['professionid'];
$profession = $result['profession'];
$date = date('Y-m-d H:i:s');
$user_id = $_SESSION['user_id'];

$permregistered = $result['permanent_period'];
$proregistered = $result['provisional_period'];
$code = sprintf("%02d", $professionid);
$fgen = sprintf("%02d", mt_rand(0,99));
$sgen = sprintf("%02d", mt_rand(0,99));


/*if ($permregistered != "") {
    $yeargen = substr($permregistered,2,2);
    $prov = $fgen.$code.$sgen.$yeargen;
}

else {
    $yeargen = substr($proregistered,2,2);
    $prov = $fgen.$code.$sgen.$yeargen;
}*/


$mysqli->query("update provisional set exam_index_number = '$provisional_pin' where applicant_id = '$applicant_id'")
or die(mysqli_error($mysqli));


$mysqli->query("update examination_reg set indexnumber = '$provisional_pin' where applicant_id = '$applicant_id'")
or die(mysqli_error($mysqli));


$mysqli->query("INSERT INTO `index_regenerates`
            (`oldindex`,
             `newindex`,
             `dateupdated`,
             `userid`)
VALUES ('$exam_index_number',
        '$provisional_pin',
        '$date',
        '$user_id')") or die(mysqli_error($mysqli));

echo 1;

?>