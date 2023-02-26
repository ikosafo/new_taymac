<?php
include('../../../config.php');

$applicant_id = mysqli_real_escape_string($mysqli, $_POST['id_index']);
$date = date('Y-m-d H:i:s');
$user_id = $_SESSION['user_id'];

$getid = $mysqli->query("select * from provisional where applicant_id = '$applicant_id'");
$resid = $getid->fetch_assoc();
$email_address = $resid['email_address'];
$resend_mail = $resid['resend_mail'];
$pin = $resid['provisional_pin'];
$full_name = $resid['first_name'].' '.$resid['other_name'].' '.$resid['surname'];

if ($resend_mail == '1') {

    //Mail already sent
    echo 2;
}

else {

    $subject = 'AHPC Pin Generation';

    $message = "Dear $full_name, <p>Thank you for registering with <b>Allied Health
Professions Council.</b>. Your new pin is $pin and is valid for use. </p>
<p>Thank you.</p>
";

    SendEmail::compose($email_address,$subject,$message);


        $mysqli->query("INSERT INTO `resent_pinmails`
            (`pin`,
             `dateupdated`,
             `userid`)
VALUES ('$pin',
        '$date',
        '$user_id')") or die(mysqli_error($mysqli));


        $mysqli->query("UPDATE `provisional`
SET `resend_mail` = '1'

WHERE `applicant_id` = '$applicant_id'") or die(mysqli_error($mysqli));


        echo 1;

    }



?>