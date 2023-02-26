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
OR applicant_id LIKE '%" . $searchValue . "%'
OR first_name LIKE '%" . $searchValue . "%'
OR other_name LIKE '%" . $searchValue . "%'
OR email_address LIKE '%" . $searchValue . "%'
OR provisional_payment LIKE '%" . $searchValue . "%'
OR profession LIKE '%" . $searchValue . "%'
OR provisional_pin LIKE '%" . $searchValue . "%') ";
}

//$year = $_GET['year'];
//$status = $_GET['status'];
//$email_address = $_GET['email'];

## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from provisional");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($con,"select count(*) as allcount from provisional WHERE provisionalid != ''
                                   AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from provisional WHERE provisionalid != '' AND 1 ".$searchQuery." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "fullname"=>getfulldetails($row['provisionalid']),
        "previousname"=>$row['previous_name'],
        "emailaddress"=>$row['email_address'],
        "telephone"=>$row['telephone'],
        "birthdate"=>$row['birth_date'].' in '.$row['place_of_birth'],
        "nationality"=>$row['nationality'].'/'.$row['hometown'],
        "region"=>$row['res_region'],
        "district"=>$row['contact_address'],
        "housenumber"=>$row['res_housenumber'],
        "streetname"=>$row['res_streetname'],
        "locality"=>$row['res_locality'],
        "gender"=>$row['gender'],
        "maritalstatus"=>$row['marital_status'],
        "profession"=>$row['profession'],
        "pin"=>$row['provisional_pin'],
        "provreg"=>getregstatus($row['provisional_registration']),
        "provpmt"=>getpmtstatus($row['provisional_payment']),
        "provdate"=>$row['provisional_period'],
        "provmis"=>$row['provisional_usercheck_status'],
        "provsuper"=>$row['provisional_admincheck_status'],
        "permreg"=>getregstatus($row['permanent_registration']),
        "permpmt"=>getpmtstatus($row['permanent_payment']),
        "permdate"=>$row['permanent_period'],
        "permmis"=>$row['permanent_usercheck_status'],
        "permsuper"=>$row['permanent_admincheck_status'],
        "examreg"=>getregstatus($row['examination_registration']),
        "examind"=>$row['exam_index_number'],
        "temreg"=>getregstatus($row['temporal_registration']),
        "tempmt"=>getpmtstatus($row['temporal_payment']),
        "temdate"=>$row['temporal_period'],
        "temmis"=>$row['temporal_usercheck_status'],
        "temsuper"=>$row['temporal_admincheck_status'],
        "renewal"=>$row['renewal'],
        "applicantid"=>$row['applicant_id'],
        "action"=>itdel($row['provisionalid'])

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