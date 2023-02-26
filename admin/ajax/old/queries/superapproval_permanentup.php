<?php
include('../../../config.php');

$applicant_id = mysqli_real_escape_string($mysqli, $_POST['applicant_id']);
$approve_state = mysqli_real_escape_string($mysqli, $_POST['approve_state']);
$remark = mysqli_real_escape_string($mysqli, $_POST['remark']);
$user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);
$id = mysqli_real_escape_string($mysqli, $_POST['id']);
$datetime = date("Y-m-d H:i:s");

$app_query = $mysqli->query("select * from provisional where applicant_id = '$applicant_id'");
$app_result = $app_query->fetch_assoc();
$email_address = $app_result['email_address'];
$firstname = $app_result['first_name'];

$appup_query = $mysqli->query("select * from registration_upgrades where id = '$id'");
$appup_result = $appup_query->fetch_assoc();
$usercheck_status = $appup_result['usercheck_status'];
$new_profession = $appup_result['new_profession'];


if ($usercheck_status == "Approved") {

    if ($appup_result['payment'] == "0") {
        echo 2;
    }

    else {

        if ($approve_state == 'Rejected') {
            $subject = 'AHPC Application Rejected';
            $message = "Dear $firstname, <p>Thank you for registering with <b>Allied Health
        Professions Council.</b>Your application has been rejected due to the following reasons : <br/>
        <b>$remark.</b> <br/>
        Please correct your errors and submit your application. </p>
        <p>Thank you.</p>";
            SendEmail::compose($email_address,$subject,$message);

            $mysqli->query("UPDATE `registration_upgrades`
            SET 
            `admincheck_status` = '$approve_state',
            `admincheck_comment` = '$remark',
            `admincheck_user` = '$user_id'
            WHERE `id` = '$id'") or die(mysqli_error($mysqli));

            echo 1;
        }
        else {
            $subject = 'AHPC Application Approved';
            $message = "Dear $firstname, <p>Thank you for registering with <b>Allied Health
        Professions Council.</b>Your application for upgrade has been approved and your profession 
        has been updated.</p>
        <p>Thank you.</p>";
            SendEmail::compose($email_address,$subject,$message);

            $mysqli->query("UPDATE `registration_upgrades`
            SET 
            `admincheck_status` = '$approve_state',
            `admincheck_comment` = '$remark',
            `admincheck_user` = '$user_id'
            WHERE `id` = '$id'") or die(mysqli_error($mysqli));
    
            $mysqli->query("UPDATE `provisional`
            SET `professionid` = '$new_profession'
            WHERE `applicant_id` = '$applicant_id'") or die(mysqli_error($mysqli));
            echo 1;
        }

    }

}
else {
    echo 3;
}


?>