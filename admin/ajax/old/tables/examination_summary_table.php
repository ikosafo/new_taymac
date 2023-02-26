<?php include('../../../config.php');

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$search_center = $_POST['search_center'];
$search_approval = $_POST['search_approval'];
$search_profession = $_POST['search_profession'];
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];

?>
<style>
    ul {
        list-style-type: none;
    }

    td {
        text-transform: uppercase !important;
        text-align: center !important;
    }

    th {
        text-transform: uppercase !important;
        text-align: center !important;
    }

</style>

<script>
    function printContent(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
        location.reload();
    }
</script>


<div id="print_this">

    <div class="row">
        <div class="col-md-12" style="text-align: center;font-weight: bold">
            ALLIED HEALTH PROFESSIONS COUNCIL
        </div>
    </div>

    <hr class="dashed">

    <div class="row">
        <div class="col-md-4">
            EXAM BETWEEN <b><?php echo $start_date ?> AND <?php echo $end_date ?></b>
        </div>
        <div class="col-md-4">
            PROFESSION: <b><?php echo $search_profession ?></b>
        </div>
        <div class="col-md-2">
            VENUE: <b><?php echo $search_center ?></b>
        </div>
        <div class="col-md-2">
            STATUS: <b><?php echo $search_approval ?></b>
        </div>
    </div>

    <hr class="dashed">

    <?php

    //ALL THREE
    if ($search_center == "Any" && $search_approval == "Any" && $search_profession == "Any") {
        $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
ORDER BY professionid,surname,first_name,other_name,provisional_period DESC");
        $count = mysqli_num_rows($query);
    }

    //TWO's
    //Approval and Profession
    else if ($search_approval == "Any" && $search_profession == "Any") {
        $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
AND exam_center = '$search_center' ORDER BY professionid,surname,first_name,other_name,provisional_period DESC");
        $count = mysqli_num_rows($query);
    } //Region and Profession
    else if ($search_center == "Any" && $search_profession == "Any") {
        if ($search_approval == "Pending") {
            $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
AND exam_admincheck_status IS NULL ORDER BY professionid,surname,first_name,other_name,provisional_period DESC");
            $count = mysqli_num_rows($query);
        } else {
            $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
AND exam_admincheck_status = '$search_approval' ORDER BY professionid,surname,first_name,other_name,provisional_period DESC");
            $count = mysqli_num_rows($query);
        }
    } //Approval and Region
    else if ($search_center == "Any" && $search_approval == "Any") {
        $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where
e.period_registered BETWEEN '$start_date' AND '$end_date' AND profession = '$search_profession'
ORDER BY professionid,surname,first_name,other_name,provisional_period DESC");
        $count = mysqli_num_rows($query);
    } //ONE's
    else if ($search_center == "Any") {
        if ($search_approval == "Pending") {
            $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where
e.period_registered BETWEEN '$start_date' AND '$end_date'
AND profession = '$search_profession' AND exam_admincheck_status IS NULL
ORDER BY professionid,surname,first_name,other_name,provisional_period DESC");
            $count = mysqli_num_rows($query);
        } else {
            $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where
e.period_registered BETWEEN '$start_date' AND '$end_date'
AND profession = '$search_profession' AND exam_admincheck_status = '$search_approval'
ORDER BY professionid,surname,first_name,other_name,provisional_period DESC");
            $count = mysqli_num_rows($query);
        }
    } else if ($search_approval == "Any") {
        $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
AND profession = '$search_profession' AND exam_center = '$search_center'
ORDER BY professionid,surname,first_name,other_name,provisional_period DESC");
        $count = mysqli_num_rows($query);
    } else if ($search_profession == "Any") {
        if ($search_approval == "Pending") {
            $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
AND exam_admincheck_status IS NULL AND exam_center = '$search_center'
ORDER BY professionid,surname,first_name,other_name,provisional_period DESC");
            $count = mysqli_num_rows($query);
        } else {
            $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where e.period_registered BETWEEN '$start_date' AND '$end_date'
AND exam_admincheck_status = '$search_approval' AND exam_center = '$search_center'
ORDER BY professionid,surname,first_name,other_name,provisional_period DESC");
            $count = mysqli_num_rows($query);
        }

    } //NONE
    else if ($search_center != "Any" && $search_approval != "Any" && $search_profession != "Any") {
        if ($search_approval == "Pending") {
            $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where exam_admincheck_status IS NULL
 AND exam_center = '$search_center' AND profession = '$search_profession'
 AND e.period_registered BETWEEN '$start_date' AND '$end_date'
ORDER BY professionid,surname,first_name,other_name,provisional_period DESC");
            $count = mysqli_num_rows($query);
        } else {
            $query = $mysqli->query("select * from examination_reg e JOIN
provisional p ON e.applicant_id = p.applicant_id where profession = '$search_profession'
 AND exam_center = '$search_center' AND exam_admincheck_status = '$search_approval'
 AND  e.period_registered BETWEEN '$start_date' AND '$end_date'
ORDER BY professionid,surname,first_name,other_name,provisional_period DESC");
            $count = mysqli_num_rows($query);
        }
    }
    ?>

    <div class="card-body" style="margin-top:-25px !important">
        <div class="table-responsive">
        <table id="examination_reg" class="table table-bordered table-responsive"
               style="width:100% !important;">
            <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="25%">PHOTO</th>
                <th width="35%"
                    style="text-transform: uppercase !important;
                        text-align: center !important;">FULL NAME
                </th>
                <th width="15%"
                    style="text-transform: uppercase !important;
                        text-align: center !important;">INDEX NO.
                </th>
                <th width="20%">SIGNATURE</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $counter = 1;
            while ($result = $query->fetch_assoc()) {
                $applicant_id = $result['applicant_id'];
                ?>
                <tr>
                    <td>
                        <?php echo $counter; ?>
                    </td>
                    <td>
                        <?php
                        $img = $mysqli->query("select * from applicant_images
                                                      where applicant_id = '$applicant_id'");

                        $fetch_img = $img->fetch_assoc() ?>


                        <div class="profile-image"><img
                                src="<?php echo $reg_root . '/' . $fetch_img['image_location'] ?>"
                                alt="" style="width: 200px !important;height: 200px !important;">
                        </div>
                    </td>
                    <td style="text-transform: uppercase !important;
                        text-align: center !important;font-size: large">
                        <?php echo $result['surname'] . ' ' . $result['first_name'] . ' ' . $result['other_name'] ?>
                    </td>
                    <td style="text-transform: uppercase !important;
                        text-align: center !important;font-size: large">
                        <?php echo $result['exam_index_number'] ?>
                    </td>
                    <td>

                    </td>

                </tr>

                <?php
                $counter++;
            } ?>
            </tbody>
            <tfoot>
        </table>
            </div>

        <hr class="dashed">

        <div class="row">
            <div class="col-md-5">
                NUMBER OF CANDIDATES REGISTERED
            </div>
            <div class="col-md-7">
                <?php echo $count;  ?>
            </div>
        </div>

        <hr class="dashed">

        <div class="row">
            <div class="col-md-5">
                NUMBER OF CANDIDATES PRESENT
            </div>
            <div class="col-md-7">

            </div>
        </div>

        <hr class="dashed">

        <div class="row">
            <div class="col-md-5">
                NUMBER OF CANDIDATES ABSENT
            </div>
            <div class="col-md-7">

            </div>
        </div>

        <hr class="dashed">

        <div class="row">
            <div class="col-md-2">
                NAME OF INVIGILATOR
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-2">
                SIGNATURE
            </div>
            <div class="col-md-4">

            </div>
        </div>

        <hr class="dashed">

        <div class="row">
            <div class="col-md-2">
                NAME OF CHIEF INVIGILATOR
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-2">
                SIGNATURE
            </div>
            <div class="col-md-4">

            </div>
        </div>

        <hr class="dashed">

        <div class="row">
            <div class="col-md-2">
                DATE
            </div>
            <div class="col-md-10">

            </div>
        </div>

        <hr class="dashed">

    </div>

</div>


<div class="bg-light">
    <button class="btn btn-primary pull-right m-t-20 m-b-20"
            onclick="printContent('print_this')"><i class="icon-printer"></i> Print Form
    </button>
</div>

<script>
    /*$('#examination_reg').DataTable({
     "scrollY":        "400px",
     "scrollCollapse": true,
     "paging":         false
     });*/
</script>


