<?php include('../../../config.php');

//$year_search = $_POST['search_year'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$search_center = $_POST['search_center'];
$search_approval = $_POST['search_approval'];
$search_profession = $_POST['search_profession'];
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];


if ($search_center == "Any" && $search_approval == "Any" && $search_profession == "Any") {
    $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
ORDER BY p.professionid,p.surname,p.first_name,p.other_name,e.period_registered DESC");
    $count = mysqli_num_rows($query);
}

//TWO's
//Approval and Profession
else if ($search_approval == "Any" && $search_profession == "Any") {
    $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
AND exam_center = '$search_center' ORDER BY p.professionid,p.surname,p.first_name,p.other_name,e.period_registered DESC");
    $count = mysqli_num_rows($query);
} //Region and Profession
else if ($search_center == "Any" && $search_profession == "Any") {
    if ($search_approval == "Pending") {
        $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
AND exam_admincheck_status IS NULL ORDER BY p.professionid,p.surname,p.first_name,p.other_name,e.period_registered DESC");
        $count = mysqli_num_rows($query);
    } else {
        $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
AND exam_admincheck_status = '$search_approval' ORDER BY p.professionid,p.surname,p.first_name,p.other_name,e.period_registered DESC");
        $count = mysqli_num_rows($query);
    }
} //Approval and Region
else if ($search_center == "Any" && $search_approval == "Any") {
    $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where
e.period_registered BETWEEN '$start_date' AND '$end_date' AND profession = '$search_profession'
ORDER BY p.professionid,p.surname,p.first_name,p.other_name,e.period_registered DESC");
    $count = mysqli_num_rows($query);
} //ONE's
else if ($search_center == "Any") {
    if ($search_approval == "Pending") {
        $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where
e.period_registered BETWEEN '$start_date' AND '$end_date'
AND profession = '$search_profession' AND exam_admincheck_status IS NULL
ORDER BY p.professionid,p.surname,p.first_name,p.other_name,e.period_registered DESC");
        $count = mysqli_num_rows($query);
    } else {
        $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where
e.period_registered BETWEEN '$start_date' AND '$end_date'
AND profession = '$search_profession' AND exam_admincheck_status = '$search_approval'
ORDER BY p.professionid,p.surname,p.first_name,p.other_name,e.period_registered DESC");
        $count = mysqli_num_rows($query);
    }
} else if ($search_approval == "Any") {
    $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
AND profession = '$search_profession' AND exam_center = '$search_center'
ORDER BY p.professionid,p.surname,p.first_name,p.other_name,e.period_registered DESC");
    $count = mysqli_num_rows($query);
} else if ($search_profession == "Any") {
    if ($search_approval == "Pending") {
        $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
AND exam_admincheck_status IS NULL AND exam_center = '$search_center'
ORDER BY p.professionid,p.surname,p.first_name,p.other_name,e.period_registered DESC");
        $count = mysqli_num_rows($query);
    } else {
        $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
AND exam_admincheck_status = '$search_approval' AND exam_center = '$search_center'
ORDER BY p.professionid,p.surname,p.first_name,p.other_name,e.period_registered DESC");
        $count = mysqli_num_rows($query);
    }

} //NONE
else if ($search_center != "Any" && $search_approval != "Any" && $search_profession != "Any") {
    if ($search_approval == "Pending") {
        $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where exam_admincheck_status IS NULL
 AND exam_center = '$search_center' AND profession = '$search_profession'
 AND e.period_registered BETWEEN '$start_date' AND '$end_date'
ORDER BY p.professionid,p.surname,p.first_name,p.other_name,e.period_registered DESC");
        $count = mysqli_num_rows($query);
    } else {
        $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where profession = '$search_profession'
 AND exam_center = '$search_center' AND exam_admincheck_status = '$search_approval'
 AND  e.period_registered BETWEEN '$start_date' AND '$end_date'
ORDER BY p.professionid,p.surname,p.first_name,p.other_name,e.period_registered DESC");
        $count = mysqli_num_rows($query);
    }
}

 /*   $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
ORDER BY p.professionid,p.surname,p.first_name,p.other_name,e.period_registered DESC");*/




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
                        <th width="5%">NO.</th>
                        <th width="10%">TITLE</th>
                        <th width="15%">FULL NAME</th>
                        <th width="10%">TELEPHONE</th>
                        <th width="10%">EMAIL ADDRESS</th>
                        <th width="10%">INDEX NUMBER</th>
                        <th width="10%">PROFESSION</th>
                        <th width="20%">DETAILS</th>
                        <th width="10%">INSTITUTION</th>
                        <th width="10%">CENTER</th>
                        <th width="10%">STATUS</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $counter = 1;
                while ($result = $query->fetch_assoc()){
                    $applicant_id = $result['applicant_id'];
                    ?>
                    <tr>
                        <td>
                            <?php echo $counter; ?>
                        </td>
                        <td>
                            <?php echo $result['title'] ?>
                        </td>
                        <td>
                            <?php echo $result['surname'].' '.$result['first_name'].' '.$result['other_name'] ?>
                        </td>
                        <td>
                            <?php echo $result['telephone'] ?>
                        </td>
                        <td>
                            <?php echo $result['email_address'] ?>
                        </td>
                        <td>
                            <?php echo $result['exam_index_number'] ?>
                        </td>
                        <td>
                            <?php $prpin = $result['professionid'];
                            $getprname = $mysqli->query("select * from professions where professionid = '$prpin'");
                            $resname = $getprname->fetch_assoc();
                            echo $resname['professionname'];?>
                        </td>
                        <td>
                            <span class="kt-widget31__info">Internship Period: </span>
                            <span class="kt-widget31__text" style="font-weight:300;font-size:0.9rem"><?php echo $result['internship_period']?></span><br/>
                            <span class="kt-widget31__info">Facility: </span>
                        <span class="kt-widget31__text" style="font-weight:300;font-size:0.9rem">
                            <?php echo $result['facility']?></span><br/>
                            <span class="kt-widget31__info">Previous Exam: </span>
                        <span class="kt-widget31__text" style="font-weight:300;font-size:0.9rem">
                            <?php echo $result['previous_exam']?></span><br/>
                            <span class="kt-widget31__info">Exam Attempts: </span>
                        <span class="kt-widget31__text" style="font-weight:300;font-size:0.9rem">
                            <?php echo $result['exam_attempts']?></span><br/>
                        </td>
                        <td>
                            <?php
                            $getin = $mysqli->query("select * from applicant_institutions where applicant_id = '$applicant_id'");
                            while ($resin = $getin->fetch_assoc()){
                                echo $resin['institution_name'].",";
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $result['exam_center']?>
                        </td>
                        <td>
                            <?php
                               $status = $result['exam_admincheck_status'];
                            if ($status == "") {
                                echo 'Pending';
                            }
                            else {
                                echo $status;
                            }
                            ?>

                        </td>
                    </tr>
                <?php $counter++; } ?>
                </tbody>


            </table>
        </div>
    </div>
</div>

<script>

    "use strict";
    var KTDatatablesExtensionButtons = {
        init: function () {
            var year_search = '<?php echo $start_date ?>';
            var t;

            if (year_search == 'All') {
                $('#prov_table').append('<caption style="caption-side: top">Licensure Examination Registration Pin Export for all years</caption>');
            }
            else {
                $('#prov_table').append('<caption style="caption-side: top">Licensure Examination Registration Pin Export for the year <?php echo $start_date ?></caption>');
            }

            $("#prov_table").DataTable({
                responsive: !0,
                dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                buttons: ["print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
                columnDefs: [{
                    targets: 6, render: function (t, e, a, n) {
                        var s = {
                            1: {title: "Pending", class: "kt-badge--brand"},
                            2: {title: "Delivered", class: " kt-badge--danger"},
                            3: {title: "Canceled", class: " kt-badge--primary"},
                            4: {title: "Success", class: " kt-badge--success"},
                            5: {title: "Info", class: " kt-badge--info"},
                            6: {title: "Danger", class: " kt-badge--danger"},
                            7: {title: "Warning", class: " kt-badge--warning"}
                        };
                        return void 0 === s[t] ? t : '<span class="kt-badge ' + s[t].class + ' kt-badge--inline kt-badge--pill">' + s[t].title + "</span>"
                    }
                }, {
                    targets: 7, render: function (t, e, a, n) {
                        var s = {
                            1: {title: "Online", state: "danger"},
                            2: {title: "Retail", state: "primary"},
                            3: {title: "Direct", state: "success"}
                        };
                        return void 0 === s[t] ? t : '<span class="kt-badge kt-badge--' + s[t].state + ' kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-' + s[t].state + '">' + s[t].title + "</span>"
                    }
                }]
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

