<?php

include('../../../config.php');

$date_started = mysqli_real_escape_string($mysqli, $_POST['date_started']);
$date_completed = mysqli_real_escape_string($mysqli, $_POST['date_completed']);
$reg_type = mysqli_real_escape_string($mysqli, $_POST['reg_type']);

$datetime = date("Y-m-d H:i:s");

$que = $mysqli->query("select * from date_config where registration_type = '$reg_type'");
$count = mysqli_num_rows($que);

if ($count == "0") {

    $mysqli->query("INSERT INTO `date_config`
            (`date_started`,
             `date_completed`,
             `registration_type`)
VALUES ('$date_started',
        '$date_completed',
        '$reg_type')") or die(mysqli_error($mysqli));
    echo 1;
}

else {
    echo 2;
}

?>