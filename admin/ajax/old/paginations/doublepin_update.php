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
(
other_names LIKE '%" . $searchValue . "%'
OR surname LIKE '%" . $searchValue . "%'
OR emailaddress LIKE '%" . $searchValue . "%'
OR profession LIKE '%" . $searchValue . "%'
OR institution LIKE '%" . $searchValue . "%'
OR pin LIKE '%" . $searchValue . "%'
OR contact LIKE '%" . $searchValue . "%') ";
}


## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from exc_pin_data");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($con,"select count(*) as allcount from exc_pin_data WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from exc_pin_data WHERE 1 ".$searchQuery." order by other_names limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();




while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "fullname"=>getnamepinexcel($row['pinid']),
        "emailaddress"=>$row['emailaddress'],
        "telephone"=>$row['contact'],
        "profession"=>$row['profession'],
        "institution"=>$row['institution'],
        "pin"=>$row['pin'],
        "dbpin"=>getdbpin($row['emailaddress']),
        "pinstatus"=>getpinstatusexcel($row['emailaddress']),
        "pinid"=>updatedbpin($row['emailaddress'],$row['pin']),
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