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
oldpin LIKE '%" . $searchValue . "%'
OR newpin LIKE '%" . $searchValue . "%'
OR dateupdated LIKE '%" . $searchValue . "%') ";
}


## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from pin_regenerates where id != ''");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($con,"select count(*) as allcount from pin_regenerates where id != ''
                                   AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from pin_regenerates where id != '' AND 1 ".$searchQuery." order by
                               id DESC limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();


while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "oldpin"=>$row['oldpin'],
        "newpin"=>$row['newpin'],
        "dateupdated"=>$row['dateupdated'],
        "userid"=>getuser($row['userid']),
        "status"=>getpinstatus($row['newpin']),
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