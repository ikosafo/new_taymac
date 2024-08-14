<?php

// constant to allow additional includes, debug fuctions, whatever only on dev environments...
define ('DEVMODE', false);

// enable disabling of UI during maintenance
define ('MAINTENANCE', false);

// if this is uncommented, request routing changes! See Core.php!
// define('ROUTE_REQUEST',true);

// timezone, different on server
date_default_timezone_set('Europe/London');

//DB Configuartions
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', '');
define('DB_PORT', 3306);
// Application Root
define('APPROOT', dirname(dirname( __FILE__ )));

dirname(dirname( __FILE__ ));
// URL ROOT
define('URLROOT', 'http://URL PATH/');



