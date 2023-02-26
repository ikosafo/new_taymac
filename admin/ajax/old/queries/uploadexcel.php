<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include('../../../config.php');

if (isset($_POST["Import"])) {

    $filename = $_FILES["file"]["tmp_name"];

    if ($_FILES["file"]["size"] > 0) {

        $file = fopen($filename, "r");
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {

            //It wiil insert a row to our internshiplist table from our csv file`
            $result = $mysqli->query("INSERT into internshiplist (`fullname`, `pin`, `placeofposting`) 
            values('$emapData[1]','$emapData[2]','$emapData[3]')");
            //we are using mysql_query function. it returns a resource on true else False on error
            /* $result = mysqli_query($mysqli, $sql); */
            if (!$result) {
                echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
                            window.location = \"../../it_internship_list\"
						</script>";
            }
        }
        fclose($file);
        //throws a message if data successfully imported to mysql database from excel file
        echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"../../it_internship_list\"
					</script>";


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

        $mysqli->query("INSERT INTO `logs_mis`
            (`message`,
            `logdate`,
            `username`,
            `mac_address`,
            `ip_address`,
            `action`)
            VALUES ('Uploaded an internship list',
            '$today',
            '$username',
            '$mac_address',
            '$ip_add',
            'Successful')") or die(mysqli_error($mysqli));



        //close of connection
        mysqli_close($mysqli);
    }
}
