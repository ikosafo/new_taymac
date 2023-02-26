<?php

include ('../../includes/db.php');
//include ('../../includes/phpfunctions.php');

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

//Get Profession
function getprofession ($id) {
    include ('../../includes/db.php');

    $q = mysqli_query($con,"select * from professions where professionid = '$id'");
    $result = mysqli_fetch_assoc($q);
    return $result['professionname'];
}

function accountprint($accountid) {
    return '<button class="btn btn btn-label-facebook accountprint_btn"
                    i_index='.$accountid.'>
                        View and Print
    </button>';
}



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
(fullname LIKE '%" . $searchValue . "%'
OR emailaddress LIKE '%" . $searchValue . "%'
OR amountpaid LIKE '%" . $searchValue . "%'
OR accounttype LIKE '%" . $searchValue . "%') ";
}

$year = $_GET['year'];
//$email_address = $_GET['email'];

if ($year == "All") {
    ## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from accounts where recievedby = 'GCB' ");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from accounts WHERE recievedby = 'GCB' ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "select * from accounts WHERE recievedby = 'GCB' ".$searchQuery." order by
    accountid DESC,paymentdate DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
}

else {

## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from accounts WHERE recievedby = 'GCB' and SUBSTRING(paymentdate,1,4) = '$year'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

## Total number of record with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from accounts WHERE recievedby = 'GCB' and SUBSTRING(paymentdate,1,4) = '$year' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $empQuery = "select * from accounts WHERE recievedby = 'GCB' and SUBSTRING(paymentdate,1,4) = '$year' AND 1 ".$searchQuery."
    order by accountid DESC,paymentdate DESC limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
}



while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "full_name"=>$row['fullname'],
        "email_address"=>$row['emailaddress'],
        "acc_type"=>$row['accounttype'],
        "amt_paid"=>$row['amountpaid'],
        "date_received"=>$row['paymentdate'].'<br/>('.time_elapsed_string($row['paymentdate']).')',
        "profession"=>getprofession($row['professionid']),
        /*"telephone"=>$row['telephonenumber'],*/
        "action"=>accountprint($row['accountid'])
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