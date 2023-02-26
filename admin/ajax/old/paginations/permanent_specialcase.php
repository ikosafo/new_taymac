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
(CONCAT(firstname, ' ',surname) LIKE '%" . $searchValue . "%'
OR CONCAT(firstname, ' ',surname, ' ',othername) LIKE '%" . $searchValue . "%'
OR CONCAT(surname, ' ',firstname, ' ',othername) LIKE '%" . $searchValue . "%'
OR CONCAT(firstname, ' ',othername, ' ',surname) LIKE '%" . $searchValue . "%'
OR CONCAT(surname, ' ',othername, ' ',firstname) LIKE '%" . $searchValue . "%'
OR CONCAT(othername, ' ',firstname, ' ',surname) LIKE '%" . $searchValue . "%'
OR CONCAT(othername, ' ',surname, ' ',firstname) LIKE '%" . $searchValue . "%'
OR surname LIKE '%" . $searchValue . "%'
OR firstname LIKE '%" . $searchValue . "%'
OR othername LIKE '%" . $searchValue . "%'
OR email_address LIKE '%" . $searchValue . "%'
OR profession LIKE '%" . $searchValue . "%' ) ";
}


## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from permanent_special_cases");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($con,"select count(*) as allcount from permanent_special_cases WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from permanent_special_cases WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();


while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "firstname"=>$row['surname'].' '.$row['firstname'].'
        '.$row['othername'].'<br/>'.'<small>'.$row['institution'].'</small>',
        "email_address"=>$row['email_address'].'<br/>'.$row['telephone'].'<br/>'.$row['profession'],
        "completion_year"=>$row['completion_year'],
        "reason"=>$row['reason'],
        "random_code"=>$row['random_code'],
        "userid"=>getuser($row['userid']),
        "id"=>deletelink($row['id'])
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