<?php
include('../../../config.php');

$i_id=$_POST['i_index'];

$getpayment = $mysqli->query("select * from provisional where provisionalid = '$i_id'");
$respayment = $getpayment->fetch_assoc();
$propay = $respayment['provisional_payment'];
$perpay = $respayment['permanent_payment'];

if ($propay == '1' || $perpay == '1') {
    echo 2;
}

else {
    $mysqli->query("INSERT INTO deleted
(SELECT * FROM provisional
WHERE provisionalid = '$i_id')") or die(mysqli_error($mysqli));

$mysqli->query("delete from provisional where provisionalid = '$i_id'")
                 or die(mysqli_error($mysqli));
    echo 1;
}


?>
