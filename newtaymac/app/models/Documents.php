<?php

class Documents extends tableDataObject{

    const TABLENAME = 'documents';

    public static function listdocuments($tablename,$randomnumber){
        global $healthdb;
        $listquery="select * from documents join $tablename on documents.randomnumber=$tablename.randomnumber where $tablename.randomnumber='$randomnumber'";
        $healthdb->prepare($listquery);
        return $healthdb->resultSet();
    }
}