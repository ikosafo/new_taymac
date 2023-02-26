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
(CONCAT(a.first_name, ' ',a.surname) LIKE '%" . $searchValue . "%'
OR CONCAT(a.first_name, ' ',a.surname, ' ',a.other_name) LIKE '%" . $searchValue . "%'
OR CONCAT(a.surname, ' ',a.first_name, ' ',a.other_name) LIKE '%" . $searchValue . "%'
OR CONCAT(a.first_name, ' ',a.other_name, ' ',a.surname) LIKE '%" . $searchValue . "%'
OR CONCAT(a.surname, ' ',a.other_name, ' ',a.first_name) LIKE '%" . $searchValue . "%'
OR CONCAT(a.other_name, ' ',a.first_name, ' ',a.surname) LIKE '%" . $searchValue . "%'
OR CONCAT(a.other_name, ' ',a.surname, ' ',a.first_name) LIKE '%" . $searchValue . "%'
OR a.surname LIKE '%" . $searchValue . "%'
OR a.first_name LIKE '%" . $searchValue . "%'
OR a.other_name LIKE '%" . $searchValue . "%'
OR a.email_address LIKE '%" . $searchValue . "%'
OR a.permanent_payment LIKE '%" . $searchValue . "%'
OR a.profession LIKE '%" . $searchValue . "%'
OR a.res_region LIKE '%" . $searchValue . "%'
OR a.email_address LIKE '%" . $searchValue . "%') ";
}


## Total number of records without filtering
$sel = mysqli_query($con,"SELECT count(*) as allcount FROM provisional a
JOIN (SELECT email_address, COUNT(*)
FROM provisional
GROUP BY email_address
HAVING COUNT(*) > 1 ) b
ON a.email_address = b.email_address");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];


## Total number of record with filtering
$sel = mysqli_query($con,"SELECT count(*) as allcount FROM provisional a
JOIN (SELECT email_address, COUNT(*)
FROM provisional
GROUP BY email_address
HAVING COUNT(*) > 1 ) b
ON a.email_address = b.email_address WHERE a.email_address != ''
AND 1".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];


## Fetch records
$empQuery = "SELECT a.*
FROM provisional a
JOIN (SELECT email_address, COUNT(*)
FROM provisional
GROUP BY email_address
HAVING COUNT(*) > 1 ) b
ON a.email_address = b.email_address AND
1 ".$searchQuery." order by a.email_address limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();


while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "provisionalid"=>getfulldetails($row['provisionalid']),
        "email_address"=>$row['email_address'],
        "telephone"=>$row['telephone'],
        "provisional_pin"=>$row['provisional_pin'],
        "app_id"=>$row['applicant_id'],
        "registration_mode"=>$row['registration_mode'],
        "applicant_id"=>email_merge($row['applicant_id'])
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