<?php include('../../../config.php');

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$newenddate = date('Y-m-d', strtotime($end_date . ' + 1 day'));

$query = $mysqli->query("Select * from provisional where provisional_pin is not null 
                                  and permanent_registration = '1'
                          and permanent_date_approval BETWEEN '$start_date' 
                          AND '$newenddate' ORDER BY permanent_date_approval DESC");



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
                        <th>Title</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Other Name</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>PIN</th>
                        <th>Profession</th>
                        <th>Institution</th>
                        <th>Educational Level</th>
                        <th>Year Completed</th>
                        <th>Trainee type</th>
                        <th>Age</th>
                        <th>Contact Numbers</th>
                        <th>Address</th>
                        <th>District</th>
                        <th>Place of work</th>
                        <th>Card Pickup Point</th>
                        <th>Image</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($result = $query->fetch_assoc()) {
                        $applicant_id = $result['applicant_id'];
                    ?>
                        <tr>
                            <td>
                                <?php echo $result['title'] ?>
                            </td>
                            <td>
                                <?php echo $result['surname'] ?>
                            </td>
                            <td>
                                <?php echo $result['first_name'] ?>
                            </td>
                            <td>
                                <?php echo $result['other_name'] ?>
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
                                <?php $prpin = $result['professionid'];
                                $getprname = $mysqli->query("select * from professions where professionid = '$prpin'");
                                $resname = $getprname->fetch_assoc();
                                echo $resname['professionname']; ?>
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
                                <?php echo $result['acad_level'] ?>
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

                            </td>
                            <td>
                                <?php
                                //date in mm/dd/yyyy format; or it can be in other formats as well
                                $birthDate = $result['birth_date'];
                                //explode the date to get month, day and year
                                $birthDate = explode("-", $birthDate);
                                //get age from date or birthdate
                                $age = (date("dm", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("dm")
                                    ? ((date("Y") - $birthDate[0]) - 1)
                                    : (date("Y") - $birthDate[0]));
                                echo $age;
                                ?>
                            </td>
                            <td>
                            </td>
                            <td>
                                <?php echo $result['res_housenumber'] . ',' . $result['res_streetname'] . ',' . $result['res_locality']; ?>
                            </td>
                            <td>
                                <?php echo $result['contact_address'] ?>
                            </td>
                            <td>
                                <?php
                                $getwork = $mysqli->query("select * from applicant_experience where applicant_id = '$applicant_id' 
                        ORDER BY id DESC LIMIT 1");
                                $reswork = $getwork->fetch_assoc();
                                echo $reswork['institution'];
                                ?>
                            </td>
                            <td>
                                <?php echo $result['cardpp'] ?>
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

            $('#prov_table').append('<caption style="caption-side: top">Permanent Registration Pin Export between <?php echo $start_date; ?> and <?php echo $end_date ?> </caption>');

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