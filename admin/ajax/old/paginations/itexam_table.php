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
(  indexnumber LIKE '%" . $searchValue . "%'
OR facility LIKE '%" . $searchValue . "%'
OR period_registered LIKE '%" . $searchValue . "%') ";
}


$year = $_GET['year'];
$center = $_GET['center'];
$attempts = $_GET['attempts'];
//$email_address = $_GET['email'];

if ($year == "All") {
    ## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from examination_reg
                              where exam_center = '$center'
                              AND exam_attempts = '$attempts'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from examination_reg
                              where exam_center = '$center'
                              AND exam_attempts = '$attempts' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "select * from examination_reg
                          where exam_center = '$center'
                          AND exam_attempts = '$attempts' AND 1 ".$searchQuery."
                          order by period_registered DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
}
else {
    ## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from examination_reg
                          where SUBSTRING(period_registered,1,4) = '$year' AND exam_center = '$center'
                          AND exam_attempts = '$attempts'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from examination_reg where
                          SUBSTRING(period_registered,1,4) = '$year' AND exam_center = '$center'
                          AND exam_attempts = '$attempts' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "select * from examination_reg where
                          SUBSTRING(period_registered,1,4) = '$year' AND exam_center = '$center'
                          AND exam_attempts = '$attempts' AND 1 ".$searchQuery."
                          order by period_registered DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
}



while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "applicant_id"=>getappfulldetails($row['applicant_id']),
        "email_address"=>getemail($row['applicant_id']),
        "internship_period"=>$row['internship_period'],
        "facility"=>$row['facility'],
        "previous_exam"=>$row['previous_exam'],
        "payment"=>getpayment($row['payment']),
        "period_registered"=>$row['period_registered'].'<br/> ('.time_elapsed_string($row['period_registered']).')',
        "examination_id"=>editdetails($row['examination_id'])
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