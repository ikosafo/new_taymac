<?php

function lock($item)
{
    return base64_encode(base64_encode(base64_encode($item)));
}
function unlock($item)
{
    return base64_decode(base64_decode(base64_decode($item)));
}


// Date Period
function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $then = new DateTime($datetime);
    $diff = (array) $now->diff($then);

    $diff['w']  = floor($diff['d'] / 7);
    $diff['d'] -= $diff['w'] * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );

    foreach ($string as $k => &$v) {
        if ($diff[$k]) {
            $v = $diff[$k] . ' ' . $v . ($diff[$k] > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


/* function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
 */

function getsuperupgarde($prov_upgrade)
{
    if ($prov_upgrade == '1') {
        return "<span class='kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill'>Upgrade</span>";
    } else {
        return "";
    }
}


function getmisupgarde($prov_upgrade)
{
    if ($prov_upgrade == '1') {
        return "<span class='kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill'>Upgrade</span>";
    } else {
        return "";
    }
}


//Email verification
function email_verified($email_verified)
{
    if ($email_verified == '1') {
        return "<span style = 'color:green'>Verified</span>";
    } else {
        return "<span style = 'color:red'>Not Verified</span>";
    }
}



//Email verification period
function email_verified_period($email_verified_period)
{
    if ($email_verified_period == '') {
        return "N/A";
    } else {
        return time_elapsed_string($email_verified_period);
    }
}


//Get Applicant details
function getdetails($applicant_id)
{
    include('db.php');
    $q = mysqli_query($con, "select * from provisional where applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    $title = $result['title'];
    if ($title == "Other") {
        $title = $result['othertitle'];
        return $result["surname"] . " " . $result["first_name"] . " " . $result["other_name"] . "(" . $title . ")";
    } else {
        return $result["surname"] . " " . $result["first_name"] . " " . $result["other_name"] . "(" . $title . ")";
    }
}


//Get Email Address
function getemail($applicant_id)
{
    include('db.php');
    $q = mysqli_query($con, "select * from provisional where applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    return $email_address = $result['email_address'];
}

//Get Full name in excel
function getnamepinexcel($pinid)
{
    include('db.php');
    $q = mysqli_query($con, "select * from exc_pin_data where pinid = '$pinid'");
    $result = mysqli_fetch_assoc($q);
    $surname = $result['surname'];
    $othernames = $result['other_names'];

    if ($surname == "") {
        return $othernames;
    } else {
        return $surname . ' ' . $othernames;
    }
}


//Get PIN in database
function getdbpin($emailaddress)
{
    include('db.php');
    $q = mysqli_query($con, "select * from exc_pin_data e JOIN provisional p ON p.email_address = e.emailaddress
                            where e.emailaddress = '$emailaddress'");
    $result = mysqli_fetch_assoc($q);
    return $result['provisional_pin'];
}


//PIN in Excel and DB Status
function getpinstatusexcel($emailaddress)
{
    include('db.php');
    $q = mysqli_query($con, "select * from exc_pin_data e JOIN provisional p ON p.email_address = e.emailaddress
                            where e.emailaddress = '$emailaddress'");
    $result = mysqli_fetch_assoc($q);
    $dbpin =  $result['provisional_pin'];
    $excelpin =  $result['pin'];

    if ($dbpin == $excelpin) {
        return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill"><i class="fa fa-check"></i> </span>';
    } else {
        return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill"><i class="fa fa-times"></i></span>';
    }
}


//Get PIN
function getpin($applicant_id)
{
    include('db.php');
    $q = mysqli_query($con, "select * from provisional where applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    $provisional_pin = $result['provisional_pin'];
    if ($provisional_pin == "") {
        $provisional_pin = $applicant_id;
    }
    return $provisional_pin;
}



//Get Exam Details
function examdetails($exam_id)
{
    include('db.php');

    $q = mysqli_query($con, "select * from examination_reg where examination_id = '$exam_id'");
    $result = mysqli_fetch_assoc($q);
    $internship_period = $result['internship_period'];
    $facility = $result['facility'];
    $previous_exam = $result['previous_exam'];
    $exam_attempts = $result['exam_attempts'];
    $exam_center = $result['exam_center'];
    return '<span class="kt-widget31__info">Internship Period: </span>
          <span class="kt-widget31__text" style="font-weight:300;font-size:0.8rem">' . $internship_period . '</span><br/>
   <span class="kt-widget31__info">Facility: </span>
          <span class="kt-widget31__text" style="font-weight:300;font-size:0.8rem">' . $facility . '</span><br/>
   <span class="kt-widget31__info">Previous Exam: </span>
          <span class="kt-widget31__text" style="font-weight:300;font-size:0.8rem">' . $previous_exam . '</span><br/>
    <span class="kt-widget31__info">Exam Attempts: </span>
          <span class="kt-widget31__text" style="font-weight:300;font-size:0.8rem">' . $exam_attempts . '</span><br/>
    <span class="kt-widget31__info">Exam Center: </span>
          <span class="kt-widget31__text" style="font-weight:300;font-size:0.8rem">' . $exam_center . '</span><br/>';
}



//Get Applicant details
function getfulldetails($provisionalid)
{
    include('db.php');
    $reg_root = 'https://registration.ahpcgh.org';
    $q = mysqli_query($con, "select * from provisional where provisionalid = '$provisionalid'");
    $result = mysqli_fetch_assoc($q);
    $applicant_id = $result['applicant_id'];
    $img = mysqli_query($con, "select * from applicant_images where applicant_id = '$applicant_id'");
    $resultimg = mysqli_fetch_assoc($img);
    $imgloc = $reg_root . '/' . $resultimg['image_location'];
    $profession = $result['profession'];

    $title = $result['title'];
    if ($title == "Other") {
        $title = $result['othertitle'];
        $fullname = $result["surname"] . " " . $result["first_name"] . " " . $result["other_name"] . "(" . $title . ")";
    } else {
        $fullname = $result["surname"] . " " . $result["first_name"] . " " . $result["other_name"] . "(" . $title . ")";
    }

    return '<div class="kt-widget31">
                     <div class="kt-widget31__item">
						<div class="kt-widget31__content" style="width: 100% !important;">
							<div class="kt-widget31__pic kt-widget4__pic--pic">
								<!--<img src="' . $imgloc . '" alt="Img"> -->
							</div>
							<div class="kt-widget31__info" style="padding: 0 0.8rem;width:100% !important">
								<a href="#" class="kt-widget31__username" style="font-weight:300;font-size:1.0rem">
									' . $fullname . '
								</a>
								<p class="kt-widget31__text" style="font-weight:300;font-size:0.8rem">
									' . $profession . '
								</p>
							</div>
						</div>
                      </div>
					</div>';
}



function getappfulldetails($applicant_id)
{
    include('db.php');
    $reg_root = 'https://registration.ahpcgh.org';

    $q = mysqli_query($con, "select * from provisional where applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);

    $img = mysqli_query($con, "select * from applicant_images where applicant_id = '$applicant_id'");
    $resultimg = mysqli_fetch_assoc($img);
    $imgloc = $reg_root . '/' . $resultimg['image_location'];
    $profession = $result['profession'];

    $title = $result['title'];
    if ($title == "Other") {
        $title = $result['othertitle'];
        $fullname = $result["surname"] . " " . $result["first_name"] . " " . $result["other_name"] . "(" . $title . ")";
    } else {
        $fullname = $result["surname"] . " " . $result["first_name"] . " " . $result["other_name"] . "(" . $title . ")";
    }

    return '<div class="kt-widget31">
                     <div class="kt-widget31__item">
						<div class="kt-widget31__content" style="width: 100% !important;">
							<div class="kt-widget31__pic kt-widget4__pic--pic">
								<!--<img src="' . $imgloc . '" alt="Img"> -->
							</div>
							<div class="kt-widget31__info" style="padding: 0 0.8rem;width:100% !important">
								<a href="#" class="kt-widget31__username" style="font-weight:300;font-size:1.0rem">
									' . $fullname . '
								</a>
								<p class="kt-widget31__text" style="font-weight:300;font-size:0.8rem">
									' . $profession . '
								</p>
							</div>
						</div>
                      </div>
					</div>';
}


function getappemail($applicant_id)
{
    include('db.php');
    $q = mysqli_query($con, "select * from provisional where applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    return $result['email_address'];
}


function getappindex($applicant_id)
{
    include('db.php');
    $q = mysqli_query($con, "select * from provisional where applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    return $result['exam_index_number'];
}


function getapppin($applicant_id)
{
    include('db.php');
    $q = mysqli_query($con, "select * from provisional where applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    return $result['provisional_pin'];
}


//Get Exam Payment Status
function getexampayment($examination_id)
{
    include('db.php');
    $q = mysqli_query($con, "select * from examination_reg where examination_id = '$examination_id'");
    $result = mysqli_fetch_assoc($q);
    $payment = $result['payment'];

    if ($payment == '1') {
        return '<span style="color:green">Paid</span>';
    } else {
        return '<span style="color: red">Not Paid</span>';
    }
}



//Examination Status Buttons
function getexamremark($remarks)
{

    if (strtolower($remarks) == "pass") {
        return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Passed</span>';
    } else if (strtolower($remarks) == "fail") {
        return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Failed</span>';
    }
}


//CPD Period Regsitered

function cpdperiod($applicant_id, $year)
{
    include('db.php');
    $q = mysqli_query($con, "select * from renewal WHERE cpdyear = '$year' 
    AND applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    $period_registered =  $result['period_registered'];
    return $period_registered . '<br/>' . time_elapsed_string($period_registered);
}


//Approval State Buttons (CPD MIS)
function cpdshowbtnuser($applicant_id, $year)
{
    include('db.php');
    $q = mysqli_query($con, "select * from renewal WHERE cpdyear = '$year' AND applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    $cpd_usercheck_status =  $result['cpd_usercheck_status'];
    $payment =  $result['payment'];

    if ($payment == "1") {
        if ($cpd_usercheck_status == "Approved") {
            return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
        } else if ($cpd_usercheck_status == "Rejected") {
            return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
        } else if ($cpd_usercheck_status == "Resubmitted") {
            return '<span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Resubmitted</span>';
        } else {
            return '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
        }
    } else {
        return '<span style="color: red">Not Paid</span>';
    }
}


//Approval State Buttons (CPD ADMIN)
function cpdshowbtnadmin($applicant_id, $year)
{
    include('db.php');
    $q = mysqli_query($con, "select * from renewal WHERE cpdyear = '$year' AND applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    $cpd_usercheck_status =  $result['cpd_usercheck_status'];
    $cpd_admincheck_status =  $result['cpd_admincheck_status'];

    if ($cpd_usercheck_status == "Approved" && $cpd_admincheck_status == "") {
        return '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
    } else if ($cpd_admincheck_status == "Rejected") {
        return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
    } else if ($cpd_admincheck_status == "Resubmitted") {
        return '<span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Resubmitted</span>';
    } else if ($cpd_admincheck_status == "Approved") {

        return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
    }
}


//Approval State Buttons (Permanent MIS Admin)
function pershowbtnuser($applicant_id)
{
    include('db.php');
    $q = mysqli_query($con, "select * from provisional where applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    $permanent_usercheck_status =  $result['permanent_usercheck_status'];
    $permanent_payment =  $result['permanent_payment'];

    if ($permanent_payment == "1") {
        if ($permanent_usercheck_status == "Approved") {
            return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
        } else if ($permanent_usercheck_status == "Rejected") {
            return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
        } else {
            return '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
        }
    } else {
        return '<span style="color: red">Not Paid</span>';
    }
}



//Approval State Buttons (Permanent Upgrade MIS Admin)
function perupshowbtnuser($id)
{
    include('db.php');
    $q = mysqli_query($con, "select * from registration_upgrades where id = '$id'");
    $result = mysqli_fetch_assoc($q);
    $usercheck_status =  $result['usercheck_status'];
    $payment =  $result['payment'];

    if ($payment == "1") {
        if ($usercheck_status == "Approved") {
            return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
        } else if ($usercheck_status == "Rejected") {
            return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
        } else {
            return '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
        }
    } else {
        return '<span style="color: red">Not Paid</span>';
    }
}



//Approval State Buttons (Temporal MIS Admin)
function temshowbtnuser($applicant_id)
{
    include('db.php');
    $q = mysqli_query($con, "select * from provisional where applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    $temporal_usercheck_status =  $result['temporal_usercheck_status'];
    $temporal_payment =  $result['temporal_payment'];

    if ($temporal_payment == "1") {
        if ($temporal_usercheck_status == "Approved") {
            return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
        } else if ($temporal_usercheck_status == "Rejected") {
            return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
        } else if ($temporal_usercheck_status == "Resubmitted") {
            return '<span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Resubmitted</span>';
        } else {
            return '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
        }
    } else {
        return '<span style="color: red">Not Paid</span>';
    }
}


//Approval State Buttons (Provisional MIS Admin)
function proshowbtnuser($applicant_id)
{
    include('db.php');

    $q = mysqli_query($con, "select * from provisional where applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    $provisional_usercheck_status =  $result['provisional_usercheck_status'];
    $provisional_payment =  $result['provisional_payment'];

    if ($provisional_payment == "1") {
        if ($provisional_usercheck_status == "Approved") {
            return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
        } else if ($provisional_usercheck_status == "Rejected") {
            return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
        } else {
            return '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
        }
    } else {
        return '<span style="color: red">Not Paid</span>';
    }
}



//Approval State Buttons (Exam Officer)
function exshowbtnuser($examination_id)
{
    include('db.php');

    $q = mysqli_query($con, "select * from examination_reg where examination_id = '$examination_id'");
    $result = mysqli_fetch_assoc($q);
    $exam_usercheck_status =  $result['exam_usercheck_status'];
    $exam_payment =  $result['payment'];

    if ($exam_payment == "1") {
        if ($exam_usercheck_status == "Approved") {
            return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
        } else if ($exam_usercheck_status == "Rejected") {
            return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
        } else {
            return '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
        }
    } else {
        return '<span style="color: red">Not Paid</span>';
    }
}



//PIN Update Status
function pinupdatestatus($pin_updated)
{

    if ($pin_updated == "1") {
        return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill"><i class="fa fa-check"></i> </span>';
    } else {
        return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill"><i class="fa fa-times"></i></span>';
    }
}


//PIN Update Status
function indexupdatestatus($index_updated)
{

    if ($index_updated == "1") {
        return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill"><i class="fa fa-check"></i> </span>';
    } else {
        return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill"><i class="fa fa-times"></i></span>';
    }
}


//PIN Update Status
function resendmailstatus($resend_mail)
{

    if ($resend_mail == "1") {
        return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill"><i class="fa fa-check"></i> </span>';
    } else {
        return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill"><i class="fa fa-times"></i></span>';
    }
}


//Approval State Buttons (Permanent Super Admin)
function pershowbtnadmin($applicant_id)
{
    include('db.php');

    $q = mysqli_query($con, "select * from provisional where applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    $permanent_usercheck_status =  $result['permanent_usercheck_status'];
    $permanent_admincheck_status =  $result['permanent_admincheck_status'];


    if ($permanent_usercheck_status == "Approved" && $permanent_admincheck_status == "") {
        return '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
    } else if ($permanent_admincheck_status == "Rejected") {
        return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
    } else if ($permanent_admincheck_status == "Approved") {

        return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
    }
}



//Approval State Buttons (Permanent Upgrade Super Admin)
function perupshowbtnadmin($id)
{
    include('db.php');

    $q = mysqli_query($con, "select * from registration_upgrades where id = '$id'");
    $result = mysqli_fetch_assoc($q);
    $usercheck_status =  $result['usercheck_status'];
    $admincheck_status =  $result['admincheck_status'];


    if ($usercheck_status == "Approved" && $admincheck_status == "") {
        return '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
    } else if ($admincheck_status == "Rejected") {
        return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
    } else if ($admincheck_status == "Approved") {

        return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
    }
}



//Approval State Buttons (Temporal Super Admin)
function temshowbtnadmin($applicant_id)
{
    include('db.php');

    $q = mysqli_query($con, "select * from provisional where applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    $temporal_usercheck_status =  $result['temporal_usercheck_status'];
    $temporal_admincheck_status =  $result['temporal_admincheck_status'];


    if ($temporal_usercheck_status == "Approved" && $temporal_admincheck_status == "") {
        return '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
    } else if ($temporal_admincheck_status == "Rejected") {
        return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
    } else if ($temporal_admincheck_status == "Resubmitted") {
        return '<span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Resubmitted</span>';
    } else if ($temporal_admincheck_status == "Approved") {
        return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
    }
}



//Approval State Buttons (Provisional Super Admin)
function proshowbtnadmin($applicant_id)
{
    include('db.php');

    $q = mysqli_query($con, "select * from provisional where applicant_id = '$applicant_id'");
    $result = mysqli_fetch_assoc($q);
    $provisional_usercheck_status =  $result['provisional_usercheck_status'];
    $provisional_admincheck_status =  $result['provisional_admincheck_status'];


    if ($provisional_usercheck_status == "Approved" && $provisional_admincheck_status == "") {
        return '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
    } else if ($provisional_admincheck_status == "Rejected") {
        return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
    } else if ($provisional_admincheck_status == "Approved") {

        return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
    }
}



//Approval State Buttons (Exam Super Admin)
function exshowbtnadmin($examination_id)
{
    include('db.php');
    $q = mysqli_query($con, "select * from examination_reg where examination_id = '$examination_id'");
    $result = mysqli_fetch_assoc($q);
    $exam_usercheck_status =  $result['exam_usercheck_status'];
    $exam_admincheck_status =  $result['exam_admincheck_status'];

    if ($exam_usercheck_status == "Approved" && $exam_admincheck_status == "") {
        return '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
    } else if ($exam_admincheck_status == "Rejected") {
        return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
    } else if ($exam_admincheck_status == "Approved") {

        return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
    }
}


//Exam Code Exception Btn
function getexamexception($examination_id)
{
    return '<button class="btn btn btn-label-facebook getexception_btn"
                    i_index=' . $examination_id . '>
                        Create Exception
    </button>';
}


//Exam Approval Btn
function examapproval($examination_id)
{
    return '<button class="btn btn btn-label-facebook examapprove_btn"
                    i_index=' . $examination_id . '>
                        View and Approve
    </button>';
}


//Exam Approval Btn
function getbilldetails($pin)
{
    return '<button class="btn btn btn-label-facebook editbill_btn"
                    i_index=' . $pin . '>
                        Edit
    </button>';
}


//Exam Delete Btn
function delete_exam($examination_id)
{
    return '<button class="btn btn btn-label-facebook deleteexam_btn"
                    i_index=' . $examination_id . '>
                        Delete Examination
    </button>';
}


//Exam Delete Btn
function delacc($id)
{
    return '<button class="btn btn btn-label-facebook deleteacc_btn"
                    i_index=' . $id . '>
                        Delete Account
    </button>';
}


//Permanent Delete Btn
function delperm($id)
{
    return '<button class="btn btn btn-label-facebook deleteperm_btn"
                    i_index=' . $id . '>
                        Delete Permanent Reg. Details
    </button>';
}


//Permanent Delete Btn
function delprov($id)
{
    return '<button class="btn btn btn-label-facebook deleteprov_btn"
                    i_index=' . $id . '>
                        Delete Provisional Reg. Details
    </button>';
}



//Exam Approval Btn
function regenerateindex($examination_id)
{
    return '<button class="btn btn btn-label-facebook regenerateindex_btn"
                    i_index=' . $examination_id . '>
                        Regenerate Index Number
    </button>';
}


//PIN Update Btn
function pin_update($applicant_id)
{
    return '<button class="btn btn btn-label-facebook pinupdate_btn"
                    i_index=' . $applicant_id . '>
                       Update PIN
    </button>';
}


//PIN Entry Btn
function pin_entry($applicant_id)
{
    return '<button class="btn btn btn-label-facebook pinentry_btn"
                    i_index=' . $applicant_id . '>
                       Update PIN
    </button>';
}


//PIN Update Btn
function index_update($applicant_id)
{
    return '<button class="btn btn btn-label-facebook indexupdate_btn"
                    i_index=' . $applicant_id . '>
                       Regenerate Index Number
    </button>';
}


//PIN Regenerate Btn
function pin_regenerate($applicant_id)
{
    return '<button class="btn btn btn-label-facebook pinregenerate_btn"
                    i_index=' . $applicant_id . '>
                       Regenerate PIN
    </button>';
}


//DB PIN Update Btn
function updatedbpin($emailaddress, $pin)
{
    return '<button class="btn btn btn-label-facebook dbpinupdate_btn"
                    i_index=' . $emailaddress . '
                    p_index=' . $pin . '
                    >
                       Update PIN
    </button>';
}


//Merge Emails
function email_merge($applicant_id)
{
    return '<button class="btn btn btn-label-facebook mergeemail_btn"
                    i_index=' . $applicant_id . '>
                       Merge Email
    </button>';
}


//PIN Update Btn
function resend_email($applicant_id)
{
    return '<button class="btn btn btn-label-facebook resendmail_btn"
                    i_index=' . $applicant_id . '>
                      Resend Mail
    </button>';
}


//PIN Update Btn
function resend_emailindex($applicant_id)
{
    return '<button class="btn btn btn-label-facebook resendmailindex_btn"
                    i_index=' . $applicant_id . '>
                      Resend Mail
    </button>';
}



//Delete applicant details
function itdel($applicant_id)
{
    return '<button class="btn btn btn-label-facebook deleteapp_btn"
                    i_index=' . $applicant_id . '>
                       Delete
    </button>';
}



//CPD MIS Approval Btn
function cpdmisapproval($applicant_id, $year)
{
    $space = " ";
    // Test if applicant id contains the space 
    if (strpos($applicant_id, $space) !== false) {
        $newappid = str_replace(" ", "%", $applicant_id);
    } else {
        $newappid = $applicant_id;
    }
    return "<button class='btn btn btn-label-facebook cpdmisapprove_btn'
    i_index=" . $newappid . " i_year =" . $year . ">
                        View and Approve
    </button>";
}



//Permanent MIS Upgrade Approval Btn
function misupapproval($id)
{
    return '<button class="btn btn btn-label-facebook misupapprove_btn"
                    i_index=' . $id . '>
                        View and Approve
    </button>';
}


//Provisional MIS Upgrade Approval Btn
function misupapprovalpro($id)
{
    return '<button class="btn btn btn-label-facebook misupapprovepro_btn"
                    i_index=' . $id . '>
                        View and Approve
    </button>';
}



//Permanent Super UpgradeApproval Btn
function superupapproval($id)
{
    return '<button class="btn btn btn-label-facebook superupapprove_btn"
                    i_index=' . $id . '>
                        View and Approve
    </button>';
}


//Provisional Super Upgrade Approval Btn
function superupapprovalpro($id)
{
    return '<button class="btn btn btn-label-facebook superupapprovepro_btn"
                    i_index=' . $id . '>
                        View and Approve
    </button>';
}



//CPD Super Admin Approval Btn
function cpdsuperapproval($applicant_id, $year)
{
    $space = " ";
    // Test if applicant id contains the space 
    if (strpos($applicant_id, $space) !== false) {
        $newappid = str_replace(" ", "%", $applicant_id);
    } else {
        $newappid = $applicant_id;
    }
    return '<button class="btn btn btn-label-facebook cpdsuperapprove_btn"
                    i_index=' . $newappid . ' i_year =' . $year . '>
                        View and Approve
    </button>';
}


//CPD Edit Year Btn
function edityear($applicant_id, $year)
{
    return '<button class="btn btn btn-label-facebook edityear_btn"
                    i_index=' . $applicant_id . ' i_year =' . $year . '>
                        Edit Year
    </button>';
}


function editdetails($examination_id)
{
    return '<button class="btn btn btn-label-facebook editexamdetails_btn"
                    i_index=' . $examination_id . '>
                        View and Update
    </button>';
}


//MIS Approval Btn
function misapproval($applicant_id)
{
    $newappid = str_replace(' ', '_', $applicant_id);
    return "<button class='btn btn btn-label-facebook misapprove_btn'
                    i_index=" . $newappid . ">
                        View and Approve
    </button>";
}


//Super Approval Btn
function superapproval($applicant_id)
{
    $newappid = str_replace(' ', '_', $applicant_id);
    return '<button class="btn btn btn-label-facebook superapprove_btn"
                    i_index=' . $newappid . '>
                        View and Approve
    </button>';
}



// Reply Message
function replymessage($id)
{
    return '<button class="btn btn-success btn-outline btn-sm reply_message"
                    i_index=' . $id . '>
                        Click to reply
    </button>';
}


//Get Payment Status
function getpayment($payment)
{
    if ($payment == '1') {
        return '<span style="color:green">Paid</span>';
    } else {
        return '<span style="color: red">Not Paid</span>';
    }
}


//Get Payment Status
function getpmtstatus($payment)
{
    if ($payment == '1') {
        return '<span style="color:green">Paid</span>';
    } else {
        return '<span style="color: red">Not Paid</span>';
    }
}


//Get Payment Status
function getregstatus($status)
{
    if ($status == '1') {
        return '<span style="color:green">Registered</span>';
    } else {
        return '<span style="color: red">Not Registered</span>';
    }
}


//Provisional Link Details
function linkdetails($applicant_id)
{
    $newid = lock(lock($applicant_id));
    return  '<a href="provisional_details.php?app_id=' . $newid . '" target="_blank">
    <button class="btn btn-success btn-outline btn-sm" style="font-size: small">
        View details
    </button>
</a>';
}


//Permanent Link Details
function perlinkdetails($applicant_id)
{
    $newid = lock(lock($applicant_id));
    return  '<a href="permanent_details.php?app_id=' . $newid . '" target="_blank">
    <button class="btn btn-success btn-outline btn-sm" style="font-size: small">
        View details
    </button>
</a>';
}



//Provisional Link Details
function prolinkdetails($applicant_id)
{
    $newid = lock(lock($applicant_id));
    return  '<a href="provisional_details.php?app_id=' . $newid . '" target="_blank">
    <button class="btn btn-success btn-outline btn-sm" style="font-size: small">
        View details
    </button>
</a>';
}



//Provisional Link Details
function provisionalapprovaldetails($applicant_id)
{
    return '<button class="btn btn-success btn-outline btn-sm approvalbtn"
                            applicantid = ' . $applicant_id . '>
                       Approve
                    </button>';
}


//CPD Link Details
function cpdlinkdetails($applicant_id, $year)
{
    $newid = lock(lock($applicant_id));
    return  '<a href="renewal_details.php?app_id=' . $newid . '&year=' . $year . '" target="_blank">
    <button class="btn btn-success btn-outline btn-sm" style="font-size: small">
        View details
    </button>
</a>';
}



//CPD Approve Details
function cpdgetapproval($applicant_id)
{
    return '<button class="btn btn-success btn-outline btn-sm approvalbtn"
                            applicantid = ' . $applicant_id . '>
                       Approve
                    </button>';
}


//Delete Special Case
function deletelink($id)
{
    return ' <button type="button"
                                data-type="confirm"
                                class="btn btn-danger js-sweetalert delete_applicant"
                                i_index=' . $id . '
                                title="Delete">
                            <i class="flaticon2-trash ml-2" style="color:#fff !important;"></i>
                        </button>';
}


//Delete Intern
function deleteintern($id)
{
    return ' <button type="button"
                                data-type="confirm"
                                class="btn btn-danger js-sweetalert delete_intern"
                                i_index=' . $id . '
                                title="Delete">
                            <i class="flaticon2-trash ml-2" style="color:#fff !important;"></i>
                        </button>';
}


//Get Profession
function getprofession($id)
{
    include('db.php');

    $q = mysqli_query($con, "select * from professions where professionid = '$id'");
    $result = mysqli_fetch_assoc($q);
    return $result['professionname'];
}



//Get MIS User
function getuser($userid)
{
    include('db.php');

    $q = mysqli_query($con, "select * from mis_users where user_id = '$userid'");
    $result = mysqli_fetch_assoc($q);
    return $result['full_name'];
}


//Get PIN Update Status
function getpinstatus($newpin)
{
    include('db.php');

    $q = mysqli_query($con, "select * from provisional where provisional_pin = '$newpin'");
    $result = mysqli_fetch_assoc($q);

    if (mysqli_num_rows($q) == '1') {
        return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Successful</span>';
    } else {
        return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Failed</span>';
    }
}


//Get Mail Status
function getmailstatus($pin)
{
    include('db.php');

    $q = mysqli_query($con, "select * from provisional where provisional_pin = '$pin' and resend_mail = '1'");
    $result = mysqli_fetch_assoc($q);

    if (mysqli_num_rows($q) == '1') {
        return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Successful</span>';
    } else {
        return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Failed</span>';
    }
}
