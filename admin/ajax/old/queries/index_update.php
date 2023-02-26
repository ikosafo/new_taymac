<?php
include('../../../config.php');

$examination_id = mysqli_real_escape_string($mysqli, $_POST['examination_id']);
$applicant_id = mysqli_real_escape_string($mysqli, $_POST['applicant_id']);
$app_index = mysqli_real_escape_string($mysqli, $_POST['app_index']);
$date = date('Y-m-d H:i:s');
$user_id = $_SESSION['user_id'];

$getoldid = $mysqli->query("select * from provisional where applicant_id = '$applicant_id'");
$resoldid = $getoldid->fetch_assoc();
$index_number = $resoldid['exam_index_number'];
$email_address = $resoldid['email_address'];
$full_name = $resoldid['first_name'].' '.$resoldid['other_name'].' '.$resoldid['surname'];

if ($app_index == $index_number) {

    //Same pin error
    echo 2;
}

else {
    $checkpin = $mysqli->query("select * from provisional where exam_index_number = '$app_index'");
    $countpin = mysqli_num_rows($checkpin);
    if ($countpin > 0) {

        //Pin belongs to someone else
        echo 3;
    }
    else {


        $mysqli->query("update examination_reg set
            indexnumber = '$app_index'
            where examination_id = '$examination_id'") or die(mysqli_error($mysqli));

        $mysqli->query("update provisional set
            exam_index_number = '$app_index'
            where applicant_id = '$applicant_id'") or die(mysqli_error($mysqli));

        $subject = 'AHPC Index Number (Correction)';
        $message = "Dear $full_name,

<p><b>CORRECTION: </b> Thank you for registering with <b>Allied Health Professions Council.</b>.
Your index number for your exam is $app_index and is valid for use. </p>
            <p>Thank you.</p>";

        SendEmail::compose($email_address,$subject,$message);
        echo 1;

    }

}


?>