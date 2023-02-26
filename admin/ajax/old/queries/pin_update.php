<?php
include('../../../config.php');

$applicant_id = mysqli_real_escape_string($mysqli, $_POST['applicant_id']);
$app_pin = mysqli_real_escape_string($mysqli, $_POST['app_pin']);
$date = date('Y-m-d H:i:s');
$user_id = $_SESSION['user_id'];

$getoldid = $mysqli->query("select * from provisional where applicant_id = '$applicant_id'");
$resoldid = $getoldid->fetch_assoc();
$provisional_pin = $resoldid['provisional_pin'];
$email_address = $resoldid['email_address'];
$full_name = $resoldid['first_name'].' '.$resoldid['other_name'].' '.$resoldid['surname'];

if ($app_pin == $provisional_pin) {

    //Same pin error
    echo 2;
}

else {
    $checkpin = $mysqli->query("select * from provisional where provisional_pin = '$app_pin'");
    $countpin = mysqli_num_rows($checkpin);
    if ($countpin > 0) {

        //Pin belongs to someone else
        echo 3;
    }
    else {
        $mysqli->query("INSERT INTO `pin_updates`
            (`oldpin`,
             `newpin`,
             `dateupdated`,
             `userid`)
VALUES ('$provisional_pin',
        '$app_pin',
        '$date',
        '$user_id')") or die(mysqli_error($mysqli));


        $mysqli->query("UPDATE `provisional`
SET
  `provisional_pin` = '$app_pin',
  `pin_updated` = '1'

WHERE `applicant_id` = '$applicant_id'") or die(mysqli_error($mysqli));


        $subject = 'AHPC Pin Generation';

        $message = "Dear $full_name, <p>Thank you for registering with <b>Allied Health
Professions Council.</b>. Your new pin is $app_pin and is valid for use. </p>
<p>Thank you.</p>
";

      SendEmail::compose($email_address,$subject,$message);

        echo 1;

    }

}
