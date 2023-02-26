<?php
include('../../../config.php');

$user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);
$proid = mysqli_real_escape_string($mysqli, $_POST['emailapp']);
$newemail = mysqli_real_escape_string($mysqli, $_POST['newemail']);
$datetime = date('Y-m-d H:i:s');

//Check for pin
$chk = $mysqli->query("select email_address from provisional where provisionalid = '$proid'");
$result = $chk->fetch_assoc();
$oldemail = $result['email_address'];



$chkcorrectpin = $mysqli->query("select * from account_login where email_address = '$newemail' and email_verified = 1");
if (mysqli_num_rows($chkcorrectpin) == '1'){

    //if it's in table
    $chkp = $mysqli->query("select * from provisional where email_address = '$newemail'");

    //if it's not
    if (mysqli_num_rows($chkp) == "0") {
        $mysqli->query("INSERT INTO `email_error_updates`
            (`oldemail`,
             `newemail`,
             `provisionalid`,
             `user`,
             `period`)
VALUES ('$oldemail',
        '$newemail',
        '$proid',
        '$user_id',
        '$datetime')") or die(mysqli_error($mysqli));


        //update provisional table
        $mysqli->query("update provisional set email_address = '$newemail' where provisionalid = '$proid'");

        echo 1;

    }

    else {
        //emial address aleady in table
        echo 3;
    }
}

else {
    //new email not verified in accounts login
    echo 4;
}








?>