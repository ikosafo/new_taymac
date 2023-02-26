<?php

include('../../includes/db.php');
include('../../includes/phpfunctions.php');

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
if ($searchValue != '') {
    $searchQuery = " and 
(fullname LIKE '%" . $searchValue . "%'
OR pin LIKE '%" . $searchValue . "%' 
OR placeofposting LIKE '%" . $searchValue . "%' ) ";
}

//$email_address = $_GET['email'];

## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as allcount from internshiplist");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($con, "select count(*) as allcount from internshiplist WHERE 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from internshiplist WHERE 1 " . $searchQuery . " order by internid DESC limit " . $row . "," . $rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();


while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "fullname" => $row['fullname'],
        "pin" => $row['pin'],
        "placeofposting" => $row['placeofposting'],
        "internid" => deleteintern($row['internid'])
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
