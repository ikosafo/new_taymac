<?php

class role extends tableDataObject
{

    const TABLENAME = 'role';

    public static function listroles()
    {
        $accesslevel = $_SESSION['accesslevel'];
        global $healthdb;
        if ($accesslevel == 'Super') {
            $getuser = "SELECT * FROM role where roleid <> 1 and roleid <> 6";
        } else {
            $accesslevel = explode(' ', $accesslevel);
            $first = $accesslevel[0];
            $getuser = "SELECT * FROM role WHERE role like '$first%'";

        }
        $healthdb->prepare($getuser);
        return $healthdb->resultSet();
    }
}
