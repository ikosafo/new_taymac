<?php
include('../../../config.php');

$member_name = mysqli_real_escape_string($mysqli, $_POST['member_name']);
$member_position = mysqli_real_escape_string($mysqli, $_POST['member_position']);
$member_mobile = mysqli_real_escape_string($mysqli, $_POST['member_mobile']);
$member_email = mysqli_real_escape_string($mysqli, $_POST['member_email']);
$member_description = mysqli_real_escape_string($mysqli, $_POST['member_description']);

$mysqli->query("INSERT INTO `taymac_team`
            (
             `member_name`,
             `member_position`,
             `member_mobile`,
             `member_email`,
             `member_description`
             )
VALUES (
        '$member_name',
        '$member_position',
        '$member_mobile',
        '$member_email',
        '$member_description')"
            ) or die(mysqli_error($mysqli));

echo 1;
