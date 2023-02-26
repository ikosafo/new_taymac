<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include('../../../config.php');

$full_name = mysqli_real_escape_string($mysqli, $_POST['full_name']);
$username = mysqli_real_escape_string($mysqli, $_POST['username']);
$pass = mysqli_real_escape_string($mysqli, $_POST['password']);
$user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);
$approval = mysqli_real_escape_string($mysqli, $_POST['approval']);
$password = md5($pass);

print_r($_POST);

$datetime = date("Y-m-d H:i:s");

$mysqli->query("INSERT INTO `mis_users`
            (`full_name`,
             `username`,
             `password`,
             `approval`,
             `user_id`)
VALUES ('$full_name',
        '$username',
        '$password',
        '$approval',
        '$user_id')") or die(mysqli_error($mysqli));

echo 1;


foreach ($_POST['permission'] as $permission)
{

    $mysqli->query("INSERT INTO permission
            (`permission`,
             `user_id`)
VALUES ('$permission',
        '$user_id')")
    or die(mysqli_error($mysqli));

}

?>