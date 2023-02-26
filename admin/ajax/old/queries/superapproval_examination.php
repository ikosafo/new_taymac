<?php
include('../../../config.php');

$applicant_id = mysqli_real_escape_string($mysqli, $_POST['applicant_id']);
$form_submitted = mysqli_real_escape_string($mysqli, $_POST['form_submitted']);
$approve_state = mysqli_real_escape_string($mysqli, $_POST['approve_state']);
$remark = mysqli_real_escape_string($mysqli, $_POST['remark']);
$user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);
$examination_id = mysqli_real_escape_string($mysqli, $_POST['examination_id']);
$datetime = date("Y-m-d H:i:s");

$getpayment = $mysqli->query("select * from examination_reg where examination_id = '$examination_id'");
$respayment = $getpayment->fetch_assoc();
$payment = $respayment['payment'];


$query = $mysqli->query("select * from provisional where applicant_id = '$applicant_id'");
$result = $query->fetch_assoc();
$full_name = $result['first_name']." ".$result['surname'];
$email_address = $result['email_address'];
$professionid = $result['professionid'];
$profession = $result['profession'];
$periodregistered = $respayment['period_registered'];
$yeargen = substr($periodregistered,2,2);
$code = sprintf("%02d", $professionid);
$fgen = sprintf("%02d", mt_rand(0,99));
$sgen = sprintf("%02d", mt_rand(0,99));

$index_number = $result['exam_index_number'];
$provisional_pin = $result['provisional_pin'];
$genpin = $fgen.$code.$sgen.$yeargen;

if ($index_number != "") {
    $prov = $index_number;
}
else if ($provisional_pin != "") {
    $prov = $provisional_pin;
}
else {
    $prov = $genpin;
}

//$prov = mt_rand(10,99).mt_rand(10,99).mt_rand(10,99).date("y");


if ($payment == '0') {
    echo 2;
}
else {

    if ($approve_state == 'Approved') {
        $chkquery = $mysqli->query("select * from provisional where exam_index_number = '$prov'");
        $cntquery = mysqli_num_rows($chkquery);

        if ($cntquery == "0") {

            $mysqli->query("update examination_reg set
            exam_admincheck_user = '$user_id',
            exam_admincheck_status = '$approve_state',
            exam_admincheck_comment = '$remark',
            exam_admincheck_date = '$datetime',
            indexnumber = '$prov'

            where examination_id = '$examination_id'") or die(mysqli_error($mysqli));

            $mysqli->query("update provisional set
            exam_index_number = '$prov'
            where applicant_id = '$applicant_id'") or die(mysqli_error($mysqli));

            $subject = 'AHPC Index Number Generation';
            $message = "Dear $full_name, <p>Thank you for registering with <b>Allied Health Professions Council.</b>. Your index
            number for your exam is $prov and is valid for use. </p>
            <p>Thank you.</p>";

            SendEmail::compose($email_address,$subject,$message);
                 echo 1;
        }

        else {

            $mysqli->query("update examination_reg set
            exam_admincheck_user = '$user_id',
            exam_admincheck_status = '$approve_state',
            exam_admincheck_comment = '$remark',
            exam_admincheck_date = '$datetime'

            where examination_id = '$examination_id'") or die(mysqli_error($mysqli));

            $subject = 'AHPC Index Number Generation';
            $message = "Dear $full_name, <p>Thank you for registering with <b>Allied Health Professions Council.</b>. Your index
            number for your exam is $prov and is valid for use. </p>
            <p>Thank you.</p>";

            SendEmail::compose($email_address,$subject,$message);
            echo 3;
        }
    }

    else {

        $mysqli->query("update examination_reg set
        exam_admincheck_user = '$user_id',
        exam_admincheck_status = '$approve_state',
        exam_admincheck_comment = '$remark',
        exam_admincheck_date = '$datetime'

        where examination_id = '$examination_id'") or die(mysqli_error($mysqli));

        $subject = 'AHPC Application Rejected';

        $message = "Dear $full_name, <p>Thank you for registering with <b>Allied Health
Professions Council.</b>.Your application has been rejected due to the following reasons : <br/>
<b>$remark.</b> <br/>
Please correct your errors and submit your application. </p>
<p>Thank you.</p>
";

        SendEmail::compose($email_address,$subject,$message);
        echo 4;

    }

}



?>