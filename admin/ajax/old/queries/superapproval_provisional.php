<?php
include('../../../config.php');

$applicant_id = mysqli_real_escape_string($mysqli, $_POST['applicant_id']);
$form_submitted = mysqli_real_escape_string($mysqli, $_POST['form_submitted']);
$approve_state = mysqli_real_escape_string($mysqli, $_POST['approve_state']);
$remark = mysqli_real_escape_string($mysqli, $_POST['remark']);
$user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);
$datetime = date("Y-m-d H:i:s");

$query = $mysqli->query("select * from provisional where applicant_id = '$applicant_id'");
$result = $query->fetch_assoc();
$full_name = $result['first_name'] . " " . $result['surname'];
$email_address = $result['email_address'];
$professionid = $result['professionid'];
$periodregistered = $result['provisional_period'];
$provisional_pin = $result['provisional_pin'];
$yeargen = substr($periodregistered, 2, 2);
$code = sprintf("%02d", $professionid);
$fgen = sprintf("%02d", mt_rand(0, 99));
$sgen = sprintf("%02d", mt_rand(0, 99));
$prov = $fgen . $code . $sgen . $yeargen;


if ($approve_state == 'Rejected') {

    $subject = 'AHPC Application Rejected';
    $message = "Dear $full_name, <p>Thank you for registering with <b>Allied Health
Professions Council.</b>.Your application has been rejected due to the following reasons : <br/>
<b>$remark.</b> <br/>
Please correct your errors and submit your application. </p>
<p>Thank you.</p>
";
    SendEmail::compose($email_address, $subject, $message);
}


$chkquery = $mysqli->query("select * from provisional where provisional_pin = '$prov'");
$cntquery = mysqli_num_rows($chkquery);


if ($cntquery == "0") {

    $provisional_number = $result['provisional_pin'];

    if ($provisional_number == "" && $approve_state == "Approved") {
        $mysqli->query("UPDATE provisional
        SET
        provisional_admincheck_status = '$approve_state',
        provisional_admincheck_comment = '$remark',
        provisional_form_submitted = '$form_submitted',
        provisional_admincheck_user = '$user_id',
        provisional_date_approval = '$datetime',
        provisional_pin = '$prov'

        WHERE applicant_id = '$applicant_id'
    ") or die(mysqli_error($mysqli));

        $mysqli->query("UPDATE `registration_upgrades`
          SET
          `admincheck_status` = '$approve_state',
          `admincheck_comment` = '$remark',
          `admincheck_user` = '$user_id',
          `admin_approved_date` = '$datetime'

          WHERE `applicant_id` = '$applicant_id'") or die(mysqli_error($mysqli));

        $subject = 'AHPC Pin Generation';
        $message = "Dear $full_name, <p>Thank you for registering with the <b>Allied Health Professions Council.</b>.
                   The Provisional PIN $prov is provided just for the purpose of registering for the Licensure
                   Examination and will expire on March 19, 2021. </p>
        <p>Thank you.</p>
";
        //SendEmail::compose($email_address,$subject,$message);

        echo 1;
    } else {

        $mysqli->query("update provisional
        SET
        provisional_admincheck_status = '$approve_state',
        provisional_admincheck_comment = '$remark',
        provisional_form_submitted = '$form_submitted',
        provisional_admincheck_user = '$user_id',
        provisional_date_approval = '$datetime'
        WHERE applicant_id = '$applicant_id'
    ") or die(mysqli_error($mysqli));

        $mysqli->query("UPDATE `registration_upgrades`
          SET
          `admincheck_status` = '$approve_state',
          `admincheck_comment` = '$remark',
          `admincheck_user` = '$user_id',
          `admin_approved_date` = '$datetime'

          WHERE `applicant_id` = '$applicant_id'") or die(mysqli_error($mysqli));

        echo 2;
    }

} else {
    $code = sprintf("%02d", $professionid);
    $fgen = sprintf("%02d", mt_rand(0, 99));
    $sgen = sprintf("%02d", mt_rand(0, 99));
    $yeargen = substr($periodregistered, 2, 2);
    $prov = $fgen . $code . $sgen . $yeargen;
    $provisional_number = $result['provisional_pin'];

    if ($provisional_number == "" && $approve_state == "Approved") {
        $mysqli->query("UPDATE provisional
        SET
        provisional_admincheck_status = '$approve_state',
        provisional_admincheck_comment = '$remark',
        provisional_form_submitted = '$form_submitted',
        provisional_admincheck_user = '$user_id',
        provisional_date_approval = '$datetime',
        provisional_pin = '$prov'

        WHERE applicant_id = '$applicant_id'
    ") or die(mysqli_error($mysqli));

        $subject = 'AHPC Pin Generation';

        $message = "Dear $full_name, <p>Thank you for registering with the <b>Allied Health Professions Council.</b>.
                   The Provisional PIN $prov is provided just for the purpose of registering for the Licensure
                   Examination and will expire on March 19, 2021. </p>
        <p>Thank you.</p>
";
        //SendEmail::compose($email_address,$subject,$message);
        echo 1;
    } else {

        $mysqli->query("update provisional
        SET
        provisional_admincheck_status = '$approve_state',
        provisional_admincheck_comment = '$remark',
        provisional_form_submitted = '$form_submitted',
        provisional_admincheck_user = '$user_id',
        provisional_date_approval = '$datetime'

        WHERE applicant_id = '$applicant_id'
    ") or die(mysqli_error($mysqli));

        $mysqli->query("UPDATE `registration_upgrades`
          SET
          `admincheck_status` = '$approve_state',
          `admincheck_comment` = '$remark',
          `admincheck_user` = '$user_id',
          `admin_approved_date` = '$datetime'

          WHERE `applicant_id` = '$applicant_id'") or die(mysqli_error($mysqli));
        echo 2;
    }

    echo 3;
}


?>