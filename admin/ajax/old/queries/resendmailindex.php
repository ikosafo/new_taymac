<?php
include('../../../config.php');

$applicant_id = mysqli_real_escape_string($mysqli, $_POST['id_index']);
$date = date('Y-m-d H:i:s');
$user_id = $_SESSION['user_id'];

$getid = $mysqli->query("select * from provisional where applicant_id = '$applicant_id'");
$resid = $getid->fetch_assoc();
$email_address = $resid['email_address'];
//$resend_mail = $resid['resend_mail'];
$index_number = $resid['exam_index_number'];
$full_name = $resid['first_name'].' '.$resid['other_name'].' '.$resid['surname'];



$subject = 'AHPC Index Number (Correction)';
$message = "Dear $full_name,

<p><b>CORRECTION: </b> Thank you for registering with <b>Allied Health Professions Council.</b>.
Your index number for your exam is $index_number and is valid for use. </p>
            <p>Thank you.</p>";

SendEmail::compose($email_address,$subject,$message);
echo 1;


?>