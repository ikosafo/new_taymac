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
OR exam_index_number LIKE '%" . $searchValue . "%'
OR provisional_pin LIKE '%" . $searchValue . "%') ";
}

$year = $_GET['year'];
/*$status = $_GET['status'];
$type = $_GET['type'];*/
//$email_address = $_GET['email'];

if ($year == "All") {
    ## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from examination_reg e JOIN provisional p ON e.applicant_id = p.applicant_id
                              where e.payment = '0'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from examination_reg e JOIN provisional p ON e.applicant_id = p.applicant_id
                              where e.payment = '0' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "select * from examination_reg e JOIN provisional p ON e.applicant_id = p.applicant_id
                              where e.payment = '0' AND 1 ".$searchQuery." order by
                         e.period_registered DESC,e.payment DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
}

else {

## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from examination_reg e JOIN provisional p ON e.applicant_id = p.applicant_id
                              where e.payment = '0' AND SUBSTRING(e.period_registered,1,4) = '$year'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from examination_reg e JOIN provisional p ON e.applicant_id = p.applicant_id
                              where e.payment = '0' AND SUBSTRING(e.period_registered,1,4) = '$year'
                    AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "select * from examination_reg e JOIN provisional p ON e.applicant_id = p.applicant_id
                              where e.payment = '0' AND SUBSTRING(e.period_registered,1,4) = '$year' AND 1 ".$searchQuery."
            order by e.period_registered DESC,e.payment DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
}

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "provisionalid"=>getappfulldetails($row['applicant_id']),
        "email_address"=>getappemail($row['applicant_id']),
        "provisional_pin"=>getapppin($row['applicant_id']),
        "examination_usercheck_status"=>exshowbtnuser($row['examination_id']),
        "examination_admincheck_status"=>exshowbtnadmin($row['examination_id']),
        "index_number"=>getappindex($row['applicant_id']),
        //"examination_payment"=>getexampayment($row['examination_id']),
        /* "examination_details"=>examdetails($row['examination_id']),*/
        "examination_period"=>$row['period_registered'].'<br/> ('.time_elapsed_string($row['period_registered']).')',
        "examination_id"=>delete_exam($row['examination_id'])
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