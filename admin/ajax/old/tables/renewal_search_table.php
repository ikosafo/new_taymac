<?php include('../../../config.php');
$search_year = $_POST['search_year'];
$search_region = $_POST['search_region'];
$search_approval = $_POST['search_approval'];
$search_profession = $_POST['search_profession'];
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];
?>


    <div class="kt-separator kt-separator--dashed"></div>

    <div class="kt-section">


        <div class="kt-section__content responsive">

            <?php

            //ALL
            if ($search_region == "Any" && $search_approval == "Any" && $search_profession == "Any") {
                $query = $mysqli->query("SELECT *
                     FROM renewal r
                     JOIN provisional p ON r.applicant_id = p.applicant_id
                     WHERE r.cpdyear != '' AND r.cpdyear = '$search_year'
                     ORDER BY r.period_registered DESC");
                $count = mysqli_num_rows($query);
            }

            //TWO's
            //Approval and Profession
            else if ($search_approval == "Any" && $search_profession == "Any") {
                $query = $mysqli->query("SELECT *
                     FROM renewal r
                     JOIN provisional p ON r.applicant_id = p.applicant_id
                     WHERE r.cpdyear != '' AND r.cpdyear = '$search_year' AND p.res_region = '$search_region'
                     ORDER BY r.period_registered DESC");
                $count = mysqli_num_rows($query);
            } //Region and Profession
            else if ($search_region == "Any" && $search_profession == "Any") {
                if ($search_approval == "Pending") {
                    $query = $mysqli->query("SELECT *
                     FROM renewal r
                     JOIN provisional p ON r.applicant_id = p.applicant_id
                     WHERE r.cpdyear != '' AND r.cpdyear = '$search_year'
                     AND r.cpd_admincheck_status IS NULL ORDER BY r.period_registered DESC");
                    $count = mysqli_num_rows($query);
                } else {
                    $query = $mysqli->query("SELECT * 
                     FROM renewal r                      
                     JOIN provisional p ON r.applicant_id = p.applicant_id 
                     WHERE r.cpdyear != '' AND r.cpdyear = '$search_year'
                     AND r.cpd_admincheck_status = '$search_approval' 
                     ORDER BY r.period_registered DESC");
                    $count = mysqli_num_rows($query);
                }
            } //Approval and Region
            else if ($search_region == "Any" && $search_approval == "Any") {
                $query = $mysqli->query("SELECT * 
                   FROM renewal r                      
                   JOIN provisional p ON r.applicant_id = p.applicant_id 
                   WHERE r.cpdyear != '' AND r.cpdyear = '$search_year' 
                   AND p.profession = '$search_profession'
                   ORDER BY r.period_registered DESC");
                $count = mysqli_num_rows($query);
            } //ONE's
            else if ($search_region == "Any") {
                if ($search_approval == "Pending") {
                    $query = $mysqli->query("SELECT *                      
                      FROM renewal r                      
                      JOIN provisional p ON r.applicant_id = p.applicant_id 
                      WHERE r.cpdyear != '' AND r.cpdyear = '$search_year'
                      AND p.profession = '$search_profession' AND  r.cpd_admincheck_status IS NULL
                      ORDER BY r.period_registered DESC");
                    $count = mysqli_num_rows($query);
                } else {
                    $query = $mysqli->query("SELECT *                      
                      FROM renewal r                      
                      JOIN provisional p ON r.applicant_id = p.applicant_id 
                      WHERE r.cpdyear != '' AND r.cpdyear = '$search_year'
                      AND p.profession = '$search_profession' AND r.cpd_admincheck_status = '$search_approval'
                      ORDER BY r.period_registered DESC");
                    $count = mysqli_num_rows($query);
                }
            } else if ($search_approval == "Any") {
                $query = $mysqli->query("SELECT *                      
                      FROM renewal r                      
                      JOIN provisional p ON r.applicant_id = p.applicant_id  
                      WHERE r.cpdyear != '' AND r.cpdyear = '$search_year'
                      AND p.profession = '$search_profession' AND p.res_region = '$search_region'
                      ORDER BY r.period_registered DESC");
                $count = mysqli_num_rows($query);
            } else if ($search_profession == "Any") {
                if ($search_approval == "Pending") {
                    $query = $mysqli->query("SELECT *
                      FROM renewal r
                      JOIN provisional p ON r.applicant_id = p.applicant_id
                      WHERE r.cpdyear != '' AND r.cpdyear = '$search_year'
                      AND r.cpd_admincheck_status IS NULL AND p.res_region = '$search_region'
                      ORDER BY r.period_registered DESC");
                    $count = mysqli_num_rows($query);
                } else {
                    $query = $mysqli->query("SELECT *
                     FROM renewal r
                     JOIN provisional p ON r.applicant_id = p.applicant_id
                     WHERE r.cpdyear != '' AND r.cpdyear = '$search_year'
                     AND r.cpd_admincheck_status = '$search_approval' AND p.res_region = '$search_region'
                     ORDER BY r.period_registered DESC");
                    $count = mysqli_num_rows($query);
                }

            } //NONE
            else if ($search_region != "Any" && $search_approval != "Any" && $search_profession != "Any") {
                if ($search_approval == "Pending") {
                    $query = $mysqli->query("SELECT *
                     FROM renewal r
                     JOIN provisional p ON r.applicant_id = p.applicant_id
                     WHERE r.cpd_admincheck_status IS NULL
                     AND p.res_region = '$search_region' AND p.profession = '$search_profession'
                     AND r.cpdyear != '' AND r.cpdyear = '$search_year'
                     ORDER BY r.period_registered DESC");
                    $count = mysqli_num_rows($query);
                } else {
                    $query = $mysqli->query("SELECT *
                   FROM renewal r
                   JOIN provisional p ON r.applicant_id = p.applicant_id
                   WHERE p.profession = '$search_profession'
                   AND p.res_region = '$search_region' AND r.cpd_admincheck_status = '$search_approval'
                   AND  r.cpdyear != '' AND r.cpdyear = '$search_year'
                   ORDER BY r.period_registered DESC");
                    $count = mysqli_num_rows($query);
                }
            }
            ?>

            <div class="table-responsive">
            <table id="prov-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Profession</th>
                    <th>Telephone</th>
                    <th>Region</th>
                    <th>Period Registered</th>
                    <th>Payment Status</th>
                    <th>Approval Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($result = $query->fetch_assoc()) {
                    $applicant_id = $result['applicant_id'];
                    $lockid = lock($applicant_id);
                    ?>

                    <tr>
                        <td>
                            <a href="search_details.php?id=<?php echo $lockid; ?>">
                                <?php
                                $title = $result['title'];
                                if ($title == "Other") {
                                    $title = $result['othertitle'];
                                    echo $title . " " . $result["surname"] . " " . $result["first_name"] . " " . $result["other_name"];
                                } else {
                                    echo $title . " " . $result["surname"] . " " . $result["first_name"] . " " . $result["other_name"];
                                }
                                ?>
                            </a>
                        </td>
                        <td>
                            <?php echo $result['profession'] ?>
                        </td>
                        <td>
                            <?php echo $result['telephone'] ?>
                        </td>
                        <td>
                            <?php echo $result['res_region'] ?>
                        </td>
                        <td>
                            <?php $period = $result['period_registered'];
                            echo time_elapsed_string($period); ?>
                        </td>
                        <td>
                            <?php $paid = $result['payment'];
                            if ($paid == "1") {
                                echo "Paid";
                            } else {
                                echo "Not Paid";
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $approve = $result['cpd_admincheck_status'];
                            if ($approve == "") {
                                echo "Pending";
                            }
                            ?>
                        </td>
                    </tr>

                    <?php
                }

                ?>
                </tbody>
            </table>
                </div>
        </div>
    </div>

<?php echo "Total Records:" . '<b>' . $count . '</b>'; ?>


    <script>

        "use strict";
        var KTDatatablesExtensionButtons = {
            init: function () {
                var t;

                $('#prov-table').append('<caption style="caption-side: top">Provisional Registration Search ' +
                    'Results : <br/> <?php echo $search_year.' - '.$search_approval.' - '.$search_region.' - '.$search_profession ?></caption>');

                $("#prov-table").DataTable({
                    responsive: !0,
                    dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    buttons: ["print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"]
                }),
                    $("#export_print").on("click", function (e) {
                        e.preventDefault(), t.button(0).trigger()
                    }), $("#export_copy").on("click", function (e) {
                    e.preventDefault(), t.button(1).trigger()
                }), $("#export_excel").on("click", function (e) {
                    e.preventDefault(), t.button(2).trigger()
                }), $("#export_csv").on("click", function (e) {
                    e.preventDefault(), t.button(3).trigger()
                }), $("#export_pdf").on("click", function (e) {
                    e.preventDefault(), t.button(4).trigger()
                })
            }
        };
        jQuery(document).ready(function () {
            KTDatatablesExtensionButtons.init()
        });


    </script>


<?php
function time_elapsed_string($datetime, $full = false)
{
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

?>