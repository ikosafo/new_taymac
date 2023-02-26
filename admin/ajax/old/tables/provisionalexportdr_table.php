<?php include('../../../config.php');

$search_status = $_POST['search_status'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$newenddate = date('Y-m-d', strtotime($end_date . ' + 1 day'));

if ($search_status == 'Any') {
    $query = $mysqli->query("Select * from provisional where provisional_pin is not null and provisional_registration = '1'
                          and provisional_period BETWEEN '$start_date' AND '$newenddate' ORDER BY provisional_period DESC");
} else if ($search_status == 'Approved') {
    $query = $mysqli->query("Select * from provisional where provisional_pin is not null and provisional_registration = '1'
                          and provisional_admincheck_status = 'Approved'
                          and provisional_period BETWEEN '$start_date' AND '$newenddate' ORDER BY provisional_period DESC");
} else if ($search_status == 'Rejected') {
    $query = $mysqli->query("Select * from provisional where provisional_registration = '1'
                          and (provisional_admincheck_status = 'Rejected' or provisional_usercheck_status = 'Rejected')
                          and provisional_period BETWEEN '$start_date' AND '$newenddate' ORDER BY provisional_period DESC");
} else {
    $query = $mysqli->query("Select * from provisional where provisional_pin is not null and provisional_registration = '1'
                          and (provisional_admincheck_status IS NULL or provisional_usercheck_status IS NULL)
                          and provisional_period BETWEEN '$start_date' AND '$newenddate' ORDER BY provisional_period DESC");
}





?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>

<div class="kt-separator kt-separator--dashed"></div>

<div class="kt-section">

    `
    <div class="kt-section__content responsive">


        <div class="table-responsive">
            <table class="table" id="prov_table">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Telephone</th>
                        <th>PIN</th>
                        <th>Index Numebr</th>
                        <th>Profession</th>
                        <th>MIS Admin<br /> Approval</th>
                        <th>Super Admin<br /> Approved</th>
                        <th>Institution</th>
                        <th>Year Completed</th>
                        <th>Image</th>
                        <th>Date Approved</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($result = $query->fetch_assoc()) {
                        $applicant_id = $result['applicant_id'];
                    ?>
                        <tr>
                            <td>
                                <?php echo $result['title'] . ' ' . $result['surname'] . ' ' . $result['first_name'] . ' ' . $result['other_name']; ?>
                            </td>
                            <td>
                                <?php echo $result['email_address'] ?>
                            </td>
                            <td>
                                <?php echo $result['telephone'] ?>
                            </td>
                            <td>
                                <?php echo $result['provisional_pin'] ?>
                            </td>
                            <td>
                                <?php echo $result['exam_index_number'] ?>
                            </td>
                            <td>
                                <?php $prpin = $result['professionid'];
                                $getprname = $mysqli->query("select * from professions where professionid = '$prpin'");
                                $resname = $getprname->fetch_assoc();
                                echo $resname['professionname']; ?>
                            </td>
                            <td>
                                <?php
                                $superapproval = $result['provisional_usercheck_status'];
                                if ($superapproval == "Approved") {
                                    echo '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
                                } else if ($superapproval == "Rejected") {
                                    echo '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
                                } else {
                                    echo '<span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Pending</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $superapproval = $result['provisional_admincheck_status'];
                                if ($superapproval == "Approved") {
                                    echo '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
                                } else if ($superapproval == "Rejected") {
                                    echo '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Rejected</span>';
                                } else {
                                    echo '<span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Pending</span>';
                                }
                                ?>

                            </td>
                            <td>
                                <?php
                                $getin = $mysqli->query("select * from applicant_institutions where applicant_id = '$applicant_id'");
                                while ($resin = $getin->fetch_assoc()) {
                                    echo $resin['institution_name'] . ",";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $getyear = $mysqli->query("select * from applicant_institutions where 
                                applicant_id = '$applicant_id' ORDER BY institutionid DESC limit 1");
                                $resyear = $getyear->fetch_assoc();
                                echo $resyear['date_ended'];
                                ?>
                            </td>
                            <td>
                                <?php
                                $getimg = $mysqli->query("select * from applicant_images where applicant_id = '$applicant_id'");
                                $resimg = $getimg->fetch_assoc();
                                ?>
                                <a href="../<?php echo $resimg['image_location'] ?>">
                                    Click to view
                                </a>
                            </td>
                            <td>
                                <?php echo $result['provisional_date_approval'] ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>


            </table>
        </div>
    </div>
</div>

<script>
    "use strict";
    var KTDatatablesExtensionButtons = {
        init: function() {

            var t;

            $('#prov_table').append('<caption style="caption-side: top">Provisional Registration Pin Export between <?php echo $start_date; ?> and <?php echo $end_date ?> </caption>');

            $("#prov_table").DataTable({
                    responsive: !0,
                    dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    buttons: ["print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
                    columnDefs: [{
                        targets: 6,
                        render: function(t, e, a, n) {
                            var s = {
                                1: {
                                    title: "Pending",
                                    class: "kt-badge--brand"
                                },
                                2: {
                                    title: "Delivered",
                                    class: " kt-badge--danger"
                                },
                                3: {
                                    title: "Canceled",
                                    class: " kt-badge--primary"
                                },
                                4: {
                                    title: "Success",
                                    class: " kt-badge--success"
                                },
                                5: {
                                    title: "Info",
                                    class: " kt-badge--info"
                                },
                                6: {
                                    title: "Danger",
                                    class: " kt-badge--danger"
                                },
                                7: {
                                    title: "Warning",
                                    class: " kt-badge--warning"
                                }
                            };
                            return void 0 === s[t] ? t : '<span class="kt-badge ' + s[t].class + ' kt-badge--inline kt-badge--pill">' + s[t].title + "</span>"
                        }
                    }, {
                        targets: 7,
                        render: function(t, e, a, n) {
                            var s = {
                                1: {
                                    title: "Online",
                                    state: "danger"
                                },
                                2: {
                                    title: "Retail",
                                    state: "primary"
                                },
                                3: {
                                    title: "Direct",
                                    state: "success"
                                }
                            };
                            return void 0 === s[t] ? t : '<span class="kt-badge kt-badge--' + s[t].state + ' kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-' + s[t].state + '">' + s[t].title + "</span>"
                        }
                    }]
                }),
                $("#export_print").on("click", function(e) {
                    e.preventDefault(), t.button(0).trigger()
                }), $("#export_copy").on("click", function(e) {
                    e.preventDefault(), t.button(1).trigger()
                }), $("#export_excel").on("click", function(e) {
                    e.preventDefault(), t.button(2).trigger()
                }), $("#export_csv").on("click", function(e) {
                    e.preventDefault(), t.button(3).trigger()
                }), $("#export_pdf").on("click", function(e) {
                    e.preventDefault(), t.button(4).trigger()
                })
        }
    };
    jQuery(document).ready(function() {
        KTDatatablesExtensionButtons.init()
    });
</script>