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
(CONCAT(first_name, ' ',surname) LIKE '%" . $searchValue . "%'
OR CONCAT(first_name, ' ',surname, ' ',other_name) LIKE '%" . $searchValue . "%'
OR CONCAT(surname, ' ',first_name, ' ',other_name) LIKE '%" . $searchValue . "%'
OR CONCAT(first_name, ' ',other_name, ' ',surname) LIKE '%" . $searchValue . "%'
OR CONCAT(surname, ' ',other_name, ' ',first_name) LIKE '%" . $searchValue . "%'
OR CONCAT(other_name, ' ',first_name, ' ',surname) LIKE '%" . $searchValue . "%'
OR CONCAT(other_name, ' ',surname, ' ',first_name) LIKE '%" . $searchValue . "%'
OR surname LIKE '%" . $searchValue . "%'
OR first_name LIKE '%" . $searchValue . "%'
OR other_name LIKE '%" . $searchValue . "%'
OR email_address LIKE '%" . $searchValue . "%'
OR provisional_payment LIKE '%" . $searchValue . "%'
OR profession LIKE '%" . $searchValue . "%'
OR provisional_pin LIKE '%" . $searchValue . "%') ";
}


$year = $_GET['year'];
$status = $_GET['status'];
//$email_address = $_GET['email'];

if ($status == "All") {

        if ($year == "All") {
                ## Total number of records without filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades where 
        (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)')");
                $records = mysqli_fetch_assoc($sel);
                $totalRecords = $records['allcount'];

                ## Total number of record with filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades 
                WHERE (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)')
                                   AND 1 " . $searchQuery);
                $records = mysqli_fetch_assoc($sel);
                $totalRecordwithFilter = $records['allcount'];

                ## Fetch records
                $empQuery = "select * from registration_upgrades 
                WHERE (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') 
                AND 1 " . $searchQuery . " order by
                               date_requested DESC limit " . $row . "," . $rowperpage;
                $empRecords = mysqli_query($con, $empQuery);
                $data = array();
        } else {

                ## Total number of records without filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades where 
                        (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') AND SUBSTRING(date_requested,1,4) = '$year'");
                $records = mysqli_fetch_assoc($sel);
                $totalRecords = $records['allcount'];

                ## Total number of record with filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades WHERE 
                        (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') AND SUBSTRING(date_requested,1,4) = '$year' 
                        AND 1 " . $searchQuery);
                $records = mysqli_fetch_assoc($sel);
                $totalRecordwithFilter = $records['allcount'];

                ## Fetch records
                $empQuery = "select * from registration_upgrades WHERE (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') 
                        AND SUBSTRING(date_requested,1,4) = '$year' 
                        AND 1 " . $searchQuery . " order by date_requested DESC limit " . $row . "," . $rowperpage;
                $empRecords = mysqli_query($con, $empQuery);
                $data = array();
        }
} else if ($status == "Approved") {

        if ($year == "All") {
                ## Total number of records without filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades 
                where (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') AND admincheck_status = 'Approved'");
                $records = mysqli_fetch_assoc($sel);
                $totalRecords = $records['allcount'];

                ## Total number of record with filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades 
                WHERE (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') AND admincheck_status = 'Approved'
                                   AND 1 " . $searchQuery);
                $records = mysqli_fetch_assoc($sel);
                $totalRecordwithFilter = $records['allcount'];

                ## Fetch records
                $empQuery = "select * from registration_upgrades WHERE (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') 
                AND admincheck_status = 'Approved'  AND 1 " . $searchQuery . " order by
                               date_requested DESC limit " . $row . "," . $rowperpage;
                $empRecords = mysqli_query($con, $empQuery);
                $data = array();
        } else {

                ## Total number of records without filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades where 
                SUBSTRING(date_requested,1,4) = '$year' AND admincheck_status = 'Approved'");
                $records = mysqli_fetch_assoc($sel);
                $totalRecords = $records['allcount'];

                ## Total number of record with filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades WHERE 
                SUBSTRING(date_requested,1,4) = '$year' AND admincheck_status = 'Approved' 
                AND 1 " . $searchQuery);
                $records = mysqli_fetch_assoc($sel);
                $totalRecordwithFilter = $records['allcount'];

                ## Fetch records
                $empQuery = "select * from registration_upgrades WHERE SUBSTRING(date_requested,1,4) = '$year' 
                AND admincheck_status = 'Approved' AND 1 " . $searchQuery . " order by date_requested DESC limit " . $row . "," . $rowperpage;
                $empRecords = mysqli_query($con, $empQuery);
                $data = array();
        }
} else if ($status == "Rejected") {

        if ($year == "All") {
                ## Total number of records without filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades where 
                (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') AND admincheck_status = 'Rejected'");
                $records = mysqli_fetch_assoc($sel);
                $totalRecords = $records['allcount'];

                ## Total number of record with filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades WHERE 
                (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') AND admincheck_status = 'Rejected'
                                   AND 1 " . $searchQuery);
                $records = mysqli_fetch_assoc($sel);
                $totalRecordwithFilter = $records['allcount'];

                ## Fetch records
                $empQuery = "select * from registration_upgrades WHERE (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') 
                AND admincheck_status = 'Rejected'  AND 1 " . $searchQuery . " order by
                               date_requested DESC limit " . $row . "," . $rowperpage;
                $empRecords = mysqli_query($con, $empQuery);
                $data = array();
        } else {

                ## Total number of records without filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades where 
                (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') AND
                SUBSTRING(date_requested,1,4) = '$year' AND admincheck_status = 'Rejected'");
                $records = mysqli_fetch_assoc($sel);
                $totalRecords = $records['allcount'];

                ## Total number of record with filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades WHERE
                (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') AND 
                SUBSTRING(date_requested,1,4) = '$year' AND 
                admincheck_status = 'Rejected' AND 1 " . $searchQuery);
                $records = mysqli_fetch_assoc($sel);
                $totalRecordwithFilter = $records['allcount'];

                ## Fetch records
                $empQuery = "select * from registration_upgrades WHERE 
                (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') AND 
                SUBSTRING(date_requested,1,4) = '$year' 
                AND admincheck_status = 'Rejected' AND 1 " . $searchQuery . " order by date_requested DESC limit " . $row . "," . $rowperpage;
                $empRecords = mysqli_query($con, $empQuery);
                $data = array();
        }
} else if ($status == "Pending") {

        if ($year == "All") {
                ## Total number of records without filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades where (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') AND
                payment = '1'  AND usercheck_status = 'Approved' AND (admincheck_status = '' OR admincheck_status IS NULL)");
                $records = mysqli_fetch_assoc($sel);
                $totalRecords = $records['allcount'];

                ## Total number of record with filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades WHERE (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') AND
                payment = '1'  AND usercheck_status = 'Approved' AND (admincheck_status = '' OR admincheck_status IS NULL)
                                   AND 1 " . $searchQuery);
                $records = mysqli_fetch_assoc($sel);
                $totalRecordwithFilter = $records['allcount'];

                ## Fetch records
                $empQuery = "select * from registration_upgrades WHERE (registration_type = 'permanent_upgrade' OR registration_type = 'PERMANENT(UPGRADE)') 
        AND payment = '1'  
        AND usercheck_status = 'Approved' AND (admincheck_status = '' OR admincheck_status IS NULL)  AND 1 " . $searchQuery . " order by
                               date_requested DESC limit " . $row . "," . $rowperpage;
                $empRecords = mysqli_query($con, $empQuery);
                $data = array();
        } else {

                ## Total number of records without filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades where SUBSTRING(date_requested,1,4) = '$year'
                AND payment = '1'  AND usercheck_status = 'Approved' AND (admincheck_status = '' OR admincheck_status IS NULL)");
                $records = mysqli_fetch_assoc($sel);
                $totalRecords = $records['allcount'];

                ## Total number of record with filtering
                $sel = mysqli_query($con, "select count(*) as allcount from registration_upgrades WHERE SUBSTRING(date_requested,1,4) = '$year'
                AND payment = '1'  AND usercheck_status = 'Approved' AND (admincheck_status = '' OR admincheck_status IS NULL) AND 1 " . $searchQuery);
                $records = mysqli_fetch_assoc($sel);
                $totalRecordwithFilter = $records['allcount'];

                ## Fetch records
                $empQuery = "select * from registration_upgrades WHERE SUBSTRING(date_requested,1,4) = '$year' AND 
                payment = '1'
                AND usercheck_status = 'Approved' AND (admincheck_status = '' OR admincheck_status IS NULL) AND 1 " . $searchQuery . " order by date_requested DESC limit " . $row . "," . $rowperpage;
                $empRecords = mysqli_query($con, $empQuery);
                $data = array();
        }
}



while ($row = mysqli_fetch_assoc($empRecords)) {
        $data[] = array(
                "provisionalid" => getappfulldetails($row['applicant_id']),
                "email_address" => getemail($row['applicant_id']),
                "provisional_pin" => getpin($row['applicant_id']),
                "usercheck_status" => perupshowbtnuser($row['id']),
                "admincheck_status" => perupshowbtnadmin($row['id']),
                "payment" => getpayment($row['payment']),
                "period" => $row['date_requested'] . '<br/> (' . time_elapsed_string($row['date_requested']) . ')',
                "upgrade_id" => superupapproval($row['id'])
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
