<?php
include('../../../config.php');

$applicant_id = mysqli_real_escape_string($mysqli, $_POST['applicant_id']);
$examination_id = mysqli_real_escape_string($mysqli, $_POST['examination_id']);
$form_submitted = mysqli_real_escape_string($mysqli, $_POST['form_submitted']);
$approve_state = mysqli_real_escape_string($mysqli, $_POST['approve_state']);
$remark = mysqli_real_escape_string($mysqli, $_POST['remark']);
$user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);

$datetime = date("Y-m-d H:i:s");

$app_query = $mysqli->query("select * from provisional join examination_reg on
provisional.applicant_id = examination_reg.applicant_id
 where provisional.applicant_id = '$applicant_id'
and provisional.examination_registration = '1' AND examination_reg.examination_id = '$examination_id'");
$app_result = $app_query->fetch_assoc();

$email_address = $app_result['email_address'];
$firstname = $app_result['first_name'];


if ($approve_state == 'Rejected') {

    $subject = 'AHPC Application Rejected';

    $message = "Dear $firstname, <p>Thank you for registering with <b>Allied Health
Professions Council.</b>.Your application has been rejected due to the following reasons : <br/>
<b>$remark.</b> <br/>
Please correct your errors and submit your application. </p>
<p>Thank you.</p>
";

    SendEmail::compose($email_address,$subject,$message);
}


if ($app_result['payment'] != "1") {
    echo 2;
}

else {

    $mysqli->query("update examination_reg
    set 
        exam_usercheck_status = '$approve_state',
        exam_usercheck_comment = '$remark',
        exam_form_submitted = '$form_submitted',
        exam_usercheck_user = '$user_id'

        where examination_id = '$examination_id'
    ") or die(mysqli_error($mysqli));

    echo 1;
    //header("location:/exam_approval.php?appid=".lock($applicant_id)."&done=1&userid=".$user_id."");

}

