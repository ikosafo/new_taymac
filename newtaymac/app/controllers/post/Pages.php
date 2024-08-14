<?php

class Pages extends PostController
{

   /*  public function login()
    {
        foreach ($_POST as $name => $value) {
            $$name = $value;
        }

        $login = new users();
        $login->login($username, $password);
    } */

    public function fileupload()
    {

        foreach ($_POST as $name => $value) {
            $$name = $value;
        }

        $name = $_FILES['Filedata']['name'];
        $type = $_FILES['Filedata']['type'];
        $size = $_FILES['Filedata']['size'];

        $docdate = date("Y-m-d");
        $uploads = new Uploads();
        $uploads->filename = $_FILES['Filedata'];
        $uploads->target_dir = UPLOADPATH;
        $uploadresponse = $uploads->upLoadFile();

        if ($uploadresponse['status'] == 'SUCCESS') {

            echo  $newname = $uploadresponse['filename'];
            $docdata = new Documents();
            $doc = &$docdata->recordObject;
            $doc->newname = $newname;
            $doc->name = $name;
            $doc->type = $type;
            $doc->size = $size;
            $doc->randomnumber = $uniqueuploadid;
            $doc->docdate = $docdate;
            $docdata->store();
        } else {
            echo 'Error Uploading File';
        }
    }
}
