<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 2/23/2018
 * Time: 7:11 AM
 */


/**
 * Class Logger
 *
 * This class needs no actual methods for writing logs.
 *
 * Simply create a new Logger object, set the properties, and
 * new Logger($message) - Logger will do only a little to set defaults
 * if needed before calling store.
 *
 * Log categories are maintained in the table logcategories simply
 * to enforce specific values in that log column. For reference, look at
 * that table, but initial categories are
 * -- 'administrator action'
 * -- 'customer action'
 * -- 'system - general'
 * -- 'system - scheduled'
 * -- 'information' (default if not set)
 *
 * The only requirement is that
 * logmessage must be set by the caller.
 *
 */
class Logger extends tableDataObject {

    const TABLENAME = 'systemlog';

    public function __construct($logmessage,$logcategory = null,$user = null,$diagnostic = null){

        parent::__construct();

        $ro =& $this->recordObject;

        foreach (['logmessage','user','logcategory','diagnostic'] as $logproperty){
            if ($$logproperty != null){
                $ro->$logproperty = $$logproperty;
            }
        }
        if(defined('MUTEDEBUG') && $logcategory == 'debug'){
            /*
             * this condition mutes the logging of debug entries
             * becuase the systemlog gets HUGE too quickly.
             *
             * TODO - determine if we need to do something other than logging in the db here
             */
        } else {
            $this->store();
        }
    }

    public static function logView($days = 1,$debug = false){
        global $marketplacedb;

        if($debug === false){
            $debugc = " and logcategory != 'debug' ";
        } else {
            $debugc = "";
        }

        $logQ = "select * from systemlog 
                  where timestamp >= date_sub(now(),interval $days day)
                  $debugc
                  order by timestamp desc limit 1000";
        $marketplacedb->prepare($logQ);
        $logentries = $marketplacedb->resultSet();
        return $logentries;
    }

    public static function getDiag($id){
        global $marketplacedb;
        $dQ = "select diagnostic from systemlog where idsystemlog = $id";
        $marketplacedb->prepare($dQ);
        $dinfo = $marketplacedb->fetchColumn();
        if(unserialize($dinfo) !== false){
            return unserialize($dinfo);
        } else {
            return $dinfo;
        }
    }

}
