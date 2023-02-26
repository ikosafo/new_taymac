<?php
include('../../../config.php');

$applicant_id = mysqli_real_escape_string($mysqli, $_POST['applicant_id']);
$examination_id = mysqli_real_escape_string($mysqli, $_POST['examination_id']);
$internship_period = mysqli_real_escape_string($mysqli, $_POST['internship_period']);
$facility = mysqli_real_escape_string($mysqli, $_POST['facility']);
$exam_center = mysqli_real_escape_string($mysqli, $_POST['exam_center']);
$date_registered = mysqli_real_escape_string($mysqli, $_POST['date_registered']);
$email_address = $_SESSION['email_address'];
$datetime = date("Y-m-d H:i:s");

$mysqli->query("UPDATE `examination_reg`
SET
      `internship_period` = '$internship_period',
      `facility` = '$facility',
      `exam_center` = '$exam_center',
      `period_registered` = '$date_registered'


WHERE `examination_id` = '$examination_id'") or die(mysqli_error($mysqli));

echo 1;
