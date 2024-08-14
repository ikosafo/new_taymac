<?php
//create a class called AppLogs to handle logging. write to a file called app.log
// Path: app/libraries/AppLogs.php
class AppLogs{
    public static $logFile = APPROOT.'/logs/app.log';
    public static $dblogFile = APPROOT.'/logs/db.log';

    //db logs
    public static function dblog($message){
        $logFile = self::$dblogFile;
        $date = date('Y-m-d H:i:s');
        $log = fopen($logFile, 'a');
        fwrite($log, $date.' '.$message."\n");
        fclose($log);
    }

    public static function log($message){
        $logFile = self::$logFile;
        $date = date('Y-m-d H:i:s');
        $log = fopen($logFile, 'a');
        fwrite($log, $date.' '.$message."\n");
        fclose($log);
    }


}
