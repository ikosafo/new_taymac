<?php
include('../../../config.php');

$fullname = $_SESSION['full_name'];

$category = mysqli_real_escape_string($mysqli, $_POST['category']);
$title = mysqli_real_escape_string($mysqli, $_POST['title']);
$content = mysqli_real_escape_string($mysqli, $_POST['content']);
$imageid = mysqli_real_escape_string($mysqli, $_POST['imageid']);
$datetime = date("Y-m-d H:i:s");

$mysqli->query("INSERT INTO `taymac_blog`
            (
            `category`,
             `blog_text`,
             `title`,
             `imageid`,
             `user`,
             `dateuploaded`
             )
VALUES ('$category',
        '$content',
        '$title',
        '$imageid',
        '$fullname',
        '$datetime')") or die(mysqli_error($mysqli));

echo 1;
