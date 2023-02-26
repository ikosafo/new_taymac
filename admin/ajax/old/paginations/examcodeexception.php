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
indexnumber LIKE '%" . $searchValue . "%'
OR facility LIKE '%" . $searchValue . "%' ";
}

//$year = $_GET['year'];
//$email_address = $_GET['email'];


## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from examination_reg where createpemex IS NULL");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from examination_reg WHERE createpemex IS NULL AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "select * from examination_reg WHERE createpemex IS NULL AND 1 ".$searchQuery."
    order by period_registered DESC, exam_attempts DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();



while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "full_name"=>getappfulldetails($row['applicant_id']),
        "email_address"=>getemail($row['applicant_id']),
        "attempts"=>$row['exam_attempts'],
        "facility"=>$row['facility'],
        "center"=>$row['exam_center'],
        "payment"=>getexampayment($row['examination_id']),
        "indexnumber"=>$row['indexnumber'],
        "action"=>getexamexception($row['examination_id'])
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