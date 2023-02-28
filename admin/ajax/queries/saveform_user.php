<?php
include('../../../config.php');

$fullname = mysqli_real_escape_string($mysqli, $_POST['fullname']);
$username = mysqli_real_escape_string($mysqli, $_POST['username']);
$password = mysqli_real_escape_string($mysqli, $_POST['password']);
$usertype = mysqli_real_escape_string($mysqli, $_POST['usertype']);
$pass = md5($password);
$random = rand(1, 10000) . date("Ymd");


$mysqli->query("INSERT INTO `taymac_mis_users`
            (
             `full_name`,
             `username`,
             `password`,
             `user_id`,
             `usertype`,
             `see`)
VALUES (
        '$fullname',
        '$username',
        '$pass',
        '$random',
        '$usertype',
        '1')") or die(mysqli_error($mysqli));

echo 1;


foreach ($_POST['permission'] as $permission) {

        $mysqli->query("INSERT INTO permission
            (`permission`,
             `username`)
VALUES ('$permission',
        '$username')")
                or die(mysqli_error($mysqli));
}
