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
(
name LIKE '%" . $searchValue . "%'
OR pin LIKE '%" . $searchValue . "%'
OR profession LIKE '%" . $searchValue . "%'
OR category LIKE '%" . $searchValue . "%'
OR years LIKE '%" . $searchValue . "%'
OR amount LIKE '%" . $searchValue . "%'
OR cpdyear LIKE '%" . $searchValue . "%' ) ";
}

$year = $_GET['year'];
//$email_address = $_GET['email'];

if ($year == "All") {
    ## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from owing");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from owing WHERE 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records

    $empQuery = "select * from owing WHERE 1 ".$searchQuery." order by id DESC
                           limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
}

else {

## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from owing where cpdyear = '$year'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from owing where cpdyear = '$year'
                                                AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "select * from owing where cpdyear = '$year' AND 1 ".$searchQuery."
                            order by id DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
}


while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "fullname"=>$row['name'],
        "pin"=>$row['pin'],
        "profession"=>$row['profession'],
        "level"=>$row['category'],
        "yearsdefault"=>$row['years'],
        "lastyear"=>$row['cpdyear'],
        "amount"=>$row['amount'],
        "action"=>getbilldetails($row['pin'])
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