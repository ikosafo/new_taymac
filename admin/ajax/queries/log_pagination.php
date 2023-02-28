<?php
include('../../../config.php');

$username = $_SESSION['username'];

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
(message LIKE '%" . $searchValue . "%'
OR logdate LIKE '%" . $searchValue . "%'
OR action LIKE '%" . $searchValue . "%'
OR ip_address LIKE '%" . $searchValue . "%'
OR mac_address LIKE '%" . $searchValue . "%') ";
}

## Total number of records without filtering
$sel = mysqli_query($mysqli, "select count(*) as allcount from `taymac_logs_mis` where username = '$username'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($mysqli, "select count(*) as allcount from `taymac_logs_mis` where username = '$username'
              AND 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from `taymac_logs_mis` where username = '$username' AND 1 " . $searchQuery . " order by
          logid DESC limit " . $row . "," . $rowperpage;
$empRecords = mysqli_query($mysqli, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "message" => $row['message'],
        "logdate" => $row['logdate'],
        "action" => $row['action'],
        "ip_address" => $row['ip_address'],
        "mac_address" => $row['mac_address']
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
