<?php

include ('../../includes/db.php');
include ('../../includes/phpfunctions.php');

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
//$searchValue = $_POST['search']['value']; // Search value

$year = $_GET['year'];
$status = $_GET['status'];
//$email_address = $_GET['email'];

if ($status == "All") {
## Total number of records without filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal WHERE cpdyear = '$year'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal WHERE cpdyear = '$year'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "SELECT *  FROM renewal WHERE cpdyear = '$year' ORDER BY period_registered DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

}


else if ($status == "Approved") {

    ## Total number of records without filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal WHERE cpdyear = '$year' AND cpd_admincheck_status = 'Approved'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal WHERE cpdyear = '$year' AND cpd_admincheck_status = 'Approved'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "SELECT * FROM renewal WHERE cpdyear = '$year' AND cpd_admincheck_status = 'Approved'
                     ORDER BY period_registered DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

}

else if ($status == "Resubmitted") {

    ## Total number of records without filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal WHERE cpdyear = '$year' AND 
    cpd_admincheck_status = 'Resubmitted'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal WHERE cpdyear = '$year' AND cpd_admincheck_status = 'Resubmitted'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "SELECT * FROM renewal WHERE cpdyear = '$year' AND cpd_admincheck_status = 'Resubmitted'
                     ORDER BY period_registered DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

}

else if ($status == "Rejected") {

    ## Total number of records without filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal WHERE cpdyear = '$year' AND cpd_admincheck_status = 'Rejected'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal WHERE cpdyear = '$year' AND cpd_admincheck_status = 'Rejected'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "SELECT * FROM renewal WHERE cpdyear = '$year' AND cpd_admincheck_status = 'Rejected'
                     ORDER BY period_registered DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

}

else if ($status == "Pending") {

    ## Total number of records without filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal
                              WHERE cpdyear = '$year'
                              AND cpd_usercheck_status = 'Approved'
                              AND (cpd_admincheck_status = '' OR cpd_admincheck_status IS NULL)");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal WHERE cpdyear = '$year'
                              AND cpd_usercheck_status = 'Approved'
                              AND (cpd_admincheck_status = '' OR cpd_admincheck_status IS NULL)");
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "SELECT * FROM renewal WHERE cpdyear = '$year'
                     AND cpd_usercheck_status = 'Approved'
                     AND (cpd_admincheck_status = '' OR cpd_admincheck_status IS NULL)
                     ORDER BY period_registered DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

}



while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "provisionalid"=>getappfulldetails($row['applicant_id']),
        "email_address"=>getemail($row['applicant_id']),
        "renewal_pin"=>getpin($row['applicant_id']),
        "renewal_usercheck_status"=>cpdshowbtnuser($row['applicant_id'],$year),
        "renewal_admincheck_status"=>cpdshowbtnadmin($row['applicant_id'],$year),
        "renewal_period"=>cpdperiod($row['applicant_id'],$year),
        "applicant_id"=>cpdsuperapproval($row['applicant_id'],$year)
    );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecordwithFilter,
    "iTotalDisplayRecords" => $totalRecords,
    "aaData" => $data
);

echo json_encode($response);