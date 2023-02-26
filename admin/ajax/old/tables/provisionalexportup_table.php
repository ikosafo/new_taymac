<?php include('../../../config.php');

$year_search = $_POST['select_year'];

if ($year_search == 'All') {
    $query = $mysqli->query("Select * from registration_upgrades where (registration_type = 'provisional_upgrade' or registration_type = 'PROVISIONAL(UPGRADE)')");
} else {
    $query = $mysqli->query("Select * from registration_upgrades where (registration_type = 'provisional_upgrade' or registration_type = 'PROVISIONAL(UPGRADE)')
    AND SUBSTRING(date_requested,1,4) = '$year_search'");
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
                        <th>Current Profession</th>
                        <th>New Profession</th>
                        <th>Current Qualification</th>
                        <th>New Qualification</th>
                        <th>Institution Attended</th>
                        <th>Period Attended</th>
                        <th>Current Certificate</th>
                        <th>New Certificate</th>
                        <th>Certificate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($result = $query->fetch_assoc()) {
                    ?>
                        <tr>
                            <td>
                                <?php $applicant_id = $result['applicant_id'];
                                $getfullname = $mysqli->query("select * from provisional where applicant_id = '$applicant_id'");
                                $resfullname = $getfullname->fetch_assoc();
                                echo $resfullname['surname'] . ' ' . $resfullname['first_name'] . ' ' . $resfullname['other_name'];
                                ?>
                            </td>
                            <td>
                                <?php echo $resfullname['email_address']; ?>
                            </td>
                            <td>
                                <?php $cpro = $result['current_profession'];
                                $getproid = $mysqli->query("select * from professions where professionid = '$cpro'");
                                $resproid = $getproid->fetch_assoc();
                                echo $resproid['professionname'];
                                ?>
                            </td>
                            <td><?php $npro =  $result['new_profession'];
                                $getproid = $mysqli->query("select * from professions where professionid = '$npro'");
                                $resproid = $getproid->fetch_assoc();
                                echo $resproid['professionname'];
                                ?>
                            </td>
                            <td><?php echo $result['current_qualification'] ?></td>
                            <td><?php echo $result['new_qualification'] ?></td>
                            <td><?php echo $result['institution_attended'] ?></td>
                            <td><?php echo $result['date_started'] . ' - ' . $result['date_completed'] ?></td>
                            <td><?php echo $result['certificate'] ?></td>
                            <td><?php echo $result['certificate_new'] ?></td>
                            <td>
                                <?php
                                $file_id = $result['doc_id'];
                                $getimg = $mysqli->query("select * from applicant_certificates where qualification_id = '$file_id'");
                                $resimg = $getimg->fetch_assoc();
                                ?>
                                <a href="<?php echo $reg_root . '/' . $resimg['image_location'] ?>">
                                    Click to view
                                </a>

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
            var year_search = '<?php echo $year_search ?>';
            var t;

            if (year_search == 'All') {
                $('#prov_table').append('<caption style="caption-side: top">Provisional Registration Upgrade Export for all years</caption>');
            } else {
                $('#prov_table').append('<caption style="caption-side: top">Provisional Registration Upgrade Export for the year <?php echo $year_search ?></caption>');
            }

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