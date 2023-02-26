<?php
include('../../../config.php');

$regtype = mysqli_real_escape_string($mysqli, $_POST['regtype']);
$sub = mysqli_real_escape_string($mysqli, $_POST['subject']);
$mes = $_POST['message'];
$datesent = date('Y-m-d H:i:s');

    $mysqli->query("INSERT INTO `bulkmails`
            (`subject`,
             `applicant`,
             `message`,
             `datesent`)
VALUES ('$sub',
        '$regtype',
        '$mes',
        '$datesent')") or die(mysqli_error($mysqli));

if ($regtype == 'All Applicants') {
    $getemail = $mysqli->query("select * from provtest");
}

else if ($regtype == 'Permanent') {
    $getemail = $mysqli->query("select * from provtest where permanent_registration = '1'");
}

else if ($regtype == 'Provisional') {
    $getemail = $mysqli->query("select * from provtest where provisional_registration = '1'");
}

else if ($regtype == 'Temporal') {
    $getemail = $mysqli->query("select * from provtest where temporal_registration = '1'");
}

else if ($regtype == 'Indexing') {
    $getemail = $mysqli->query("select * from provtest where indexing = '1'");
}

else if ($regtype == 'Indexing') {
    $getemail = $mysqli->query("select * from provtest where examination_registration = '1'");
}

else if ($regtype == 'General Public') {
    $getemail = $mysqli->query("select * from account_login");
}


while ($resemail = $getemail->fetch_assoc()) {

    $email_address = $resemail['email_address'];
    $subject = $sub;
    $message = $mes;

    SendEmail::compose($email_address,$subject,$message,true);
    echo 1;
}



?>