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


$searchValue = $_POST['provisional_search'];
$year_search = $_POST['year_search'];
$status = $_POST['provisional_status'];
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
OR profession LIKE '%" . $searchValue . "%'
OR exam_index_number LIKE '%" . $searchValue . "%'
OR provisional_pin LIKE '%" . $searchValue . "%') ";
}


if ($year_search == "All") {

    if ($admintype == "Super Admin") {

        if ($status == "All") {

            $getdetails = $mysqli->query("select p.title,u.id,
                                    p.profession,
                                    p.othertitle,
                                    p.surname,
                                    p.first_name,
                                    p.other_name,
                                    p.email_address,
                                    p.provisional_pin,
                                    u.usercheck_status,
                                    u.payment,
                                    u.admincheck_status,
                                    u.date_requested,
                                    p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id 
            WHERE 1 ".$searchQuery."          
            ORDER BY u.date_requested DESC,u.payment DESC"); 

        }
    
        else if ($status == "Approved") {
            $getdetails = $mysqli->query("select p.title,u.id,
                                p.profession,
                                p.othertitle,
                                p.surname,
                                p.first_name,
                                p.other_name,
                                p.email_address,
                                p.provisional_pin,
                                u.usercheck_status,
                                u.payment,
                                u.admincheck_status,
                                u.date_requested,
                                p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE u.admincheck_status = 'Approved'
            AND 1 ".$searchQuery."        
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
    
        else if ($status == "Rejected") {
            $getdetails = $mysqli->query("select p.title,u.id,
                                p.profession,
                                p.othertitle,
                                p.surname,
                                p.first_name,
                                p.other_name,
                                p.email_address,
                                p.provisional_pin,
                                u.usercheck_status,
                                u.payment,
                                u.admincheck_status,
                                u.date_requested,
                                p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE u.admincheck_status = 'Rejected'
            AND 1 ".$searchQuery."
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
    
        else if ($status == "Pending") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE u.payment = '1'
            AND u.usercheck_status = 'Approved' AND (u.admincheck_status = '' 
            OR u.admincheck_status IS NULL)
            AND 1 ".$searchQuery."
            ORDER BY u.date_requested DESC,u.payment DESC");
        }

        else if ($status == "Resubmitted") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE u.admincheck_status = 'Resubmitted'
            AND 1 ".$searchQuery."
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
   
    }

        else {

        if ($status == "All") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id 
            WHERE 1 ".$searchQuery."          
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
    
        else if ($status == "Approved") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE u.usercheck_status = 'Approved'
            AND 1 ".$searchQuery."        
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
    
        else if ($status == "Rejected") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE u.usercheck_status = 'Rejected'
            AND 1 ".$searchQuery."
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
    
        else if ($status == "Pending") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE u.payment = '1'
            AND (u.usercheck_status = '' OR u.usercheck_status IS NULL)
            AND 1 ".$searchQuery."
            ORDER BY u.date_requested DESC,u.payment DESC");
        }

        else if ($status == "Resubmitted") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE u.usercheck_status = 'Resubmitted'
            AND 1 ".$searchQuery."
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
    
    }

   

}


else {

    if ($admintype == "Super Admin") {

        if ($status == "All") {

            $getdetails = $mysqli->query("select p.title,u.id,
                                    p.profession,
                                    p.othertitle,
                                    p.surname,
                                    p.first_name,
                                    p.other_name,
                                    p.email_address,
                                    p.provisional_pin,
                                    u.usercheck_status,
                                    u.payment,
                                    u.admincheck_status,
                                    u.date_requested,
                                    p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id 
            WHERE SUBSTRING(u.date_requested,1,4) = '$year_search'
            AND 1 ".$searchQuery."          
            ORDER BY u.date_requested DESC,u.payment DESC"); 

        }
    
        else if ($status == "Approved") {
            $getdetails = $mysqli->query("select p.title,u.id,
                                p.profession,
                                p.othertitle,
                                p.surname,
                                p.first_name,
                                p.other_name,
                                p.email_address,
                                p.provisional_pin,
                                u.usercheck_status,
                                u.payment,
                                u.admincheck_status,
                                u.date_requested,
                                p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE SUBSTRING(u.date_requested,1,4) = '$year_search'
            AND u.admincheck_status = 'Approved'
            AND 1 ".$searchQuery."        
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
    
        else if ($status == "Rejected") {
            $getdetails = $mysqli->query("select p.title,u.id,
                                p.profession,
                                p.othertitle,
                                p.surname,
                                p.first_name,
                                p.other_name,
                                p.email_address,
                                p.provisional_pin,
                                u.usercheck_status,
                                u.payment,
                                u.admincheck_status,
                                u.date_requested,
                                p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE SUBSTRING(u.date_requested,1,4) = '$year_search'
            AND u.admincheck_status = 'Rejected'
            AND 1 ".$searchQuery."
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
    
        else if ($status == "Pending") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE SUBSTRING(u.date_requested,1,4) = '$year_search' AND  u.payment = '1'
            AND u.usercheck_status = 'Approved' AND (u.admincheck_status = '' 
            OR u.admincheck_status IS NULL)
            AND 1 ".$searchQuery."
            ORDER BY u.date_requested DESC,u.payment DESC");
        }

        else if ($status == "Resubmitted") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE SUBSTRING(u.date_requested,1,4) = '$year_search'
            AND u.admincheck_status = 'Resubmitted'
            AND 1 ".$searchQuery."
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
   
    }

        else {

        if ($status == "All") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id 
            WHERE SUBSTRING(u.date_requested,1,4) = '$year_search'
            AND 1 ".$searchQuery."          
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
    
        else if ($status == "Approved") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE SUBSTRING(u.date_requested,1,4) = '$year_search'
            AND u.usercheck_status = 'Approved'
            AND 1 ".$searchQuery."        
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
    
        else if ($status == "Rejected") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE SUBSTRING(u.date_requested,1,4) = '$year_search'
            AND u.usercheck_status = 'Rejected'
            AND 1 ".$searchQuery."
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
    
        else if ($status == "Pending") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE SUBSTRING(u.date_requested,1,4) = '$year_search' AND u.payment = '1'
            AND (u.usercheck_status = '' OR u.usercheck_status IS NULL)
            AND 1 ".$searchQuery."
            ORDER BY u.date_requested DESC,u.payment DESC");
        }

        else if ($status == "Resubmitted") {
            $getdetails = $mysqli->query("select p.title,u.id,
                        p.profession,
                        p.othertitle,
                        p.surname,
                        p.first_name,
                        p.other_name,
                        p.email_address,
                        p.provisional_pin,
                        u.usercheck_status,
                        u.payment,
                        u.admincheck_status,
                        u.date_requested,
                        p.applicant_id from registration_upgrades u 
            JOIN provisional p ON u.applicant_id = p.applicant_id
            WHERE SUBSTRING(u.date_requested,1,4) = '$year_search'
            AND u.usercheck_status = 'Resubmitted'
            AND 1 ".$searchQuery."
            ORDER BY u.date_requested DESC,u.payment DESC");
        }
    
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
                        <th>Payment</th>
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
                           
                           <?php $usercheck_status =  $resdetails['usercheck_status'];
                                 $upgrade_payment = $resdetails['payment'];

                           if ($upgrade_payment == "1") {
                                if ($usercheck_status == "Approved"){
                                    echo '<span class="kt-badge  kt-badge--success 
                                    kt-badge--inline kt-badge--pill">Approved</span>';
                                }
                                else if ($usercheck_status == "Rejected") {
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
//$usercheck_status =  $resdetails['usercheck_status'];
                           $admincheck_status =  $resdetails['admincheck_status'];
                       
                           if ($usercheck_status == "Approved" && $admincheck_status == ""){
                               echo '<span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill">Pending ...</span>';
                           }
                           else if ($admincheck_status == "Rejected") {
                               echo '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
                           }
                           else if ($admincheck_status == "Approved"){
                               echo '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
                           }
                           
                           ?>

                        </td>

                        <td>
                            <?php
                            if ($upgrade_payment == '1') {
                                echo '<span style="color: green">Paid</span>';
                            }
                            else {
                                echo '<span style="color: red">Not Paid</span>';
                            }
                            ?>
                      
                        </td>
                      
                        <td>
                            <?php echo $resdetails['date_requested'].'<br/> ('.time_elapsed_string($resdetails['date_requested']).')' ?>
                        </td>



                        <td>
                            <?php
                            if ($admintype == "Super Admin") { ?>
                                <button class="btn btn btn-label-facebook superupapprovalpro"
                                    i_index=<?php echo $resdetails['id']; ?>
                                    i_year ='.$year.'
                                    >
                                        View and Approve
                                </button>
                            <?php }
                            else { ?>
                                <button class="btn btn btn-label-facebook misupapprovepro_btn"
                                    i_index=<?php echo $resdetails['id']; ?>>
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
        oTable2 = $('#provisional-table').DataTable({
            stateSave: true,
            "bLengthChange": false,
            dom: "rtiplf",
            "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
            'processing': true,
            'serverMethod': 'post'
        });

</script>        