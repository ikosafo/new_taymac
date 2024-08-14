<?php

//DB Configuartions
define('DB_HOST', 'localhost');
define('DB_USER', 'ahpcgh_root');
define('DB_PASS', 'Server@2019$');
define('DB_NAME', 'ahpcgh_nmis');
define('DB_PORT', '3306');


//site constants
define('SITENAME', 'AHPC');
define('FOOTER', '© ' . date('Y'));
define('APPROOT', dirname(dirname(__FILE__)));
define('URLROOT', 'http://newmis.local/');
define('URLMIS', 'https://mis.ahpcgh.org');

// define('USERNAME', 'newjodabri@gmail.com');
// define('PASSWORD', 'Server@2019$');
define('UPLOADPATH', APPROOT . '/uploads');
define('USERNAME', 'postmaster@sandbox3233d1207fe742d394f47477bd7d621e.mailgun.org');
define('PASSWORD', '81655549f4db3b986a80fdb0d7538a1b-4d640632-59835a7d');

define('MFCEMAIL', 'info@ahpcgh.org');
define('MFCSENDEREMAIL', 'postmaster@sandbox3233d1207fe742d394f47477bd7d621e.mailgun.org');

define("LOCKED", 'no');

// dublicate code
// SELECT pin, COUNT(pin), firstname, COUNT(firstname)
// FROM 
//      renewalpaylist
// GROUP BY
//      pin, firstname
// HAVING 
//      COUNT(pin) > 1
   

//    delete t1 FROM renewalpaylist t1
// INNER  JOIN renewalpaylist t2
// WHERE
//     t1.payid < t2.payid AND
//     t1.pin = t2.pin AND
//     t1.emailaddress = t2.emailaddress AND
//     t1.provisionalid = t2.provisionalid;