<?php

include('../../../config.php');

$user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);
$correct_pin = mysqli_real_escape_string($mysqli, $_POST['correct_pin']);
$wrong_pin = mysqli_real_escape_string($mysqli, $_POST['wrong_pin']);
$datetime = date('Y-m-d H:i:s');


//Check for pin
$chk = $mysqli->query("select * from provisional where applicant_id = '$wrong_pin'");
$countpin = mysqli_num_rows($chk);
if ($countpin == "0") {
    echo 2;
}

else if ($countpin == "1") {

    $chkcorrectpin = $mysqli->query("select * from renewal_upload where cpdpin = '$correct_pin'");
    if (mysqli_num_rows($chkcorrectpin) == '1'){

        //if it's in table
        $chkp = $mysqli->query("select * from provisional where applicant_id = '$correct_pin'");

        //if it's not
        if (mysqli_num_rows($chkp) == "0") {
            $mysqli->query("INSERT INTO `renewal_pin_updates`
            (`correct_pin`,
             `wrong_pin`,
             `user`,
             `period`)
VALUES ('$correct_pin',
        '$wrong_pin',
        '$user_id',
        '$datetime')") or die(mysqli_error($mysqli));


            //update provisional table
            $mysqli->query("update provisional set applicant_id = '$correct_pin', provisional_pin = '$correct_pin' where applicant_id = '$wrong_pin'");

            //update image
            $mysqli->query("update applicant_images set applicant_id = '$correct_pin' where applicant_id = '$wrong_pin'");

            //renewal
            $mysqli->query("update renewal set applicant_id = '$correct_pin' where applicant_id = '$wrong_pin'");

            //cpd event
            $mysqli->query("update cpd_event set applicant_id = '$correct_pin' where applicant_id = '$wrong_pin'");

            //cpd uploads
            $mysqli->query("update cpd_uploads set applicant_id = '$correct_pin' where applicant_id = '$wrong_pin'");

            //identification
            $mysqli->query("update applicant_identification set applicant_id = '$correct_pin' where applicant_id = '$wrong_pin'");

            //identification docs
            $mysqli->query("update applicant_identification_docs set applicant_id = '$correct_pin' where applicant_id = '$wrong_pin'");
            echo 1;
        }

        else {
            //aleady in table
            echo 3;
        }
    }
    else {
        //correct not in renewal_upload table
        echo 4;
    }

}

