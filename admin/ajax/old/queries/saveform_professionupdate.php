<?php
include('../../../config.php');

$user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);
$provisionalid = mysqli_real_escape_string($mysqli, $_POST['emailapp']);
$profession = mysqli_real_escape_string($mysqli, $_POST['profession']);
$newprofession = mysqli_real_escape_string($mysqli, $_POST['newprofession']);
$today = date("Y-m-d H:i:s");
$getname = $mysqli->query("select * from professions where professionid = '$newprofession'");
$resname = $getname->fetch_assoc();
$professionname = $resname['professionname'];

$getapp = $mysqli->query("select * from provisional where provisionalid = '$provisionalid'");
$resapp = $getapp->fetch_assoc();
$applicant_id = $resapp['applicant_id'];
$fullname = $resapp['surname'].' '.$resapp['first_name'].' '.$resapp['other_name'];
$email_address = $resapp['email_address'];
$professionid = $resapp['professionid'];

    if ($professionid == $profession) {

        if ($profession == $newprofession) {
            echo 3;
        }
        else {
            $mysqli->query("UPDATE provisional  SET professionid = '$newprofession', profession = '$professionname'
                         WHERE applicant_id = '$applicant_id'") or die(mysqli_error($mysqli));

            $mysqli->query("INSERT INTO `profession_update`
            (`applicant_id`,
             `oldprofession`,
             `newprofession`,
             `userid`,
             `period`
             )
VALUES (
    '$applicant_id',
    '$profession',
    '$newprofession',
    '$user_id',
    '$today'
    )") or die(mysqli_error($mysqli));

            $subject = 'Profession Update';

            $message = "Dear <span style='text-transform: uppercase'>$fullname</span>,
               <p>Your updated profession is $professionname.</p>
               <p>Thank you.</p>
    ";

            SendEmail::compose($email_address, $subject, $message);

            echo 1;
        }

    }
    else {
        echo 2;
    }


