<?php
include('../../../config.php');

$surname = mysqli_real_escape_string($mysqli, $_POST['surname']);
$firstname = mysqli_real_escape_string($mysqli, $_POST['firstname']);
$othername = mysqli_real_escape_string($mysqli, $_POST['othername']);
$email_address = mysqli_real_escape_string($mysqli, $_POST['email_address']);
$telephone = mysqli_real_escape_string($mysqli, $_POST['telephone']);
$institution = mysqli_real_escape_string($mysqli, $_POST['institution']);
$completion_year = mysqli_real_escape_string($mysqli, $_POST['completion_year']);
$reason = mysqli_real_escape_string($mysqli, $_POST['reason']);
$pin = mysqli_real_escape_string($mysqli, $_POST['pin']);
$profession = mysqli_real_escape_string($mysqli, $_POST['profession']);
$user_id = $_SESSION['user_id'];

$today = date("Y-m-d H:i:s");
$username = $_SESSION['username'];

ob_start();
system('ipconfig /all');
$mycom = ob_get_contents();
ob_clean();
$findme = 'physique';
$pmac = strpos($mycom, $findme);
$mac_address = substr($mycom, ($pmac + 33), 17);

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}
$ip_add = getRealIpAddr();

$getp = $mysqli->query("select * from professions WHERE professionname = '$profession'");
$getid = $getp->fetch_assoc();
$professionid = $getid['professionid'];
$datetime = date("Y-m-d H:i:s");

$count = $mysqli->query("select * from renewal_special_cases 
where email_address = '$email_address'");
$res_count = mysqli_num_rows($count);


if ($res_count == "0") {
    $mysqli->query("INSERT INTO `renewal_special_cases`
            (`surname`,
             `firstname`,
             `othername`,
             `email_address`,
             `telephone`,
             `institution`,
             `completion_year`,
             `reason`,
             `pin`,
             `profession`,
             `professionid`,
             `userid`,
             `period`)
VALUES ('$surname',
        '$firstname',
        '$othername',
        '$email_address',
        '$telephone',
        '$institution',
        '$completion_year',
        '$reason',
        '$pin',
        '$profession',
        '$professionid',
        '$user_id',
        '$datetime')") or die(mysqli_error($mysqli));

    $mysqli->query("INSERT INTO `logs_mis`
(`message`,
`logdate`,
`username`,
`mac_address`,
`ip_address`,
`action`)
VALUES ('Added a renewal special code for $email_address',
'$today',
'$username',
'$mac_address',
'$ip_add',
'Successful')") or die(mysqli_error($mysqli));

    $full_name = $surname . ' ' . $firstname . ' ' . $othername;

    /*
        $subject = 'AHPC Code Generation';

        $message = "Dear <span style='text-transform: uppercase'>$full_name</span>, <p>Thank you for registering with <b>Allied Health
    Professions Council.</b>. The code to use for your examination registration is <b>$random</b>. <br/>
    Log in to the examination registration portal with the code. </p>
    <p>Thank you.</p>
    ";

        SendEmail::compose($email_address, $subject, $message);*/

    echo 1;
} else {
    echo 2;
}
