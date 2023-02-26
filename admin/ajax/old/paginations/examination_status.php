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
(CONCAT(firstname, ' ',lastname) LIKE '%" . $searchValue . "%'
OR CONCAT(lastname, ' ',firstname) LIKE '%" . $searchValue . "%'
OR lastname LIKE '%" . $searchValue . "%'
OR firstname LIKE '%" . $searchValue . "%'
OR fullname LIKE '%" . $searchValue . "%'
OR profession LIKE '%" . $searchValue . "%'
OR remarks LIKE '%" . $searchValue . "%'
OR results LIKE '%" . $searchValue . "%'
OR indexnumber LIKE '%" . $searchValue . "%') ";
}

$year = $_GET['year'];
$status = $_GET['status'];
//$email_address = $_GET['email'];

if ($status == "All") {

    if ($year == "All") {
        ## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from examination where results != ''");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from examination where results != ''
                                   AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from examination where results != '' AND 1 ".$searchQuery." order by
                               fullname limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }

    else {

## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from examination where SUBSTRING(examdate,1,4) = '$year'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from examination WHERE SUBSTRING(examdate,1,4) = '$year' AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from examination WHERE SUBSTRING(examdate,1,4) = '$year' AND 1 ".$searchQuery." order by fullname,examdate DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }


}


else if ($status == "Passed") {

    if ($year == "All") {
        ## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from examination where results != '' AND lower(remarks) = 'pass'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from examination where results != '' AND lower(remarks) = 'pass'
                                   AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from examination where results != '' AND lower(remarks) = 'pass'  AND 1 ".$searchQuery." order by
                               fullname,examdate DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }

    else {

## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from examination where SUBSTRING(examdate,1,4) = '$year' AND lower(remarks) = 'pass'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from examination WHERE SUBSTRING(examdate,1,4) = '$year' AND lower(remarks) = 'pass' AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from examination WHERE SUBSTRING(examdate,1,4) = '$year' AND lower(remarks) = 'pass' AND 1 ".$searchQuery." order by fullname,examdate DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }


}


else {


    if ($year == "All") {
        ## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from examination where results != '' AND lower(remarks) = 'fail'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from examination where results != '' AND lower(remarks) = 'fail'
                                   AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from examination where results != '' AND lower(remarks) = 'fail'  AND 1 ".$searchQuery." order by
                               fullname,examdate DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }

    else {

## Total number of records without filtering
        $sel = mysqli_query($con,"select count(*) as allcount from examination where SUBSTRING(examdate,1,4) = '$year' AND lower(remarks) = 'fail'");
        $records = mysqli_fetch_assoc($sel);
        $totalRecords = $records['allcount'];

## Total number of record with filtering
        $sel = mysqli_query($con,"select count(*) as allcount from examination WHERE SUBSTRING(examdate,1,4) = '$year' AND lower(remarks) = 'fail' AND 1 ".$searchQuery);
        $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $records['allcount'];

## Fetch records
        $empQuery = "select * from examination WHERE SUBSTRING(examdate,1,4) = '$year' AND lower(remarks) = 'fail' AND 1 ".$searchQuery." order by fullname,examdate DESC limit ".$row.",".$rowperpage;
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
    }

}



while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "fullname"=>$row['fullname'],
        "profession"=>$row['profession'],
        "indexnumber"=>$row['indexnumber'],
        "results"=>$row['results'],
        "remarks"=>getexamremark($row['remarks']),
        "status"=>$row['status'],
        "pin"=>$row['pin'],
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