<?php
include('../../../config.php');

$emailaddress = mysqli_real_escape_string($mysqli, $_POST['emailaddress']);
$pin = mysqli_real_escape_string($mysqli, $_POST['pin']);
$date = date('Y-m-d H:i:s');
$user_id = $_SESSION['user_id'];

$getoldpin = $mysqli->query("select * from provisional where email_address = '$emailaddress'");
$resoldpin = $getoldpin->fetch_assoc();
$provisional_pin = $resoldpin['provisional_pin'];


if ($provisional_pin == $pin) {

    //Same pin error
    echo 2;
}

else {

    $mysqli->query("INSERT INTO `pin_updates`
            (`oldpin`,
             `newpin`,
             `dateupdated`,
             `userid`)
VALUES ('$provisional_pin',
        '$pin',
        '$date',
        '$user_id')") or die(mysqli_error($mysqli));

    $updatepin = $mysqli->query("UPDATE provisional SET provisional_pin = '$pin' WHERE email_address = '$emailaddress'");
  
    echo 1;

}


?>