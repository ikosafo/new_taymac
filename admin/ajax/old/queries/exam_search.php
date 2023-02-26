<?php
include('../../../config.php');

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


$searchValue = $_POST['examination_search'];
$type = $_POST['examtype'];
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];
$status = $_POST['status'];
$admintype = $_POST['admintype'];

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
OR first_name LIKE '%" . $searchValue . "%'
OR other_name LIKE '%" . $searchValue . "%'
OR email_address LIKE '%" . $searchValue . "%'
OR provisional_payment LIKE '%" . $searchValue . "%'
OR profession LIKE '%" . $searchValue . "%'
OR exam_index_number LIKE '%" . $searchValue . "%'
OR provisional_pin LIKE '%" . $searchValue . "%') ";
}

if ($admintype == "Super Admin") {

    if ($type == 'All') {

        if ($status == "All") {
            $getdetails = $mysqli->query("select * from examination_reg e 
            JOIN provisional p ON e.applicant_id = p.applicant_id 
            WHERE e.period_registered BETWEEN '$startdate' AND '$enddate'
            AND 1 ".$searchQuery."          
            ORDER BY e.period_registered DESC,e.payment DESC"); 
        }
    
        else if ($status == "Approved") {
            $getdetails = $mysqli->query("select * from examination_reg e 
            JOIN provisional p ON e.applicant_id = p.applicant_id
            WHERE e.period_registered BETWEEN '$startdate' AND '$enddate'
            AND e.exam_admincheck_status = 'Approved'
            AND 1 ".$searchQuery."        
            ORDER BY e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Rejected") {
            $getdetails = $mysqli->query("select * from examination_reg e 
            JOIN provisional p ON e.applicant_id = p.applicant_id
            WHERE e.period_registered BETWEEN '$startdate' AND '$enddate'
            AND e.exam_admincheck_status = 'Rejected'
            AND 1 ".$searchQuery."
            ORDER BY e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Pending") {
            $getdetails = $mysqli->query("select * from examination_reg e 
            JOIN provisional p ON e.applicant_id = p.applicant_id
            WHERE e.period_registered BETWEEN '$startdate' AND '$enddate' AND  e.payment = '1'
            AND e.exam_usercheck_status = 'Approved' AND (e.exam_admincheck_status = '' 
            OR e.exam_admincheck_status IS NULL)
            AND 1 ".$searchQuery."
            ORDER BY e.period_registered DESC,e.payment DESC");
        }
    }

    else if ($type == 'Supplementary') {

        if ($status == "All") {
            $getdetails = $mysqli->query("select * from examination_reg e 
            JOIN provisional p ON e.applicant_id = p.applicant_id WHERE
            e.exam_type = 'Supplementary' AND e.period_registered BETWEEN '$startdate' AND '$enddate' 
            AND 1 ".$searchQuery."
            ORDER BY e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Approved") {
            $getdetails = $mysqli->query("select * from examination_reg e 
            JOIN provisional p ON e.applicant_id = p.applicant_id WHERE 
            e.exam_type = 'Supplementary' AND e.period_registered BETWEEN '$startdate' AND '$enddate'
            AND e.exam_admincheck_status = 'Approved'
            AND 1 ".$searchQuery."
            ORDER BY e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Rejected") {
            $getdetails = $mysqli->query("select * from examination_reg e 
            JOIN provisional p ON e.applicant_id = p.applicant_id WHERE e.exam_type = 'Supplementary' 
            AND e.period_registered BETWEEN '$startdate' AND '$enddate'
            AND e.exam_admincheck_status = 'Rejected' 
            AND 1 ".$searchQuery."           
            ORDER BY e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Pending") {
            $getdetails = $mysqli->query("select * from examination_reg e 
            JOIN provisional p ON e.applicant_id = p.applicant_id WHERE e.exam_type = 'Supplementary' 
            AND e.period_registered BETWEEN '$startdate' AND '$enddate' AND  e.payment = '1'
            AND e.exam_usercheck_status = 'Approved' AND (e.exam_admincheck_status = '' 
            OR e.exam_admincheck_status IS NULL)
            AND 1 ".$searchQuery."
            ORDER BY e.period_registered DESC,e.payment DESC");
        }
    }

    else {

        if ($status == "All") {
            $getdetails = $mysqli->query("select * from examination_reg e 
            JOIN provisional p ON e.applicant_id = p.applicant_id WHERE
            e.exam_type != 'Supplementary' AND e.period_registered BETWEEN '$startdate' AND '$enddate'
             AND 1 ".$searchQuery."
            ORDER BY e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Approved") {
            $getdetails = $mysqli->query("select * from examination_reg e 
            JOIN provisional p ON e.applicant_id = p.applicant_id
            WHERE e.exam_type != 'Supplementary' AND e.period_registered BETWEEN '$startdate' 
            AND '$enddate'
            AND e.exam_admincheck_status = 'Approved' AND 1 ".$searchQuery."
            ORDER BY e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Rejected") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN provisional p 
            ON e.applicant_id = p.applicant_id
            WHERE e.exam_type != 'Supplementary' AND e.period_registered 
            BETWEEN '$startdate' AND '$enddate'
            AND e.exam_admincheck_status = 'Rejected' AND 1 ".$searchQuery."
            ORDER BY e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Pending") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN provisional p 
            ON e.applicant_id = p.applicant_id
            WHERE e.exam_type = 'Supplementary' AND e.period_registered 
            BETWEEN '$startdate' AND '$enddate' AND  e.payment = '1'
            AND e.exam_usercheck_status = 'Approved' AND (e.exam_admincheck_status = '' 
            OR e.exam_admincheck_status IS NULL)
            AND 1 ".$searchQuery." ORDER BY e.period_registered DESC,e.payment DESC");
        }
    
    }
}

else {

    if ($type == 'All') {

        if ($status == "All") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN 
            provisional p ON e.applicant_id = p.applicant_id WHERE e.period_registered 
            BETWEEN '$startdate' AND '$enddate' AND 1 ".$searchQuery."
            order by e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Approved") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN 
            provisional p ON e.applicant_id = p.applicant_id
            WHERE e.period_registered BETWEEN '$startdate' AND '$enddate'
            AND exam_usercheck_status = 'Approved' AND 1 ".$searchQuery."
            order by e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Rejected") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN 
            provisional p ON e.applicant_id = p.applicant_id
            WHERE e.period_registered BETWEEN '$startdate' AND '$enddate'
            AND exam_usercheck_status = 'Rejected' AND 1 ".$searchQuery."
            order by e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Pending") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN 
            provisional p ON e.applicant_id = p.applicant_id
            WHERE e.period_registered BETWEEN '$startdate' AND '$enddate' AND  payment = '1'
            AND (exam_usercheck_status = '' OR exam_usercheck_status IS NULL)
            AND 1 ".$searchQuery." order by e.period_registered DESC,e.payment DESC");
        }
    
    }
    

    else if ($type == 'Supplementary') {
    
        if ($status == "All") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN 
            provisional p ON e.applicant_id = p.applicant_id WHERE
            exam_type = 'Supplementary' AND e.period_registered 
            BETWEEN '$startdate' AND '$enddate' AND 1 ".$searchQuery."
            order by e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Approved") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN 
            provisional p ON e.applicant_id = p.applicant_id
            WHERE exam_type = 'Supplementary' AND e.period_registered 
            BETWEEN '$startdate' AND '$enddate'
            AND exam_usercheck_status = 'Approved' AND 1 ".$searchQuery."
            order by e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Rejected") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN 
            provisional p ON e.applicant_id = p.applicant_id
            WHERE exam_type = 'Supplementary' AND e.period_registered 
            BETWEEN '$startdate' AND '$enddate'
            AND exam_usercheck_status = 'Rejected' AND 1 ".$searchQuery."
            order by e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Pending") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN 
            provisional p ON e.applicant_id = p.applicant_id
            WHERE exam_type = 'Supplementary' AND e.period_registered 
            BETWEEN '$startdate' AND '$enddate' AND  payment = '1'
            AND (exam_usercheck_status = '' OR exam_usercheck_status IS NULL)
            AND 1 ".$searchQuery." order by e.period_registered DESC,e.payment DESC");
        }
    
    }

    
    else {
    
        if ($status == "All") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN 
            provisional p ON e.applicant_id = p.applicant_id WHERE
            exam_type != 'Supplementary' AND e.period_registered 
            BETWEEN '$startdate' AND '$enddate' AND 1 ".$searchQuery."
            order by e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Approved") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN 
            provisional p ON e.applicant_id = p.applicant_id
            WHERE exam_type != 'Supplementary' AND e.period_registered 
            BETWEEN '$startdate' AND '$enddate'
            AND exam_usercheck_status = 'Approved' AND 1 ".$searchQuery."
            order by e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Rejected") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN 
            provisional p ON e.applicant_id = p.applicant_id
            WHERE exam_type != 'Supplementary' AND e.period_registered 
            BETWEEN '$startdate' AND '$enddate'
            AND exam_usercheck_status = 'Rejected' AND 1 ".$searchQuery."
            order by e.period_registered DESC,e.payment DESC");
        }
    
        else if ($status == "Pending") {
            $getdetails = $mysqli->query("select * from examination_reg e JOIN 
            provisional p ON e.applicant_id = p.applicant_id
            WHERE exam_type = 'Supplementary' AND e.period_registered 
            BETWEEN '$startdate' AND '$enddate' AND  payment = '1'
            AND (exam_usercheck_status = '' OR exam_usercheck_status IS NULL)
            AND 1 ".$searchQuery." order by e.period_registered DESC,e.payment DESC");
        }
    
    }
}
                    

?>       


<div class="table-responsive" id="examsearch_table">
            <table id="exam-table" class="table" style="margin-top: 3% !important;">
                <thead>
                    <tr>
                        <th width="15%">Full Name</th>
                        <th>Email Address</th>
                        <th>Provisional PIN</th>
                        <th>Officer Status</th>
                        <th>Admin Status</th>
                        <th>Index Number</th>
                        <th>Period<br/>Regsitered</th>
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
                           
                           <?php $exam_usercheck_status =  $resdetails['exam_usercheck_status'];
                                 $exam_payment = $resdetails['payment'];

                           if ($exam_payment == "1") {
                                if ($exam_usercheck_status == "Approved"){
                                    echo '<span class="kt-badge  kt-badge--success 
                                    kt-badge--inline kt-badge--pill">Approved</span>';
                                }
                                else if ($exam_usercheck_status == "Rejected") {
                                    echo '<span class="kt-badge  kt-badge--danger 
                                    kt-badge--inline kt-badge--pill">Rejected</span>';
                                }
                                else {
                                    echo '<span class="kt-badge  kt-badge--primary 
                                    -badge--inline kt-badge--pill">Pending ...</span>';
                                }
                             }
                            else {
                                echo '<span style="color: red">Not Paid</span>';
                            }
                        ?>

                        </td>
                        <td>
                           <?php
//$exam_usercheck_status =  $resdetails['exam_usercheck_status'];
                           $exam_admincheck_status =  $resdetails['exam_admincheck_status'];
                       
                           if ($exam_usercheck_status == "Approved" && $exam_admincheck_status == ""){
                               echo '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
                           }
                           else if ($exam_admincheck_status == "Rejected") {
                               echo '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
                           }
                           else if ($exam_admincheck_status == "Approved"){
                               echo '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
                           }
                           
                           ?>

                        </td>
                        <td>
                            <?php echo $resdetails['exam_index_number']; ?>
                        </td>
                        <td>
                            <?php echo $resdetails['period_registered'].'<br/> ('.time_elapsed_string($resdetails['period_registered']).')' ?>
                        </td>
                        <td>
                            <button class="btn btn btn-label-facebook examapprove_btn"
                                    i_index=<?php echo $resdetails['examination_id']; ?>>
                                    View and Approve
                            </button>
                        </td>
                    </tr>

                    <?php }
                    ?>
                    
                </tbody>    
            </table>
        </div>



<script>
        oTable2 = $('#exam-table').DataTable({
            stateSave: true,
            "bLengthChange": false,
            dom: "rtiplf",
            "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
            'processing': true,
            'serverMethod': 'post'
        });

</script>        