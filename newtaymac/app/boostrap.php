
<?php

// Including the configuration file
require_once 'config/config.php';
require_once 'config/config_env.php';


ini_set('display_errors', 1);  // Hide all errors from the user
// hide all warnings from the user
//error_reporting(E_ALL ^ E_WARNING);

// Load everything we require via composer
require('../vendor/autoload.php');

require_once 'helpers/phpexcel/PHPExcel/IOFactory.php';
require_once 'helpers/phpexcel/PHPExcel/Writer/IWriter.php';


/*
 * Autoload Core Libraries
 *
 * Note: We are not using namespaces, so this will
 * blow up in our faces if we have any duplicate class
 * names! TODO: consider using namespaces!
 */
spl_autoload_register(function($class){

    $pathContorllers = APPROOT . '/controllers/' . $class . '.php';
    $pathLibs = APPROOT . '/libraries/' . $class . '.php';
    $pathModels = APPROOT . '/models/' . $class . '.php';
    $pathServices = APPROOT . '/service/' . $class . '.php';

    if (file_exists($pathContorllers)) {
        require_once $pathContorllers;
    } elseif (file_exists($pathLibs)) {
        require_once $pathLibs;
    } elseif (file_exists($pathModels )) {
        require_once $pathModels ;
    } elseif (file_exists($pathServices )) {
        require_once $pathServices ;

    }

});

/**
 * We are always going to need the database, so we are going to
 * create our database object here. It can then be referenced
 * in class member functions as "global $marketplacedb"
 */

$healthdb = new Database();
//$client = new Google_Client();

// function pokemon($exception){
//     // new Logger("An unhandled error occurred: " . strip_tags($exception),"error");
//      // echo $exception;
//      // exit();
 
//      $errordata = [
//          'errormessage' => $exception
//      ];
 
//      $errordisplaycontroller = new Controller();
//      $errordisplaycontroller->view("pages/errorpage", $errordata);
 
//      exit();
//  }
 
 // Gotta catch 'em all!
 //set_exception_handler('pokemon');

// We also always need the session object, and need to create it before any output.

$getuser = "SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
$healthdb->prepare($getuser);
$healthdb->execute();
session_start();

?>
