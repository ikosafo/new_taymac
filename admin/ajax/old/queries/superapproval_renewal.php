<?php

include('../../../config.php');

$applicant_id = mysqli_real_escape_string($mysqli, $_POST['applicant_id']);
$form_submitted = mysqli_real_escape_string($mysqli, $_POST['form_submitted']);
$approve_state = mysqli_real_escape_string($mysqli, $_POST['approve_state']);
$year_search = mysqli_real_escape_string($mysqli, $_POST['year_search']);
$remark = mysqli_real_escape_string($mysqli, $_POST['remark']);
$user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);

$datetime = date("Y-m-d H:i:s");

$app_query = $mysqli->query("select * from provisional
join renewal
on provisional.applicant_id = renewal.applicant_id
where provisional.applicant_id = '$applicant_id'
AND renewal.cpdyear = '$year_search'");
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

else if ($app_result['cpd_usercheck_status'] == "Rejected") {
    echo 3;
}

else {

    $mysqli->query("update renewal
    SET
        cpd_admincheck_status = '$approve_state',
        cpd_admincheck_comment = '$remark',
        cpd_form_submitted = '$form_submitted',
        cpd_admincheck_user = '$user_id'
        where (applicant_id = '$applicant_id' AND cpdyear = '$year_search')
    ") or die(mysqli_error($mysqli));
    echo 1;
}

?>