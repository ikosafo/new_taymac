<?php

include('../../../config.php');

$applicant_id = mysqli_real_escape_string($mysqli, $_POST['applicant_id']);
$query = $mysqli->query("select * from provisional where applicant_id = '$applicant_id'");
$result = $query->fetch_assoc();
$email_address = $result['email_address'];

$getemail = $mysqli->query("select * from provisional where email_address = '$email_address'
                            and examination_registration = '1'");
$resemail = $getemail->fetch_assoc();
$theid = $resemail['provisionalid'];

if (mysqli_num_rows($getemail) == '1')

        {
            $getemail2 = $mysqli->query("select * from provisional where email_address = '$email_address'
                      and examination_registration !='1'");
            $resemail2 = $getemail2->fetch_assoc();
            $theid2 = $resemail2['provisionalid'];

            $mysqli->query("update provisional set examination_registration = '1' where provisionalid = '$theid2'")
            or die(mysqli_error($mysqli));

            $mysqli->query("INSERT INTO `deleted` SELECT * FROM `provisional` WHERE provisionalid = '$theid'");
            $mysqli->query("delete from `provisional` where provisionalid = '$theid'") or die(mysqli_error($mysqli));
             echo 1;
        }
        else
        {
            echo 2;
        }

?>