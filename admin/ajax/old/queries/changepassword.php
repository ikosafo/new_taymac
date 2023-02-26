<?php
include('../../../config.php');

$user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);
$new_password = mysqli_real_escape_string($mysqli, $_POST['new_password']);
$current_password = mysqli_real_escape_string($mysqli, $_POST['current_password']);

$password = md5($current_password);
$n_password = md5($new_password);
$today = date("Y-m-d H:i:s");

$que = $mysqli->query("select * from mis_users where password = '$password'");
$count = mysqli_num_rows($que);

if ($count == "0"){
    echo 2;
}
else {
    $mysqli->query("UPDATE `mis_users`
SET
`password` = '$n_password'
WHERE `user_id` = '$user_id'") or die(mysqli_error($mysqli));
    echo 1;
}





?>