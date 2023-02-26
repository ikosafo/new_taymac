<?php
include('../../../config.php');

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $then = new DateTime($datetime);
    $diff = (array) $now->diff($then);

    $diff['w']  = floor($diff['d'] / 7);
    $diff['d'] -= $diff['w'] * 7;

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
        if ($diff[$k]) {
            $v = $diff[$k] . ' ' . $v . ($diff[$k] > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


$searchValue = $_POST['renewal_search'];
$year_search = $_POST['year_search'];
$status = $_POST['renewal_status'];
$admintype = $_POST['admintype'];

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
OR profession LIKE '%" . $searchValue . "%'
OR exam_index_number LIKE '%" . $searchValue . "%'
OR provisional_pin LIKE '%" . $searchValue . "%') ";
}

if ($admintype == "Super Admin") {

    if ($status == "All") {

        $getdetails = $mysqli->query("select p.title,
                                    p.profession,
                                    p.othertitle,
                                    p.surname,
                                    p.first_name,
                                    p.other_name,
                                    p.email_address,
                                    p.provisional_pin,
                                    r.cpd_usercheck_status,
                                    r.payment,
                                    r.cpd_admincheck_status,
                                    r.period_registered,
                                    p.applicant_id from renewal r 
            JOIN provisional p ON r.applicant_id = p.applicant_id 
            WHERE r.cpdyear = '$year_search'
            AND 1 " . $searchQuery . "          
            ORDER BY r.period_registered DESC,r.payment DESC");
    } else if ($status == "Approved") {
        $getdetails = $mysqli->query("select p.title,
                                p.profession,
                                p.othertitle,
                                p.surname,
                                p.first_name,
                                p.other_name,
                                p.email_address,
                                p.provisional_pin,
                                r.cpd_usercheck_status,
                                r.payment,
                                r.cpd_admincheck_status,
                                r.period_registered,
                                p.applicant_id from renewal r 
            JOIN provisional p ON r.applicant_id = p.applicant_id
            WHERE r.cpdyear = '$year_search'
            AND r.cpd_admincheck_status = 'Approved'
            AND 1 " . $searchQuery . "        
            ORDER BY r.period_registered DESC,r.payment DESC");
    } else if ($status == "Rejected") {
        $getdetails = $mysqli->query("select p.title,
                                p.profession,
                                p.othertitle,
                                p.surname,
                                p.first_name,
                                p.other_name,
                                p.email_address,
                                p.provisional_pin,
                                r.cpd_usercheck_status,
                                r.payment,
                                r.cpd_admincheck_status,
                                r.period_registered,
                                p.applicant_id from renewal r 
            JOIN provisional p ON r.applicant_id = p.applicant_id
            WHERE r.cpdyear = '$year_search'
            AND r.cpd_admincheck_status = 'Rejected'
            AND 1 " . $searchQuery . "
            ORDER BY r.period_registered DESC,r.payment DESC");
    } else if ($status == "Pending") {
        $getdetails = $mysqli->query("select p.title,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        r.cpd_usercheck_status,
                        r.payment,
                        r.cpd_admincheck_status,
                        r.period_registered,
                        p.applicant_id from renewal r 
            JOIN provisional p ON r.applicant_id = p.applicant_id
            WHERE r.cpdyear = '$year_search' AND  r.payment = '1'
            AND r.cpd_usercheck_status = 'Approved' AND (r.cpd_admincheck_status = '' 
            OR r.cpd_admincheck_status IS NULL)
            AND 1 " . $searchQuery . "
            ORDER BY r.period_registered DESC,r.payment DESC");
    } else if ($status == "Resubmitted") {
        $getdetails = $mysqli->query("select p.title,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        r.cpd_usercheck_status,
                        r.payment,
                        r.cpd_admincheck_status,
                        r.period_registered,
                        p.applicant_id from renewal r 
            JOIN provisional p ON r.applicant_id = p.applicant_id
            WHERE r.cpdyear = '$year_search'
            AND r.cpd_admincheck_status = 'Resubmitted'
            AND 1 " . $searchQuery . "
            ORDER BY r.period_registered DESC,r.payment DESC");
    }
} else {

    if ($status == "All") {
        $getdetails = $mysqli->query("select p.title,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        r.cpd_usercheck_status,
                        r.payment,
                        r.cpd_admincheck_status,
                        r.period_registered,
                        p.applicant_id from renewal r 
            JOIN provisional p ON r.applicant_id = p.applicant_id 
            WHERE r.cpdyear = '$year_search'
            AND 1 " . $searchQuery . "          
            ORDER BY r.period_registered DESC,r.payment DESC");
    } else if ($status == "Approved") {
        $getdetails = $mysqli->query("select p.title,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        r.cpd_usercheck_status,
                        r.payment,
                        r.cpd_admincheck_status,
                        r.period_registered,
                        p.applicant_id from renewal r 
            JOIN provisional p ON r.applicant_id = p.applicant_id
            WHERE r.cpdyear = '$year_search'
            AND r.cpd_usercheck_status = 'Approved'
            AND 1 " . $searchQuery . "        
            ORDER BY r.period_registered DESC,r.payment DESC");
    } else if ($status == "Rejected") {
        $getdetails = $mysqli->query("select p.title,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        r.cpd_usercheck_status,
                        r.payment,
                        r.cpd_admincheck_status,
                        r.period_registered,
                        p.applicant_id from renewal r 
            JOIN provisional p ON r.applicant_id = p.applicant_id
            WHERE r.cpdyear = '$year_search'
            AND r.cpd_usercheck_status = 'Rejected'
            AND 1 " . $searchQuery . "
            ORDER BY r.period_registered DESC,r.payment DESC");
    } else if ($status == "Pending") {
        $getdetails = $mysqli->query("select p.title,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        r.cpd_usercheck_status,
                        r.payment,
                        r.cpd_admincheck_status,
                        r.period_registered,
                        p.applicant_id from renewal r 
            JOIN provisional p ON r.applicant_id = p.applicant_id
            WHERE r.cpdyear = '$year_search' AND r.payment = '1'
            AND (r.cpd_usercheck_status = '' OR r.cpd_usercheck_status IS NULL)
            AND 1 " . $searchQuery . "
            ORDER BY r.period_registered DESC,r.payment DESC");
    } else if ($status == "Resubmitted") {
        $getdetails = $mysqli->query("select p.title,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        r.cpd_usercheck_status,
                        r.payment,
                        r.cpd_admincheck_status,
                        r.period_registered,
                        p.applicant_id from renewal r 
            JOIN provisional p ON r.applicant_id = p.applicant_id
            WHERE r.cpdyear = '$year_search'
            AND r.cpd_usercheck_status = 'Resubmitted'
            AND 1 " . $searchQuery . "
            ORDER BY r.period_registered DESC,r.payment DESC");
    }
}



?>


<div class="table-responsive" id="renewalsearch_table">
    <table id="renewal-table" class="table" style="margin-top: 3% !important;">
        <thead>
            <tr>
                <th width="15%">Full Name</th>
                <th>Email Address</th>
                <th>PIN</th>
                <th>MIS Status</th>
                <th>Admin Status</th>
                <th>Period Regsitered</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($resdetails = $getdetails->fetch_assoc()) { ?>

                <tr>
                    <td>
                        <?php
                        $title = $resdetails['title'];
                        $profession = $resdetails['profession'];
                        if ($title == "Other") {
                            $title = $resdetails['othertitle'];
                            $fullname = $resdetails["surname"] . " " . $resdetails["first_name"] . " " . $resdetails["other_name"] . "(" . $title . ")";
                        } else {
                            $fullname = $resdetails["surname"] . " " . $resdetails["first_name"] . " " . $resdetails["other_name"] . "(" . $title . ")";
                        }

                        ?>
                        <div class="kt-widget31">
                            <div class="kt-widget31__item">
                                <div class="kt-widget31__content" style="width: 100% !important;">
                                    <div class="kt-widget31__pic kt-widget4__pic--pic">
                                        <!--<img src="'.$imgloc.'" alt="Img"> -->
                                    </div>
                                    <div class="kt-widget31__info" style="padding: 0 0.8rem;width:100% !important">
                                        <a href="#" class="kt-widget31__username" style="font-weight:300;font-size:1.0rem">
                                            <?php echo $fullname;  ?>
                                        </a>
                                        <p class="kt-widget31__text" style="font-weight:300;font-size:0.8rem">
                                            <?php echo $profession;  ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                    <td>
                        <?php echo $resdetails['email_address']; ?>
                    </td>
                    <td>
                        <?php echo $resdetails['provisional_pin']; ?>
                    </td>
                    <td>

                        <?php $cpd_usercheck_status =  $resdetails['cpd_usercheck_status'];
                        $renewal_payment = $resdetails['payment'];

                        if ($renewal_payment == "1") {
                            if ($cpd_usercheck_status == "Approved") {
                                echo '<span class="kt-badge  kt-badge--success 
                                    kt-badge--inline kt-badge--pill">Approved</span>';
                            } else if ($cpd_usercheck_status == "Rejected") {
                                echo '<span class="kt-badge  kt-badge--danger 
                                    kt-badge--inline kt-badge--pill">Rejected</span>';
                            } else {
                                echo '<span class="kt-badge  kt-badge--primary 
                                    kt-badge--inline kt-badge--pill">Pending ...</span>';
                            }
                        } else {
                            echo '<span style="color: red">Not Paid</span>';
                        }
                        ?>

                    </td>
                    <td>
                        <?php
                        //$cpd_usercheck_status =  $resdetails['cpd_usercheck_status'];
                        $cpd_admincheck_status =  $resdetails['cpd_admincheck_status'];

                        if ($cpd_usercheck_status == "Approved" && $cpd_admincheck_status == "") {
                            echo '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
                        } else if ($cpd_admincheck_status == "Rejected") {
                            echo '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
                        } else if ($cpd_admincheck_status == "Approved") {
                            echo '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
                        }

                        ?>

                    </td>

                    <td>
                        <?php echo $resdetails['period_registered'] . '<br/> (' . time_elapsed_string($resdetails['period_registered']) . ')' ?>
                    </td>
                    <td>
                        <?php
                        if ($admintype == "Super Admin") { ?>
                            <button class="btn btn btn-label-facebook cpdsuperapprove_btn" i_index=<?php echo $resdetails['applicant_id']; ?> i_year=<?php echo $year_search; ?>>
                                View and Approve
                            </button>
                        <?php } else {
                            $newappid = str_replace(" ", "%", $resdetails['applicant_id']);
                        ?>
                            <button class="btn btn btn-label-facebook 
                            cpdmisapprove_btn" i_index=<?php echo $newappid; ?> i_year=<?php echo $year_search; ?>>
                                View and Approve
                            </button>

                        <?php }
                        ?>

                    </td>
                </tr>

            <?php }
            ?>

        </tbody>
    </table>
</div>



<script>
    oTable2 = $('#renewal-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverMethod': 'post'
    });
</script>