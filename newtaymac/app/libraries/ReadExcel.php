<?php

class ReadExcel
{

    // uploads for NSS applicants to do provisional registration
    public static function applicantexcel($filename, $uniqueuploadid)
    {
        $error = 0;

        $data = array("data" => array());
        $datetime = date("Y-m-d H:i:s");

        $extension = explode('.', $filename);
        if ($extension[1] == 'xlsx') {
            $inputFileType = 'Excel2007';
        } else {
            $inputFileType = 'Excel5';
        }
        $filename =UPLOADPATH.'/'. trim($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($filename);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10

            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            // print_r($highestColumn);
            // die();
            for ($row = 1; $row <= $highestRow; ++$row) {

                for ($col = 0; $col < $highestColumnIndex; ++$col) {

                    if ($row == 1) {

                        $no =strtoupper(trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue()));
                        $nssnumber =strtoupper(trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue()));
                        $surname =strtoupper(trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue()));
                        $othername =strtoupper(trim($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue()));
                        $institutionname =strtoupper(trim($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue()));
                        $program =strtoupper(trim($worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue()));
                        $placeofposting =strtoupper(trim($worksheet->getCellByColumnAndRow(6, $row)->getFormattedValue()));
                        $district =strtoupper(trim($worksheet->getCellByColumnAndRow(7, $row)->getFormattedValue()));
                        $region =strtoupper(trim($worksheet->getCellByColumnAndRow(8, $row)->getFormattedValue()));
                        $graduationyear =strtoupper(trim($worksheet->getCellByColumnAndRow(9, $row)->getFormattedValue()));

                        if ($no != 'NO') {
                            $error += 1;
                        }

                        if ($nssnumber != 'NSS NUMBER') {
                            $error += 1;
                        }

                        if ($surname != 'SURNAME') {
                            $error += 1;}

                        if ($othername != 'OTHER NAMES') {
                            $error += 1;}

                        if ($institutionname != 'INSTITUTION') {
                            $error += 1;}

                        if ($program != 'COURSE') {
                            $error += 1;}

                        if ($placeofposting != 'PLACE OF POSTING') {
                            $error += 1;}

                        if ($district != 'DISTRICT') {
                            $error += 1;}

                        if ($region != 'REGION') {
                            $error += 1;}

                        if ($graduationyear != 'YEAR OF GRADUATION') {
                            $error += 1;
                        }

                        if ($error > 0) {

                            Redirecting::location('education/graduatexcel', 'Please ensure all the column headings match the sample below', 'error');
                            exit();
                        } 

                    } else {

                        $no = trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue());
                        $nssnumber = trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue());
                        $surname = trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue());
                        $othername = trim($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue());
                        $institutionname = trim($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue());
                        $program = trim($worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue());
                        $placeofposting = trim($worksheet->getCellByColumnAndRow(6, $row)->getFormattedValue());
                        $district = trim($worksheet->getCellByColumnAndRow(7, $row)->getFormattedValue());
                        $region = trim($worksheet->getCellByColumnAndRow(8, $row)->getFormattedValue());
                        $graduationyear = trim($worksheet->getCellByColumnAndRow(9, $row)->getFormattedValue());

                        $fullname = $surname . ' ' . $othername;
                    }
                }

                // insertion code here
                /* $getdata = array("schoolname"=>$schoolname,"firstname"=>$firstname,"lastname"=>$lastname,"indexnumber"=>$indexnumber,"program"=>$program,"place of posting"=>$placeofposting,"graduatonyear"=>$graduationyear);
                array_push($data['data'],$getdata);

                $jsonstring = json_encode($data, JSON_PRETTY_PRINT);*/

                if ($row != '1') {
                    if (nationalservice::countexsitingdata($nssnumber) == 0) {
                        $nationaldata = new nationalservice();
                        $records = &$nationaldata->recordObject;
                        $records->fullname = $fullname;
                        $records->institution = $institutionname;
                        $records->program = $program;
                        $records->place_of_posting = $placeofposting;
                        $records->indexnumber = $nssnumber;
                        $records->applicant_id = $nssnumber;
                        $records->nssnumber = $nssnumber;
                        $records->year_of_completion = $graduationyear;
                        $records->district = $district;
                        $records->region = $region;
                        $records->uniqueid = $uniqueuploadid;
                        $records->datetime = $datetime;

                        if ($nationaldata->store()) {
                            if (institution::countexsitingdata($institutionname) == 0) {
                                $institution = new institution();
                                $data = &$institution->recordObject;
                                $data->nameofinstitution = $institutionname;
                                $institution->store();
                            }
                        }

                    }
                }

            }
            if ($error == 0) {
                Redirecting::location('education/graduatexcel', $uniqueuploadid);

            } else {
                Redirecting::location('education/graduatexcel', 'Please ensure all the column headings match the sample below', 'error');

            }

        }
    }

    // uploads for examniation excel after passing from provisional then to permanent
    public static function examexcel($filename, $uniqueuploadid, $professionid)
    {
        $error = 0;
        $professionname = profession::professionName($professionid);

        $data = array("data" => array());
        $datetime = date("Y-m-d H:i:s");

        $extension = explode('.', $filename);
        if ($extension[1] == 'xlsx') {
            $inputFileType = 'Excel2007';
        } else {
            $inputFileType = 'Excel5';
        }
        $filename =UPLOADPATH.'/'. trim($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($filename);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10

            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            for ($row = 1; $row <= $highestRow; ++$row) {

                for ($col = 0; $col < $highestColumnIndex; ++$col) {

                    if ($row == 1) {

                        $number =strtoupper(trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue()));
                        $fullname =strtoupper(trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue()));
                        $indexnumber =strtoupper(trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue()));
                        $marks =strtoupper(trim($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue()));
                        $remarks =strtoupper(trim($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue()));

                        
                  
                        if ($fullname != 'NAME') {
                            $error += 1;
                        }

                        if ($indexnumber != 'INDEX NUMBER') {
                            $error += 1;}

                        if ($marks != 'MARKS') {
                            $error += 1;
                        }
                        if ($remarks != 'REMARKS') {
                            $error += 1;
                        }

                        if ($error > 0) {

                            Redirecting::location('examination/examexcel', 'Please ensure all the column headings match the sample below', 'error');
                            exit();
                        } 

                    } else {
                        $number = trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue());
                        $fullname = trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue());
                        $indexnumber = trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue());
                        $marks = trim($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue());
                        $remarks = trim($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue());

                        // $arr = ['DR.', 'MISS.', 'MR.', 'MRS.', 'DR', 'MISS', 'MR', 'MRS', 'dr.', 'miss.', 'mr.', 'mrs.'];
                        // foreach ($arr as $word) {
                        //     $fullname = str_replace($word, "", $fullname);
                        //     $fullname = str_replace('  ', ' ', $fullname);
                        //     $fullname =trim($fullname);
                        // }
                        $name = explode(' ', $fullname);
                        $firstname = $name[0];
                        $lastname = $name[1];
                    }
                }

                // insertion code here
                if ($row != 1) {
                    $eid = exams::countexsitingdata($indexnumber);
                    $examsdata = new exams($eid);
                    $records = &$examsdata->recordObject;
                    $records->fullname = $fullname;
                    $records->indexnumber = $indexnumber;
                    $records->results = $marks;
                    $records->remarks = $remarks;
                    $records->indexnumber = $indexnumber;
                    $records->firstname = $firstname;
                    $records->lastname = $lastname;
                    $records->uniqueid = $uniqueuploadid;
                    $records->examdate = $datetime;
                    $records->profession = $professionname;
                    $records->professionid = $professionid;
                    $records->uploadedby = $_SESSION['uid'];

                    $examsdata->store();

                    // backup of new data uploaded
                    $examsdata1 = new examsbackup();
                    $records1 = &$examsdata1->recordObject;
                    $records1->fullname = $fullname;
                    $records1->indexnumber = $indexnumber;
                    $records1->results = $marks;
                    $records1->remarks = $remarks;
                    $records1->indexnumber = $indexnumber;
                    $records1->firstname = $firstname;
                    $records1->lastname = $lastname;
                    $records1->uniqueid = $uniqueuploadid;
                    $records1->examdate = $datetime;
                    $records1->profession = $professionname;
                    $records1->professionid = $professionid;
                    $records1->uploadedby = $_SESSION['uid'];

                    $examsdata1->store();
                    
                }
            }

            if ($error == 0) {
                Redirecting::location('examination/examexcel',$uniqueuploadid);

            } else {
                Redirecting::location('examination/examexcel', 'Please ensure all the column headings match the sample below', 'error');

            }

        }
    }

    // uploads for exams with provisional pins / index number for those who did not register with the system
    public static function examregexcel($filename, $uniqueuploadid, $professionid)
    {
        $error = 0;
        $professionname = profession::professionName($professionid);

        $data = array("data" => array());
        $datetime = date("Y-m-d H:i:s");

        $extension = explode('.', $filename);
        if ($extension[1] == 'xlsx') {
            $inputFileType = 'Excel2007';
        } else {
            $inputFileType = 'Excel5';
        }
        $filename =UPLOADPATH.'/'. trim($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($filename);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10

            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            for ($row = 1; $row <= $highestRow; ++$row) {

                for ($col = 0; $col < $highestColumnIndex; ++$col) {

                    if ($row == 1) {

                        $firstname =strtoupper(trim( Tools::neat($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue())));
                        $middlename =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue())));
                        $lastname =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue())));
                        $p =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue())));
                        $school =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue())));
                        $propin =strtoupper(trim( Tools::neat($worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue())));

                        
                        if ($firstname != 'FIRSTNAME') {
                            $error += 1;
                        }

                        if ($middlename != 'MIDDLENAME') {
                            $error += 1;
                        }

                        if ($lastname != 'SURNAME') {
                            $error += 1;}

                        if ($p != 'PROFESSION') {
                            $error += 1;
                        }
                        if ($school != 'SCHOOL') {
                            $error += 1;
                        } 
                        if ($propin != 'PROVISIONALPIN') {
                            $error += 1;
                        }

                        if ($error > 0) {
                            Redirecting::location('examination/examregexcel', 'Please ensure all the column headings match the sample below', 'error');
                            exit();
                        }
                        
                    } else {
                        $firstname =trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue());
                        $middlename =trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue());
                        $lastname =trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue());
                        $p =trim($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue());
                        $school =trim($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue());
                        $propin =trim($worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue());
                    }
                }

                // insertion code here
                if ($row != 1) {
                    if(examreg::countexsitingdata($propin)==0){
                    $examsdata = new examreg();
                    $records = &$examsdata->recordObject;
                    $records->firstname = $firstname;
                    $records->middlename = $middlename;
                    $records->lastname = $lastname;
                    $records->professionid = $professionid;
                    $records->profession = $professionname;
                    $records->school = $school;
                    $records->provisionalpin = $propin;
                    $records->uniqueid = $uniqueuploadid;
                    $records->examdate = $datetime;
                    $examsdata->store();
                    }
                }
            }

            if ($error == 0) {
                Redirecting::location('examination/examregexcel',$uniqueuploadid);

            } else {
                Redirecting::location('examination/examregexcel', 'Please ensure all the column headings match the sample below', 'error');

            }

        }
    }

    //uploads for resit of exams 
    public static function examresitexcel($filename, $uniqueuploadid, $professionid,$period)
    {
        $error = 0;
        $professionname = profession::professionName($professionid);

        $data = array("data" => array());
        $datetime = date("Y-m-d H:i:s");

        $extension = explode('.', $filename);
        if ($extension[1] == 'xlsx') {
            $inputFileType = 'Excel2007';
        } else {
            $inputFileType = 'Excel5';
        }
        $filename =UPLOADPATH.'/'. trim($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($filename);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10

            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            for ($row = 1; $row <= $highestRow; ++$row) {

                for ($col = 0; $col < $highestColumnIndex; ++$col) {

                    if ($row == 1) {

                        $firstname =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue())));
                        $middlename =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue())));
                        $lastname =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue())));
                        $p =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue())));
                        $school =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue())));
                        $indexnumber =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue())));

                        
                        if ($firstname != 'FIRSTNAME') {
                            $error += 1;
                        }

                        if ($middlename != 'MIDDLENAME') {
                            $error += 1;
                        }

                        if ($lastname != 'SURNAME') {
                            $error += 1;}

                        if ($p != 'PROFESSION') {
                            $error += 1;
                        }
                        if ($school != 'SCHOOL') {
                            $error += 1;
                        } 
                        if ($indexnumber != 'INDEXNUMBER') {
                            $error += 1;
                        }

                        if ($error > 0) {
                            Redirecting::location('examination/examresit', 'Please ensure all the column headings match the sample below', 'error');
                            exit();
                        }

                    } else {
                        $firstname =trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue());
                        $middlename =trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue());
                        $lastname =trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue());
                        $p =trim($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue());
                        $school =trim($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue());
                        $indexnumber =trim($worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue());
                    }
                }

                // insertion code here
                if ($row != 1) {
                    if(examresit::countexsitingdata($indexnumber)==0){
                    $examsdata = new examresit();
                    $records = &$examsdata->recordObject;
                    $records->firstname = $firstname;
                    $records->middlename = $middlename;
                    $records->lastname = $lastname;
                    $records->professionid = $professionid;
                    $records->profession = $professionname;
                    $records->school = $school;
                    $records->indexnumber = $indexnumber;
                    $records->uniqueid = $uniqueuploadid;
                    $records->examdate = $datetime;
                    $records->period = $period;
                    $examsdata->store();
                    }
                }
            }

            if ($error == 0) {
                Redirecting::location('examination/examresit',$uniqueuploadid);

            } else {
                Redirecting::location('examination/examresit', 'Please ensure all the column headings match the sample below', 'error');

            }

        }
    }


   //uploads for excel with index numbers for exams but i had to hold on for now
    public static function examregexcelindex($filename, $uniqueuploadid, $professionid)
    {
        $error = 0;
        $professionname = profession::professionName($professionid);

        $data = array("data" => array());
        $datetime = date("Y-m-d H:i:s");

        $extension = explode('.', $filename);
        if ($extension[1] == 'xlsx') {
            $inputFileType = 'Excel2007';
        } else {
            $inputFileType = 'Excel5';
        }
        $filename =UPLOADPATH.'/'. trim($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($filename);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10

            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            for ($row = 1; $row <= $highestRow; ++$row) {

                for ($col = 0; $col < $highestColumnIndex; ++$col) {

                    if ($row == 1) {

                        $indexnumber =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue())));
                        $program =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue())));
                        $year =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue())));
                        $email =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue())));
                        $telephone =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue())));
                        $firstname =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue())));
                        $middlename =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(6, $row)->getFormattedValue())));
                        $lastname =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(7, $row)->getFormattedValue())));
                        $p =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(8, $row)->getFormattedValue())));
                        $school =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(9, $row)->getFormattedValue())));
                        $propin =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(10, $row)->getFormattedValue())));

                        
                        if ($firstname != 'FIRSTNAME') {
                            $error += 1;
                        }

                        if ($middlename != 'MIDDLENAME') {
                            $error += 1;
                        }

                        if ($lastname != 'SURNAME') {
                            $error += 1;}

                        if ($p != 'PROFESSION') {
                            $error += 1;
                        }
                        if ($school != 'SCHOOL') {
                            $error += 1;
                        } 
                        if ($propin != 'PROVISIONALPIN') {
                            $error += 1;
                        }
                    } else {
                        $firstname =trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue());
                        $middlename =trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue());
                        $lastname =trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue());
                        $p =trim($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue());
                        $school =trim($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue());
                        $propin =trim($worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue());
                    }
                }

                // insertion code here
                if ($row != 1) {
                    if(examreg::countexsitingdata($propin)==0){
                    $examsdata = new examreg();
                    $records = &$examsdata->recordObject;
                    $records->firstname = $firstname;
                    $records->middlename = $middlename;
                    $records->lastname = $lastname;
                    $records->professionid = $professionid;
                    $records->profession = $professionname;
                    $records->school = $school;
                    $records->provisionalpin = $propin;
                    $records->uniqueid = $uniqueuploadid;
                    $records->examdate = $datetime;
                    $examsdata->store();
                    }
                }
            }

            if ($error == 0) {
                Redirecting::location('examination/examregexcel',$uniqueuploadid);

            } else {
                Redirecting::location('examination/examregexcel', 'Please ensure all the column headings match the sample below', 'error');

            }

        }
    }

    public static function renewalexcel($filename, $uniqueuploadid, $professionid)
    {
        $error = 0;
        $errorArray = array();
        $errordata = null;
        $professionname = profession::professionName($professionid);

        $data = array("data" => array());
        $datetime = date("Y-m-d H:i:s");

        $extension = explode('.', $filename);
        if ($extension[1] == 'xlsx') {
            $inputFileType = 'Excel2007';
        } else {
            $inputFileType = 'Excel5';
        }
        $filename =UPLOADPATH.'/'. trim($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($filename);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10

            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            for ($row = 1; $row <= $highestRow; ++$row) {

                for ($col = 0; $col < $highestColumnIndex; ++$col) {

                    if ($row == 1) {

                        $number =strtoupper(trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue()));
                        $fullname =strtoupper(trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue()));
                        $pin =strtoupper(trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue()));
                       
                   
                        if ($fullname != 'FULLNAME') {
                            $error += 1;
                        }

                        if ($pin != 'PIN') {
                            $error += 1;
                        }

                        if ($error > 0) {
                            Redirecting::location('pages/renewalupload', 'Please ensure all the column headings match the sample below', 'error');
                            exit();
                        }
                       
                    } else {
                        
                        $number =trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue());
                        $fullname =trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue());
                        $pin =trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue());
                    }
                }

                // insertion code here
                if ($row != 1) {
                    if(renewalupload::countexsitingdata($pin)==0){
                    $examsdata = new renewalupload();
                    $records = &$examsdata->recordObject;
                    $records->fullname = $fullname;
                    $records->cpdpin = $pin;
                    $records->professionid = $professionid;
                    $records->uniqueid = $uniqueuploadid;
                    $records->dateuploaded = $datetime;
                    $examsdata->store();
                    }else{

                        $errorArray[] = ['fullname'=>$fullname,'pin'=>$pin];

                        if (count($errorArray) > 0) {
                           $errordata = json_encode($errorArray);
                        }

                    }
                }
            }

            if ($error == 0) {
                Redirecting::datalocation('pages/renewalupload',$uniqueuploadid,$errordata);

            } else {
                Redirecting::location('pages/renewalupload', 'Please ensure all the column headings match the sample below', 'error');

            }

        }
    }

    public static function cpdexcel($filename, $uniqueuploadid,$category)
    {
        $error = 0;
      
        $errordata = null;

        $data = array("data" => array());
        $datetime = date("Y-m-d H:i:s");

        $extension = explode('.', $filename);
        if ($extension[1] == 'xlsx') {
            $inputFileType = 'Excel2007';
        } else {
            $inputFileType = 'Excel5';
        }
        $filename =UPLOADPATH.'/'. trim($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($filename);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10

            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            for ($row = 1; $row <= $highestRow; ++$row) {

                for ($col = 0; $col < $highestColumnIndex; ++$col) {

                    if ($row == 1) {

                        $number =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue())));
                        $event =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue())));
                        $categoryhead =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue())));
                        $points =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue())));
                       
                   
                        if ($event != 'EVENTTITLE') {
                            $error += 1;
                        }

                        if ($points != 'CPDPOINTS') {
                            $error += 1;
                        }

                        if ($categoryhead != 'CATEGORY') {
                            $error += 1;
                        }

                        if ($error > 0) {
                            Redirecting::location('education/cpdcredits', 'Please ensure all the column headings match the sample below', 'error');
                            exit();
                        }
                       
                       
                    } else {
                        
                        $number =trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue());
                        $event =trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue());
                        //$category =trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue());
                        $points =trim($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue());
                    }
                }

                // insertion code here
                if ($row != 1) {
                    
                    if(!cpdupload::checkexsiting($event,$category)){
                        $examsdata = new cpdupload();
                        $records = &$examsdata->recordObject;
                        $records->activity = $event;
                        $records->credit = $points;
                        $records->category = $category;
                        $records->uniqueid = $uniqueuploadid;
                        $records->dateuploaded = $datetime;
                        $records->uploadedby = $_SESSION['uid'];
                        $examsdata->store();
                    } else{
                        $examsdata = new cpduploaderror();
                        $records = &$examsdata->recordObject;
                        $records->activity = $event;
                        $records->credit = $points;
                        $records->category = $category;
                        $records->uniqueid = $uniqueuploadid;
                        $records->dateuploaded = $datetime;
                        $records->uploadedby = $_SESSION['uid'];
                        $examsdata->store();
                        $errordata = 1;
                    }

                    
                }
            }

            if ($error == 0) {
                Redirecting::datalocation('education/cpdcredits',$uniqueuploadid,$errordata);

            } else {
                Redirecting::location('education/cpdcredits', 'Please ensure all the column headings match the sample below', 'error');

            }

        }
    }



    public static function cpdexcelattendance($filename, $uniqueuploadid, $cid,$cpdyear)
    {
        $error = 0;
        $errorArray = array();
        $errordata = null;
        $p = new cpdupload($cid);
        $cpd = &$p->recordObject;

        $data = array("data" => array());
        $datetime = date("Y-m-d H:i:s");

        $extension = explode('.', $filename);
        if ($extension[1] == 'xlsx') {
            $inputFileType = 'Excel2007';
        } else {
            $inputFileType = 'Excel5';
        }
        $filename =UPLOADPATH.'/'. trim($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($filename);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10

            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            for ($row = 1; $row <= $highestRow; ++$row) {

                for ($col = 0; $col < $highestColumnIndex; ++$col) {

                    if ($row == 1) {

                        $number =strtoupper(trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue()));
                        $event =strtoupper(trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue()));
                        $firstname =strtoupper(trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue()));
                        $lastname =strtoupper(trim($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue()));
                        $pin =strtoupper(trim($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue()));
                        $email =strtoupper(trim($worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue()));
                        $profession =strtoupper(trim($worksheet->getCellByColumnAndRow(6, $row)->getFormattedValue()));
                       
                   
                        if ($event != 'EVENT TITLE') {
                            $error += 1;
                        }

                        if ($firstname != 'FIRSTNAME') {
                            $error += 1;
                        }

                        if ($lastname != 'LASTNAME') {  
                            $error += 1;
                        }
                        if ($email != 'EMAIL') {  
                            $error += 1;
                        }
                        if ($pin != 'PIN') {  
                            $error += 1;
                        }
                        if ($profession != 'PROFESSION CODE') {  
                            $error += 1;
                        }


                        if ($error > 0) {

                            $error=' <code> Please ensure all the column headings match the sample below </code> ';
                            $data = ['response'=>$error,'status'=>'error'];
                            echo json_encode($data);
                            exit();
                        }
                       
                       
                    } else {
                        
                       
                        $number =trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue());
                        $event =trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue());
                        $firstname =trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue());
                        $lastname =trim($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue());
                        $pin =trim($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue());
                        $email =trim($worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue());
                        $profession =trim($worksheet->getCellByColumnAndRow(6, $row)->getFormattedValue());
                    
                       
                    }
                }

                // insertion code here
                if ($row != 1) {
                    
                    if(cpdattendance::checkprofession($profession,$pin)){
                        
                    $examsdata = new cpdattendance();
                    $records = &$examsdata->recordObject;
                    $records->cpdid = $cid;
                    $records->cpdtitle = $cpd->activity;
                    $records->credit = $cpd->credit;
                    $records->uniqueid = $uniqueuploadid;
                    $records->dateuploaded = $datetime;
                    $records->uploadedby = $_SESSION['uid'];
                    $records->pin = $pin;
                    $records->firstname = $firstname;
                    $records->lastname = $lastname;
                    $records->email = $email;
                    $records->category = $cpd->category;
                    $records->cpdyear = $cpdyear;
                    $examsdata->store();

                    }else{
                        $errorArray[] = ['firstname'=>$firstname,'lastname'=>$lastname,'pin'=>$pin,'email'=>$email,'profession'=>$profession];

                        if (count($errorArray) > 0) {
                           $errordata = json_encode($errorArray);
                        }
                    }
                    
                }
            }

            if($errordata != null){
                $data = ['response'=>$errordata,'status'=>'errorTable'];
                echo json_encode($data);
                exit();
            }

            if ($error == 0) {

                $data = ['response'=>$uniqueuploadid,'status'=>'success'];
                echo json_encode($data);

                exit();

            } else {

                $error=' <code> Please ensure all the column headings match the sample below </code> ';
                $data = ['response'=>$error,'status'=>'error'];
                echo json_encode($data);
                exit();
            }

        }
    }


    public static function owingexcel($filename, $uniqueuploadid, $cpdyear)
    {
        $error = 0;

        $data = array("data" => array());
        $datetime = date("Y-m-d H:i:s");

        $extension = explode('.', $filename);
        if ($extension[1] == 'xlsx') {
            $inputFileType = 'Excel2007';
        } else {
            $inputFileType = 'Excel5';
        }
        $filename =UPLOADPATH.'/'. trim($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($filename);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10

            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            for ($row = 1; $row <= $highestRow; ++$row) {

                for ($col = 0; $col < $highestColumnIndex; ++$col) {

                    if ($row == 1) {

                        $number =strtoupper(trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue()));
                        $fullname =strtoupper(trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue()));
                        $pin =strtoupper(trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue()));
                        $profession =strtoupper(trim($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue()));
                        $category =strtoupper(trim($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue()));
                        $years =strtoupper(trim($worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue()));
                        $amount =strtoupper(trim($worksheet->getCellByColumnAndRow(6, $row)->getFormattedValue()));
                       
                   
                        if ($fullname != 'NAME') {
                            $error += 1;
                        }

                        if ($pin != 'PIN') {
                            $error += 1;
                        }

                        if ($profession != 'PROGRAMME') {
                            $error += 1;
                        }

                        if ($category != 'CATEGORY') {
                            $error += 1;
                        }
                      
                        if ($error > 0) {
                            Redirecting::location('accounts/uploadowing', 'Please ensure all the column headings match the sample below', 'error');
                            exit();
                        }
                       
                       
                    } else {
                        
                        $fullname =trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue());
                        $pin =trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue());
                        $profession =trim($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue());
                        $category =trim($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue());
                        $years =trim($worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue());
                        $amount = (double) trim($worksheet->getCellByColumnAndRow(6, $row)->getFormattedValue());

                    
                    }
                }

                // insertion code here
               
                if ($row != 1) {
                    if(Owing::countexsitingdata($pin)==0){
                    $savedata = new Owing();
                    $records = &$savedata->recordObject;
                    $records->name = $fullname;
                    $records->pin = $pin;
                    $records->profession = $profession;
                    $records->category = $category;
                    $records->amount = $amount;
                    $records->years = $years;
                    $records->cpdyear = $cpdyear;
                    $records->uniqueid = $uniqueuploadid;
                    $savedata->store();
                    }
                }
            }

            if ($error == 0) {
                Redirecting::location('accounts/uploadowing',$uniqueuploadid);

            } else {
                Redirecting::location('accounts/uploadowing', 'Please ensure all the column headings match the sample below', 'error');

            }

        
     }
    }


    public static function internshipexcel($filename, $uniqueuploadid)
    {
        $error = 0;
      
        $errordata = null;

        $data = array("data" => array());
        $datetime = date("Y-m-d H:i:s");

        $extension = explode('.', $filename);
        if ($extension[1] == 'xlsx') {
            $inputFileType = 'Excel2007';
        } else {
            $inputFileType = 'Excel5';
        }
        $filename =UPLOADPATH.'/'. trim($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($filename);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10

            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            for ($row = 1; $row <= $highestRow; ++$row) {

                for ($col = 0; $col < $highestColumnIndex; ++$col) {

                    if ($row == 1) {

                        $fullname =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue())));
                        $pin =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue())));
                        $placeofposting =strtoupper(trim(Tools::neat($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue())));
                       
                    
                   
                        if ($fullname != 'FULLNAME') {
                            $error += 1;
                        }

                        if ($pin != 'PIN') {
                            $error += 1;
                        }

                        if ($placeofposting != 'PLACEOFPOSTING') {
                            $error += 1;
                        }

                        if ($error > 0) {
                            Redirecting::location('education/internship', 'Please ensure all the column headings match the sample below', 'error');
                            exit();
                        }
                       
                       
                    } else {
                        
                        $fullname =trim($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue());
                        $pin =trim($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue());
                        $placeofposting =trim($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue());
                    }
                }

                // insertion code here
                if ($row != 1) {
                    
                    
                        $examsdata = new internship();
                        $records = &$examsdata->recordObject;
                        $records->fullname = $fullname;
                        $records->pin = $pin;
                        $records->placeofposting = $placeofposting;
                        $records->uniqueid = $uniqueuploadid;
                        $records->dateuploaded = $datetime;
                        $records->uploadedby = $_SESSION['uid'];
                        $examsdata->store();
                    

                    
                }
            }

            if ($error == 0) {
                Redirecting::datalocation('education/internship',$uniqueuploadid,$errordata);

            } else {
                Redirecting::location('education/internship', 'Please ensure all the column headings match the sample below', 'error');

            }

        }
    }
}

