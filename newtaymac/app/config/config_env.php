<?php

// constant for microsoft partner center (MICROSOFT GLOBAL) for App Credentials

// Constant to secure "cron" jobs

define('JSVARS',serialize(array(
	'urlroot' => URLROOT
)));

// Email SMTP Configurations
define('SMTP_PREFIX', 'ssl');
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 465);
define('MAIL_USERNAME', 'poqacompany@gmail.com');
define('MAIL_PASSWORD', 'poqacompany@2019');
//define('COMMEHR_EMAIL', 'prince@getinnotized.com');
define('MAIL_TO','poqacompany@gmail.com');
if(!defined('SITENAME')){
	define('SITENAME','CV Database');
}

define('COMPANYNAME', 'CV');

define('ROUTE_REQUEST',true);

define('ADMIN', 1);
define('EMPLOYER', 2);
define('CANDIDATE', 3);

define('CVPRICE', 10);


?>
