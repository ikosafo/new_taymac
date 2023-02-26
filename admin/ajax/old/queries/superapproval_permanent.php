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
$full_name = $result['first_name']." ".$result['surname'];
$email_address = $result['email_address'];
$periodregistered = $result['permanent_period'];
$professionid = $result['professsionid'];
$index_number = $result['exam_index_number'];
$yeargen = substr($periodregistered,2,2);
$code = sprintf("%02d", $professionid);
$fgen = sprintf("%02d", mt_rand(0,99));
$sgen = sprintf("%02d", mt_rand(0,99));
$prov = $fgen.$code.$sgen.$yeargen;


$permanent_number = $result['provisional_pin'];

if ($permanent_number == ""){
    if ($index_number != '') {
        $mysqli->query("update provisional
    set
        permanent_admincheck_status = '$approve_state',
        permanent_admincheck_comment = '$remark',
        permanent_form_submitted = '$form_submitted',
        permanent_admincheck_user = '$user_id',
        permanent_date_approval = '$datetime',
        permanent_pin = '$index_number',
        provisional_pin = '$index_number'

        where applicant_id = '$applicant_id'
    ") or die(mysqli_error($mysqli));
    }

    else {
        $mysqli->query("update provisional
    set
        permanent_admincheck_status = '$approve_state',
        permanent_admincheck_comment = '$remark',
        permanent_form_submitted = '$form_submitted',
        permanent_admincheck_user = '$user_id',
        permanent_date_approval = '$datetime',
        permanent_pin = '$prov',
        provisional_pin = '$prov'

        where applicant_id = '$applicant_id'
    ") or die(mysqli_error($mysqli));
    }

    $subject = 'AHPC Pin Generation';

    $message = "Dear $full_name, <p>Thank you for registering with <b>Allied Health
Professions Council.</b>. Your pin is $prov and is valid for use. </p>
<p>Thank you.</p>
";

    /*SendEmail::compose($email_address,$subject,$message);*/

    echo 1;
}

else {

    $mysqli->query("update provisional
    set
        permanent_admincheck_status = '$approve_state',
        permanent_admincheck_comment = '$remark',
        permanent_form_submitted = '$form_submitted',
        permanent_admincheck_user = '$user_id',
        permanent_date_approval = '$datetime'

        where applicant_id = '$applicant_id'
    ") or die(mysqli_error($mysqli));

    echo 2;
}

?>