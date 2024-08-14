<?php

class Tools extends tableDataObject{

   public static  function limit_text($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
      }

      public static function Pagination($per_page,$page,$sql){

        global $payrolldb;
        //TODO new way to accomodate the frameworks url parsing. the above method is the old way 
        
        $output = explode('&',$_SERVER['QUERY_STRING']);
        unset($output[0]);
        $newstring = implode('&',$output);

        if ($newstring==""){
            $page_url="?";
        }elseif(isset($_GET['page']) && sizeof($output)==1){
            $page_url="?";
        }else{
            $page_url="?".str_replace("&page=".$page,"",$newstring).'&';
        }
         $payrolldb->prepare($sql);
         $payrolldb->execute();
         $result=$payrolldb->rowCount();
         $total = $result;
         $adjacents = "2"; 
    
         $page = ($page == 0 ? 1 : $page);  
         $start = ($page - 1) * $per_page;								
         
         $prev = $page - 1;							
         $next = $page + 1;
         $setLastpage = ceil($total/$per_page);
         $lpm1 = $setLastpage - 1;
         
         $setPaginate = "";
         if($setLastpage > 1)
         {	
             $setPaginate .= "<ul class='setPagninate blog-pagination ptb-20'>";
                     $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";
             if ($setLastpage < 7 + ($adjacents * 2))
             {	
                 for ($counter = 1; $counter <= $setLastpage; $counter++)
                 {
                     if ($counter == $page)
                         $setPaginate.= "<li class='active'><a class='current-page active'>$counter</a></li>";
                     else
                         $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
                 }
             }
             elseif($setLastpage > 5 + ($adjacents * 2))
             {
                 if($page < 1 + ($adjacents * 2))		
                 {
                     for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                     {
                         if ($counter == $page)
                             $setPaginate.= "<li class='active'><a class='current-page active'>$counter</a></li>";
                         else
                             $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
                     }
                     $setPaginate.= "<li class='blank'>...</li>";
                     $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
                     $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";		
                 }
                 elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                 {
                     $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
                     $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
                     $setPaginate.= "<li class='blank'>...</li>";
                     for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                     {
                         if ($counter == $page)
                             $setPaginate.= "<li class='active'><a class='current-page active'>$counter</a></li>";
                         else
                             $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
                     }
                     $setPaginate.= "<li class='blank'>..</li>";
                     $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
                     $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";		
                 }
                 else
                 {
                     $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
                     $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
                     $setPaginate.= "<li class='blank'>..</li>";
                     for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++)
                     {
                         if ($counter == $page)
                             $setPaginate.= "<li class='active'><a class='current-page active'>$counter</a></li>";
                         else
                             $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
                     }
                 }
             }
             
             if ($page < $counter - 1){ 
                 $setPaginate.= "<li><a href='{$page_url}page=$next'>Next</a></li>";
                 $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";
             }else{
                 $setPaginate.= "<li class='active'><a class='current-page active'>Next</a></li>";
                 $setPaginate.= "<li class='active'><a class='current-page active'>Last</a></li>";
             }
    
             $setPaginate.= "</ul>\n";		
         }
     
     
         return $setPaginate;
     } 

     public static function lock($item){
        return base64_encode(base64_encode(base64_encode($item)));

     }

     public static function unlock($item){
        return base64_decode(base64_decode(base64_decode($item)));

     }

     public static function clean ($string){
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     }

    public static function neat($str) {
        $str = str_replace(' ', '', $str); // Replaces all spaces with hyphens.
        // Remove all characters that are not letters, numbers, or spaces
        $cleanedStr = preg_replace('/[^A-Za-z0-9\s]/', '', $str);
        return $cleanedStr;
    }
    
     public static function timeago($datetime){
        $then = new DateTime($datetime);
        $now = new DateTime();
        $delta = $now->diff($then);
        
        $quantities = array(
            'year' => $delta->y,
            'month' => $delta->m,
            'day' => $delta->d
           );
        
        $str = '';
        foreach($quantities as $unit => $value) {
            if($value == 0) continue;
            $str .= $value . ' ' . $unit;
            if($value != 1) {
                $str .= 's';
            }
            $str .=  ', ';
        }
        $str = $str == '' ? 'a moment ' : substr($str, 0, -2);
        
        echo $str."  ago";
     }

     
     public static function datediff($startdate,$enddate){
       
        $start = new DateTime($startdate);
        $end = new DateTime($enddate);
        // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);

        // total days
        $days = $interval->days;

        // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);

        // best stored as array, so you can add more than one
        $holidays =  Holiday::holidays();
       
        foreach($period as $dt) {
            $curr = $dt->format('D');

            // substract if Saturday or Sunday
            if ($curr == 'Sat' || $curr == 'Sun') {
                $days--;
            }

            // (optional) for the updated question
            elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                $days--;
            }
        }


        return $days;
     }

     public static function plusOneDay($date){
       
        $date1 = str_replace('-', '/', $date);
        $tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
        
        return $tomorrow;
     }

     public static function checkPassword($password){
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        $message = '';
    
        //return multiple conditions message
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            if(!$uppercase){
                $message .= "Password should contain at least one upper case letter. <br>";
            }
            if(!$lowercase){
                $message .= "Password should contain at least one lower case letter. <br>";
            }
            if(!$number){
                $message .= "Password should contain at least one number. <br>";
            }
            if(!$specialChars){
                $message .= "Password should contain at least one special character. <br>";
            }
            if(strlen($password) < 8){
                $message .= "Password should be at least 8 characters in length. <br>";
            }

            return $message;
        }else{
            return '';
        }
   
       
     }

  /*   public static function getIpDetails()
    {
        $ip_address = ''; // Initialize IP address variable
    
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP']; // IP from share internet
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR']; // IP pass from proxy
        } else {
            $ip_address = $_SERVER['REMOTE_ADDR']; // Remote IP address
        }
    
        // Query ipinfo.io to get IP address details (city, country, location)
        $details_json = file_get_contents("https://ipinfo.io/{$ip_address}/json");
        $details = json_decode($details_json);
    
        // Return IP details as an array
        return [
            'ip_address' => $ip_address,
            'city' => isset($details->city) ? $details->city : '',
            'country' => isset($details->country) ? $details->country : '',
            'location' => isset($details->loc) ? $details->loc : ''
        ];
    } */

    public static function logAction($message, $action)
    {
        //IP Details 
        //$ip_details = self::getIpDetails();

        // Create an instance of the Mac class to get the MAC address
        $mac = new Mac();
        $mac_address = $mac->getMacAddress();

        // Get current date and time
        $today = date("Y-m-d H:i:s");
    
        if (@$_SESSION['username'] == "") {
            @$username = $_POST['username'];
        } else {
            $username = $_SESSION['username'];
        }    
    
        // Prepare IP details for logging
        //$ip_info = "IP: {$ip_details['ip_address']}, City: {$ip_details['city']}, Country: {$ip_details['country']}, Location: {$ip_details['location']}";
    
        $l = new logs();
        $logs = &$l->recordObject;
        $logs->message = $message;
        $logs->logdate = date('Y-m-d H:i:s');
        $logs->username = $username;
        $logs->mac_address = $mac_address;
       /*  $logs->ip_address = $ip_details['ip_address'];
        $logs->ip_details = $ip_info; */
        $logs->action = $action;
        $l->store();
    }

    public static function emailVerified($email_verified)
    {
        if ($email_verified == '1') {
            return "<span style = 'color:green'>Verified</span>";
        } else {
            return "<span style = 'color:red'>Not Verified</span>";
        }
    }

    public static function appStatus($email) {
        global $healthdb;

        $getnum = "SELECT COUNT(*) as count FROM provisional where email_address = '$email'";
        $healthdb->prepare($getnum);
        $result = $healthdb->singleRecord();
        if ($result->count > 0) {
            return '<span class="label label-lg font-weight-bold label-light-success label-inline">Applicant</span>';
        } else {
            return '<span class="label label-lg font-weight-bold label-light-danger label-inline">Pre-Registrant</span>';
        };
    }

    public static function pinSuspendStatus($applicantId) {
        global $healthdb;

        $getnum = "SELECT COUNT(*) as count FROM pin_suspended where applicant_id = '$applicantId' and `date_to` > curdate()";
        $healthdb->prepare($getnum);
        $result = $healthdb->singleRecord();
        if ($result->count > 0) {
            return '<span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>';
        } else {
            return '<span class="label label-lg font-weight-bold label-light-danger label-inline">Expired</span>';
        };
    }

    public static function permanentMISStatus($provisionalid) {
        global $healthdb;

        $getnum = "SELECT permanent_usercheck_status,permanent_payment FROM `provisional` where `provisionalid` = '$provisionalid'";
        $healthdb->prepare($getnum);
        $result = $healthdb->singleRecord();
        if (!$result) {
            return "";
        }
        else {
            $userStatus = $result->permanent_usercheck_status;
            if ($userStatus == "Approved") {
                return '<span class="label label-sm font-weight-bold label-light-success label-inline">Approved</span>';
            }
            else if ($userStatus == "Rejected") {
                return '<span class="label label-sm font-weight-bold label-light-danger label-inline">Rejected</span>';
            }
            else if ($userStatus == "" && $result->permanent_payment == 1) {
                return '<span class="label label-sm font-weight-bold label-light-primary label-inline">Pending</span>';
            } 
            else if ($result->permanent_payment == 0){
                return '<span class="text-danger text-small">Not Paid</span>';
            }
        }
    }

    public static function permanentSuperStatus($provisionalid) {
        global $healthdb;

        $getnum = "SELECT permanent_usercheck_status,permanent_admincheck_status,permanent_payment FROM `provisional` where `provisionalid` = '$provisionalid'";
        $healthdb->prepare($getnum);
        $result = $healthdb->singleRecord();
        if (!$result) {
            return "";
        }
        else {
            $userStatus = $result->permanent_usercheck_status;
            $adminStatus = $result->permanent_admincheck_status;
            if ($adminStatus == "Approved") {
                return '<span class="label label-sm font-weight-bold label-light-success label-inline">Approved</span>';
            }
            else if ($adminStatus == "Rejected") {
                return '<span class="label label-sm font-weight-bold label-light-danger label-inline">Rejected</span>';
            }
            else if ($adminStatus == "" && $userStatus == "Approved") {
                return '<span class="label label-sm font-weight-bold label-light-primary label-inline">Pending</span>';
            } 
            else if ($result->permanent_payment == 0){
                return '<span class="text-danger text-small">Not Paid</span>';
            }
        }
    }

    public static function registrationCriteria($applicant_id) {   
        $firstCharacter = strtolower(substr($applicant_id, 0, 1)); 
        if ($firstCharacter === 'p') {
            return 'Special Code generation';
        } else {
            return 'Examination<br/><small style="color:red">Kindly verify score obtained</small>';
        }
    } 

    public static function paymentStatus($payment) {
        if ($payment == 1) {
            return '<span class="label label-inline label-light-success font-weight-bold">Paid</span>';
        }
        else {
            return '<span class="label label-inline label-light-danger font-weight-bold">Not Paid</span>';
        }
    }

    public static function getProfession($professionid) {
        global $healthdb;
   
        $getname = "SELECT professionname FROM professions where professionid = '$professionid'";
        $healthdb->prepare($getname);
        $result = $healthdb->singleRecord();
        if (!$result) {
            return "";
        }
        else {
            return $result->professionname;
        }
    }

    public static function getApplicantId($id) {
        global $healthdb;
   
        $getapplicantId = "SELECT applicant_id FROM `provisional` where provisionalid = '$id'";
        $healthdb->prepare($getapplicantId);
        $result = $healthdb->fetchColumn();
        if (!$result) {
            return "";
        }
        else {
            return $result;
        }
    }


    public static function professionLevelMatch($level,$profession) {
        global $healthdb;

        $getMatch = "SELECT `professionname`,`grade_level` FROM `professions` 
            where `grade_level` = '$level' AND `professionname` = '$profession'";

        $healthdb->prepare($getMatch);
        $result = $healthdb->singleRecord();
        if (!$result) {
            return false;
        }
        else {
            return true;
        }
    }

    
    public static function getEmail($id) {
        global $healthdb;
   
        $getEmail = "SELECT email_address FROM `provisional` where provisionalid = '$id'";
        $healthdb->prepare($getEmail);
        $result = $healthdb->fetchColumn();
        if (!$result) {
            return "";
        }
        else {
            return $result->email_address;
        }
    }

    
    public static function getPassMark() {
        global $healthdb;

        $getConfig = "SELECT passmark FROM `examconfig` LIMIT 1";
        $healthdb->prepare($getConfig);
        $resResult = $healthdb->fetchColumn();
        return $resResult;
    }


    public static function getIndexNumber($applicant_id) {
        global $healthdb;

        $getIndex = "SELECT exam_index_number FROM `provisional` WHERE applicant_id = '$applicant_id'";
        $healthdb->prepare($getIndex);
        $resIndex = $healthdb->fetchColumn();
        return $resIndex;
    }


    public static function getPIN($applicant_id) {
        global $healthdb;

        $getPin = "SELECT provisional_pin FROM `provisional` WHERE applicant_id = '$applicant_id'";
        $healthdb->prepare($getPin);
        $resPin = $healthdb->fetchColumn();
        return $resPin;
    }


    public static function updateProfession($regType,$applicant_id) {
        global $healthdb;

        $getProf = "SELECT * FROM `app_professions` WHERE registration = '$regType' 
                    AND applicant_id = '$applicant_id'";
        $healthdb->prepare($getProf);
        $resProf = $healthdb->singleRecord();
        $profession =  $resProf->profession;
        $professionid = $resProf->professionid;
        $level = $resProf->level;

        $query = "UPDATE `app_professions` SET `approval_status` = 'Approved'
        WHERE `applicant_id` = '$applicant_id' AND `registration` = '$regType'";
        $healthdb->prepare($query);
        $healthdb->execute();

        $query = "UPDATE `provisional`
        SET 
        `profession` = '$profession',
        `professionid` = '$professionid',
        `acad_level` = '$level'
        WHERE `applicant_id` = '$applicant_id'";
        $healthdb->prepare($query);
        $healthdb->execute();

    }


    public static function updatePIN($applicant_id,$pin) {
        global $healthdb;

        $query = "UPDATE `provisional`
        SET `provisional_pin` = '$pin' WHERE `applicant_id` = '$applicant_id'";
        $healthdb->prepare($query);
        $healthdb->execute();

    }


    public static function generatePin($provisionalid, $regType) {
        global $healthdb;

        $getPin = "SELECT * FROM `provisional` WHERE provisionalid = '$provisionalid'";
        $healthdb->prepare($getPin);
        $resPin = $healthdb->singleRecord();
        $pinNumber = $resPin->provisional_pin;
        $index_number = $resPin->exam_index_number;
        $periodregistered = $resPin->{strtolower($regType) . '_period'};
        $professionid = @$resPin->professsionid;

        $yeargen = substr($periodregistered, 2, 2);
        $code = sprintf("%02d", $professionid);

    do {

        $fgen = sprintf("%02d", mt_rand(0, 99));
        $sgen = sprintf("%02d", mt_rand(0, 99));
        $pgen = $fgen . $code . $sgen . $yeargen;

        $checkQuery = "
            SELECT COUNT(*) as count 
            FROM `provisional`
            WHERE provisional_pin = '$pgen' 
            OR exam_index_number = '$pgen' 
            OR applicant_id = '$pgen'
        ";
        $healthdb->prepare($checkQuery);
        $resCheck = $healthdb->singleRecord();
        } while ($resCheck->count > 0);

        if ($pinNumber == "" && $index_number != "") {
            return $index_number;
        } else if ($pinNumber != "" && $index_number != "") {
            return $pinNumber;
        } 
        else if ($pinNumber != "" && $index_number == "") {
            return $pinNumber;
        }
        else {
            return $pgen;
        }
    }


    public static function getMISUserid($id) {
        global $healthdb;

        $getuserid = "SELECT user_id FROM mis_users where id = '$id'";
        $healthdb->prepare($getuserid);
        $result = $healthdb->singleRecord();
        if (!$result) {
            return "";
        }
        else {
            return $result->user_id;
        }
    }
    

    public static function misUser($userid) {
        global $healthdb;

        $getname = "SELECT full_name FROM mis_users where user_id = '$userid'";
        $healthdb->prepare($getname);
        $result = $healthdb->singleRecord();
        if (!$result) {
            return "";
        }
        else {
            return $result->full_name;
        }
    }

    public static function appDetails($applicantId) {
        global $healthdb;

        $getname = "SELECT first_name,other_name,surname FROM provisional where applicant_id = '$applicantId'";
        $healthdb->prepare($getname);
        $result = $healthdb->singleRecord();
        if (!$result) {
            return "";
        }
        else {
            return $result->first_name .' '.$result->other_name. ' ' .$result->surname;
        }
        
    }


    public static function getNameById($provisionalid) {
        global $healthdb;

        $getname = "SELECT first_name,other_name,surname FROM provisional where provisionalid = '$provisionalid'";
        $healthdb->prepare($getname);
        $result = $healthdb->singleRecord();
        if (!$result) {
            return "";
        }
        else {
            return $result->first_name .' '.$result->other_name. ' ' .$result->surname;
        }
        
    }


    public static function getNames($applicantId) {
        global $healthdb;

        $getMatch = "SELECT `first_name`,`other_name`,`surname` FROM `provisional` where `applicant_id` = '$applicantId'";
        $healthdb->prepare($getMatch);
        $result = $healthdb->singleRecord();
        if (!$result) {
            return "";
        }
        else {
            return [
                'firstName' => $result->first_name,
                'otherName' => $result->other_name,
                'surname' => $result->surname
            ];
        }
    }

    
    public static function getIndexNumberFromExamEception($id) {
        global $healthdb;

        $getindex = "SELECT indexnum FROM `exam_exception` where excid = '$id'";
        $healthdb->prepare($getindex);
        $result = $healthdb->singleRecord();
        if (!$result) {
            return "";
        }
        else {
            return $result->indexnum;
        }
    }


    public static function permanentButton($provisionalid) {
        return '<a href="#" class="btn btn-sm btn-facebook font-weight-lighter mr-2 text-small btn-smaller approveBtn" i_index=' . Tools::lock($provisionalid) . '>View and Approve</a>';
    }

    public static function exceptionButton($id) {
        return '<a href="#" class="btn btn-sm btn-facebook font-weight-lighter mr-2 text-small btn-smaller deleteBtn" i_index=' . Tools::lock($id) . '>Delete</a>';
    }
    

    public static function timeElapsed($datetime, $full = false) {
        $then = new DateTime($datetime);
        $now = new DateTime();
        $delta = $now->diff($then);
    
        if ($delta->y > 0) {
            $str = $delta->y . ' year' . ($delta->y > 1 ? 's' : '');
        } elseif ($delta->m > 0) {
            $str = $delta->m . ' month' . ($delta->m > 1 ? 's' : '');
        } elseif ($delta->d >= 7 && !$full) {
            $weeks = floor($delta->d / 7);
            $str = $weeks . ' week' . ($weeks > 1 ? 's' : '');
        } elseif ($delta->d > 0) {
            $str = $delta->d . ' day' . ($delta->d > 1 ? 's' : '');
        } elseif ($delta->h > 0) {
            $str = $delta->h . ' hour' . ($delta->h > 1 ? 's' : '');
        } elseif ($delta->i > 0) {
            $str = $delta->i . ' minute' . ($delta->i > 1 ? 's' : '');
        } else {
            $str = 'a moment';
        }
    
        return $str . ' ago';
    }
    
 
}

