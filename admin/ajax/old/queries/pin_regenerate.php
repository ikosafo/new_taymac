<?php

include('../../../config.php');

$applicant_id = mysqli_real_escape_string($mysqli, $_POST['applicant_id']);
$query = $mysqli->query("select * from provisional where applicant_id = '$applicant_id'");
$result = $query->fetch_assoc();
$full_name = $result['first_name']." ".$result['surname'];
$email_address = $result['email_address'];
$provisional_pin = $result['provisional_pin'];
$professionid = $result['professionid'];
$profession = $result['profession'];
$date = date('Y-m-d H:i:s');
$user_id = $_SESSION['user_id'];

$permregistered = $result['permanent_period'];
$proregistered = $result['provisional_period'];
$code = sprintf("%02d", $professionid);
$fgen = sprintf("%02d", mt_rand(0,99));
$sgen = sprintf("%02d", mt_rand(0,99));


if ($permregistered != "") {
    $yeargen = substr($permregistered,2,2);
    $prov = $fgen.$code.$sgen.$yeargen;
}

else {
    $yeargen = substr($proregistered,2,2);
    $prov = $fgen.$code.$sgen.$yeargen;
}


$chkquery = $mysqli->query("select * from provisional where provisional_pin = '$prov'");
$cntquery = mysqli_num_rows($chkquery);


if ($cntquery == "0") {

    $mysqli->query("update provisional
    set provisional_pin = '$prov' where applicant_id = '$applicant_id'
    ") or die(mysqli_error($mysqli));

    $subject = 'AHPC Pin Generation';

    $message = "Dear $full_name, <p>Thank you for registering with <b>Allied Health
Professions Council.</b>. Your new pin is $prov and is valid for use. </p>
<p>Thank you.</p>
";
    //SendEmail::compose($email_address,$subject,$message);

    $mysqli->query("INSERT INTO `pin_regenerates`
            (`oldpin`,
             `newpin`,
             `dateupdated`,
             `userid`)
VALUES ('$provisional_pin',
        '$prov',
        '$date',
        '$user_id')") or die(mysqli_error($mysqli));

    echo 1;


}

else {
    $code = sprintf("%02d", $professionid);
    $fgen = sprintf("%02d", mt_rand(0,99));
    $sgen = sprintf("%02d", mt_rand(0,99));
    $permregistered = $result['permanent_period'];
    $proregistered = $result['provisional_period'];

    if ($permregistered != "") {
        $yeargen = substr($permregistered,2,2);
        $prov = $fgen.$code.$sgen.$yeargen;
    }

    else {
        $yeargen = substr($proregistered,2,2);
        $prov = $fgen.$code.$sgen.$yeargen;
    }

    $mysqli->query("update provisional
    set provisional_pin = '$prov' where applicant_id = '$applicant_id'
    ") or die(mysqli_error($mysqli));

    $subject = 'AHPC Pin Generation';

    $message = "Dear $full_name, <p>Thank you for registering with <b>Allied Health
Professions Council.</b>. Your new pin is $prov and is valid for use. </p>
<p>Thank you.</p>
";
    //SendEmail::compose($email_address,$subject,$message);

    $mysqli->query("INSERT INTO `pin_regenerates`
            (`oldpin`,
             `newpin`,
             `dateupdated`,
             `userid`)
VALUES ('$provisional_pin',
        '$prov',
        '$date',
        '$user_id')") or die(mysqli_error($mysqli));

    echo 3;
}


?>