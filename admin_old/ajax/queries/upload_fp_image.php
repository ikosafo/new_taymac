<?php
include('../../../config.php');

$randno = $_POST['randno'];
$today = date('Y-m-d H:i:s');
$target_path = "../../uploads/fp/";
$rand = rand(1,100000);
$allowed =  array('gif','png' ,'jpg', 'jpeg');
$ext = pathinfo($_FILES['Filedata']['name'], PATHINFO_EXTENSION);

$filename =  $_FILES['Filedata']['name'];
$newfile = 'uploads/fp/'.date('Ymd').$rand.".".$ext;
$target_path = "../../uploads/fp/".date('Ymd').$rand.".".$ext;
$filetype =  $_FILES['Filedata']['type'];
$filesize =  $_FILES['Filedata']['size'];


if(move_uploaded_file($_FILES['Filedata']['tmp_name'], $target_path)) {
    echo $success =  "The file ".  basename( $_FILES['Filedata']['name']). " has been uploaded";
}
else
{
    echo $error = "There was an error uploading the file, please try again!";
}

$chk = $mysqli->query("select * from taymac_image_fp where imageid = '$randno'");
$count = mysqli_num_rows($chk);

if ($count == "0"){
    $insertfile  = $mysqli->query("INSERT INTO `taymac_image_fp`
            (`image_name`,
             `image_location`,
             `image_size`,
             `image_type`,
             `dateuploaded`,
             `imageid`)
VALUES ('$filename',
    '$newfile',
    '$filesize',
    '$filetype',
    '$today',
    '$randno')") or die ();

    echo 1;
}

else {
    $query = $mysqli->query("select * from taymac_image_fp where applicant_id = '$randno'");
    $res = $query->fetch_assoc();
    $filename2 =  $res['image_location'];

    $use = substr($filename2,strpos($filename2,"/")+1);

    unlink("../../uploads/".$use);

    $updatefile  = $mysqli->query("UPDATE `taymac_image_fp`
SET
  `image_name` = '$filename',
  `image_location` = '$newfile',
  `image_size` = '$filesize',
  `image_type` = '$filetype'

WHERE `imageid` = '$randno'") or die ();

    echo 2;

}
?>

