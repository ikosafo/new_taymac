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
$searchValue = $_POST['search']['value']; // Search value

## Search
$searchQuery = " ";
if($searchValue != ''){
    $searchQuery = " and
(CONCAT(first_name, ' ',surname) LIKE '%" . $searchValue . "%'
OR CONCAT(first_name, ' ',surname, ' ',other_name) LIKE '%" . $searchValue . "%'
OR CONCAT(surname, ' ',first_name, ' ',other_name) LIKE '%" . $searchValue . "%'
OR CONCAT(first_name, ' ',other_name, ' ',surname) LIKE '%" . $searchValue . "%'
OR CONCAT(surname, ' ',other_name, ' ',first_name) LIKE '%" . $searchValue . "%'
OR CONCAT(other_name, ' ',first_name, ' ',surname) LIKE '%" . $searchValue . "%'
OR CONCAT(other_name, ' ',surname, ' ',first_name) LIKE '%" . $searchValue . "%'
OR surname LIKE '%" . $searchValue . "%'
OR first_name LIKE '%" . $searchValue . "%'
OR other_name LIKE '%" . $searchValue . "%'
OR email_address LIKE '%" . $searchValue . "%'
OR temporal_payment LIKE '%" . $searchValue . "%'
OR profession LIKE '%" . $searchValue . "%'
OR provisional_pin LIKE '%" . $searchValue . "%') ";
}

$year = $_GET['year'];
$status = $_GET['status'];
//$email_address = $_GET['email'];

if ($status == "All") {

    if ($year == "All") {
        ## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional where temporal_registration = '1'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional WHERE temporal_registration = '1'
                                   AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from provisional WHERE temporal_registration = '1' AND 1 ".$searchQuery." order by
                               temporal_period DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }

    else {

## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional where SUBSTRING(temporal_period,1,4) = '$year'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional WHERE SUBSTRING(temporal_period,1,4) = '$year' AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from provisional WHERE SUBSTRING(temporal_period,1,4) = '$year' AND 1 ".$searchQuery." order by temporal_period DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }


}


else if ($status == "Approved") {

    if ($year == "All") {
        ## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional where temporal_registration = '1' AND temporal_usercheck_status = 'Approved'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional WHERE temporal_registration = '1' AND temporal_usercheck_status = 'Approved'
                                   AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from provisional WHERE temporal_registration = '1' AND temporal_usercheck_status = 'Approved'  AND 1 ".$searchQuery." order by
                               temporal_period DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }

    else {

## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional where SUBSTRING(temporal_period,1,4) = '$year' AND temporal_usercheck_status = 'Approved'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional WHERE SUBSTRING(temporal_period,1,4) = '$year' AND temporal_usercheck_status = 'Approved' AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from provisional WHERE SUBSTRING(temporal_period,1,4) = '$year' AND temporal_usercheck_status = 'Approved' AND 1 ".$searchQuery." order by temporal_period DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }


}


else if ($status == "Resubmitted") {

    if ($year == "All") {
        ## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional where temporal_registration = '1' AND
                                       temporal_usercheck_status = 'Resubmitted'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional WHERE temporal_registration = '1' AND
                                          temporal_usercheck_status = 'Resubmitted'
                                   AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from provisional WHERE temporal_registration = '1' AND
                                    temporal_usercheck_status = 'Resubmitted'  AND 1 ".$searchQuery." order by
                               temporal_period DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }

    else {

## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional where SUBSTRING(temporal_period,1,4) = '$year' AND
                                    temporal_usercheck_status = 'Resubmitted'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional WHERE SUBSTRING(temporal_period,1,4) = '$year' AND
                                     temporal_usercheck_status = 'Resubmitted' AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from provisional WHERE SUBSTRING(temporal_period,1,4) = '$year' AND
                                       temporal_usercheck_status = 'Resubmitted' AND 1 ".$searchQuery."
                                      order by temporal_period DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }


}


else if ($status == "Rejected") {

    if ($year == "All") {
        ## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional where temporal_registration = '1' AND temporal_usercheck_status = 'Rejected'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional WHERE temporal_registration = '1' AND temporal_usercheck_status = 'Rejected'
                                   AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from provisional WHERE temporal_registration = '1' AND temporal_usercheck_status = 'Rejected'  AND 1 ".$searchQuery." order by
                               temporal_period DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }

    else {

## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional where SUBSTRING(temporal_period,1,4) = '$year' AND temporal_usercheck_status = 'Rejected'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional WHERE SUBSTRING(temporal_period,1,4) = '$year' AND temporal_usercheck_status = 'Rejected' AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from provisional WHERE SUBSTRING(temporal_period,1,4) = '$year' AND temporal_usercheck_status = 'Rejected' AND 1 ".$searchQuery." order by temporal_period DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }


}


else if ($status == "Pending") {

    if ($year == "All") {
        ## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional where temporal_registration = '1' AND temporal_payment = '1' AND (temporal_usercheck_status = '' OR temporal_usercheck_status IS NULL)");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional WHERE temporal_registration = '1' AND temporal_payment = '1' AND (temporal_usercheck_status = '' OR temporal_usercheck_status IS NULL)
                                   AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from provisional WHERE temporal_registration = '1' AND temporal_payment = '1' AND (temporal_usercheck_status = '' OR temporal_usercheck_status IS NULL)  AND 1 ".$searchQuery." order by
                               temporal_period DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }

    else {

## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional where SUBSTRING(temporal_period,1,4) = '$year' AND temporal_payment = '1' AND (temporal_usercheck_status = '' OR temporal_usercheck_status IS NULL)");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from provisional WHERE SUBSTRING(temporal_period,1,4) = '$year' AND temporal_payment = '1' AND (temporal_usercheck_status = '' OR temporal_usercheck_status IS NULL) AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from provisional WHERE SUBSTRING(temporal_period,1,4) = '$year' AND temporal_payment = '1' AND (temporal_usercheck_status = '' OR temporal_usercheck_status IS NULL) AND 1 ".$searchQuery." order by temporal_period DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }

}



while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "provisionalid"=>getfulldetails($row['provisionalid']),
        "email_address"=>$row['email_address'],
        "provisional_pin"=>$row['provisional_pin'],
        "temporal_usercheck_status"=>temshowbtnuser($row['applicant_id']),
        "temporal_admincheck_status"=>temshowbtnadmin($row['applicant_id']),
        "temporal_payment"=>getpayment($row['temporal_payment']),
        "temporal_period"=>$row['temporal_period'].'<br/> ('.time_elapsed_string($row['temporal_period']).')',
        "applicant_id"=>misapproval($row['applicant_id'])
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