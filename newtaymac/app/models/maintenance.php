<?php

class maintenance extends tableDataObject
{

    

    public static function listTables()
    {
        global $healthdb;
        $query = "show tables";
        $healthdb->prepare($query);
        $tabels =  $healthdb->resultSet();

        foreach($tabels as $tabel):
             $t[] = $tabel->Tables_in_ahcpgh_registration;
        endforeach;
        return $t;
    }
    
   
}
