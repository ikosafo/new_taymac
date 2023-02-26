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
    $searchQuery = "and 
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
OR profession LIKE '%" . $searchValue . "%' 
OR message LIKE '%" . $searchValue . "%'
OR subject LIKE '%" . $searchValue . "%'
OR reply LIKE '%" . $searchValue . "%' ) ";
}





$year = $_GET['year'];
//$email_address = $_GET['email'];

if ($year == "All") {
    ## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from messages m join provisional p
                                                on m.applicant_id = p.applicant_id");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from messages m join provisional p
                                                on m.applicant_id = p.applicant_id WHERE 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records

    $empQuery = "select * from messages m
                           join provisional p
                           on m.applicant_id = p.applicant_id
                           WHERE 1 ".$searchQuery." order by period DESC
                           limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
}

else {

## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from messages m join provisional p
                                                on m.applicant_id = p.applicant_id where SUBSTRING(period,1,4) = '$year'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from messages m join provisional p
                                                on m.applicant_id = p.applicant_id WHERE SUBSTRING(period,1,4) = '$year'
                                                AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "select * from messages m
                           join provisional p
                           on m.applicant_id = p.applicant_id
                           WHERE SUBSTRING(period,1,4) = '$year' AND 1 ".$searchQuery."
                            order by m.period DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
}



while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(

        "applicant_id"=>getdetails($row['applicant_id']),
        "subject"=>$row['subject'],
        "message"=>$row['message'],
        "reply"=>$row['reply'],
        "period"=>$row['period'].'<br/> ('.time_elapsed_string($row['period']).')',
        "id"=>replymessage($row['id'])

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