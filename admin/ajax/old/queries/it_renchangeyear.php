<?php

include('../../../config.php');

$applicant_id = mysqli_real_escape_string($mysqli, $_POST['applicant_id']);
$select_changeyear = mysqli_real_escape_string($mysqli, $_POST['select_changeyear']);
$year_search = mysqli_real_escape_string($mysqli, $_POST['year_search']);
$user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);
$datetime = date("Y-m-d H:i:s");


$mysqli->query("INSERT INTO `renewalyear_changes`
(`applicant_id`,
 `previous_year`,
 `new_year`,
 `userid`,
 `periodchanged`)
    VALUES (
    '$applicant_id',
    '$year_search',
    '$select_changeyear',
    '$user_id',
    '$datetime')") or die(mysqli_error($mysqli));

    $mysqli->query("update renewal
    set
        cpdyear = '$select_changeyear'

        where (applicant_id = '$applicant_id' AND cpdyear = '$year_search')
    ") or die(mysqli_error($mysqli));

    echo 1;


?>