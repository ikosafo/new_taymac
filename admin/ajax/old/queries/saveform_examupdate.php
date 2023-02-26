<?php

include('../../../config.php');

$user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);
$proid = mysqli_real_escape_string($mysqli, $_POST['emailapp']);
$schoolindex = mysqli_real_escape_string($mysqli, $_POST['schoolindex']);
$ahpcindex = mysqli_real_escape_string($mysqli, $_POST['ahpcindex']);
$datetime = date('Y-m-d H:i:s');


//Check for email
$chk = $mysqli->query("select email_address from provisional where provisionalid = '$proid'");
$result = $chk->fetch_assoc();
$appemail = $result['email_address'];

//Check for applicant
$getapp = $mysqli->query("select * from provisional where email_address = '$appemail' AND applicant_id = '$schoolindex'");
$countapp = mysqli_num_rows($getapp);

if ($countapp == "1") {

    $resultapp = $getapp->fetch_assoc();
    $ahpcindexnumber = $resultapp['exam_index_number'];
    $examreg = $resultapp['examination_registration'];

    if (($ahpcindexnumber == '' || $ahpcindexnumber == null) && $examreg == "1") {


        $mysqli->query("INSERT INTO `indexnumber_error`
            (`emailaddress`,
             `applicantid`,
             `provisionalid`,
             `indexnumber`,
             `user`,
             `period`)
VALUES ('$appemail',
        '$schoolindex',
        '$proid',
        '$ahpcindex',
        '$user_id',
        '$datetime')") or die(mysqli_error($mysqli));

        //update provisional table
        $mysqli->query("update provisional set exam_index_number = '$ahpcindex'
where (provisionalid = '$proid' AND applicant_id = '$schoolindex')");

        echo 1;
    }
    else {

        echo 2;
    }

}

else {
    echo 3;
}




?>