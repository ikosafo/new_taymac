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
OR provisional_payment LIKE '%" . $searchValue . "%'
OR profession LIKE '%" . $searchValue . "%'
OR provisional_pin LIKE '%" . $searchValue . "%') ";
}

$year = $_GET['year'];
$status = $_GET['status'];
//$email_address = $_GET['email'];

if ($status == "All") {
## Total number of records without filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal r
                              JOIN provisional p ON r.applicant_id = p.applicant_id
                              WHERE r.cpdyear != '' AND r.cpdyear = '$year'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount
                          FROM renewal r
                          JOIN provisional p ON r.applicant_id = p.applicant_id
                          WHERE r.cpdyear != '' AND r.cpdyear = '$year' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "SELECT r.cpd_usercheck_status,r.cpd_admincheck_status,r.period_registered,p.*
                     FROM renewal r
                     JOIN provisional p ON r.applicant_id = p.applicant_id
                     WHERE r.cpdyear != '' AND r.cpdyear = '$year' AND 1 ".$searchQuery."
                     ORDER BY r.period_registered DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

}


else if ($status == "Approved") {

    ## Total number of records without filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal r
                              JOIN provisional p ON r.applicant_id = p.applicant_id
                              WHERE r.cpdyear != '' AND r.cpdyear = '$year' AND r.cpd_usercheck_status = 'Approved'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal r
                              JOIN provisional p ON r.applicant_id = p.applicant_id
                              WHERE r.cpdyear != '' AND r.cpdyear = '$year' AND r.cpd_usercheck_status = 'Approved'
                               AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "SELECT r.cpd_usercheck_status,r.cpd_admincheck_status,r.period_registered,p.*
                     FROM renewal r
                     JOIN provisional p ON r.applicant_id = p.applicant_id
                     WHERE r.cpdyear != '' AND r.cpdyear = '$year' AND r.cpd_usercheck_status = 'Approved' AND 1 ".$searchQuery."
                     ORDER BY r.period_registered DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

}

else if ($status == "Rejected") {

    ## Total number of records without filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal r
                              JOIN provisional p ON r.applicant_id = p.applicant_id
                              WHERE r.cpdyear != '' AND r.cpdyear = '$year' AND r.cpd_usercheck_status = 'Rejected'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal r
                              JOIN provisional p ON r.applicant_id = p.applicant_id
                              WHERE r.cpdyear != '' AND r.cpdyear = '$year' AND r.cpd_usercheck_status = 'Rejected'
                               AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "SELECT r.cpd_usercheck_status,r.cpd_admincheck_status,r.period_registered,p.*
                     FROM renewal r
                     JOIN provisional p ON r.applicant_id = p.applicant_id
                     WHERE r.cpdyear != '' AND r.cpdyear = '$year' AND r.cpd_usercheck_status = 'Rejected' AND 1 ".$searchQuery."
                     ORDER BY r.period_registered DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

}

else if ($status == "Pending") {

    ## Total number of records without filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal r
                              JOIN provisional p ON r.applicant_id = p.applicant_id
                              WHERE r.cpdyear != '' AND r.cpdyear = '$year' AND r.payment = '1'
                              AND (r.cpd_usercheck_status = '' OR r.cpd_usercheck_status IS NULL)");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"SELECT COUNT(*) as allcount FROM renewal r
                              JOIN provisional p ON r.applicant_id = p.applicant_id
                              WHERE r.cpdyear != '' AND r.cpdyear = '$year' AND r.payment = '1'
                              AND (r.cpd_usercheck_status = '' OR r.cpd_usercheck_status IS NULL)
                              AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "SELECT r.cpd_usercheck_status,r.cpd_admincheck_status,r.period_registered,p.*
                     FROM renewal r
                     JOIN provisional p ON r.applicant_id = p.applicant_id
                     WHERE r.cpdyear != '' AND r.cpdyear = '$year' AND r.payment = '1'
                     AND (r.cpd_usercheck_status = '' OR r.cpd_usercheck_status IS NULL)
                     AND 1 ".$searchQuery."
                     ORDER BY r.period_registered DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();


}



while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "provisionalid"=>getfulldetails($row['provisionalid']),
        "email_address"=>$row['email_address'],
        "renewal_pin"=>$row['provisional_pin'],
        "renewal_usercheck_status"=>cpdshowbtnuser($row['applicant_id'],$year),
        "renewal_admincheck_status"=>cpdshowbtnadmin($row['applicant_id'],$year),
        "renewal_period"=>cpdperiod($row['applicant_id'],$year),
        "applicant_id"=>cpdmisapproval($row['applicant_id'],$year)
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