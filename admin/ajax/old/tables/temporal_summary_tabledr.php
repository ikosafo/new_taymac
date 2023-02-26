<?php include('../../../config.php');
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$newenddate = date('Y-m-d', strtotime($end_date. ' + 1 day'));
$search_region = $_POST['search_region'];
$search_profession = $_POST['search_profession'];
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];
?>

<div id="print_this">

    <div class="row">
        <div class="col-md-12" style="text-align: center;font-weight: bold">
            <h2>ALLIED HEALTH PROFESSIONS COUNCIL</h2>
        </div>
    </div>

    <hr class="dashed">

    <div class="row">
        <div class="col-md-6">
            TEMPORAL REGISTRATIONS BETWEEN <b><?php echo $start_date ?></b> AND <b><?php echo $end_date ?></b>
        </div>
        <div class="col-md-3">
            PROFESSION: <b><?php echo $search_profession ?></b>
        </div>
        <div class="col-md-3">
            REGION: <b><?php echo $search_region ?></b>
        </div>
    </div>


    <div class="kt-separator kt-separator--dashed"></div>

    <div class="kt-section">

        <div class="kt-section__content responsive">

            <?php

            //TWO's
            if ($search_region == "Any" && $search_profession == "Any") {
                $query = $mysqli->query("SELECT * FROM provisional WHERE temporal_registration = '1'
                                        AND temporal_date_approval BETWEEN '$start_date' AND '$newenddate'
                    ORDER BY temporal_date_approval DESC,professionid,temporal_period DESC");
                $count = mysqli_num_rows($query);
            }

            else if ($search_region == "Any") {
                $query = $mysqli->query("SELECT * FROM provisional WHERE profession = '$search_profession'
                                        AND temporal_registration = '1'
                                        AND temporal_date_approval BETWEEN '$start_date' AND '$newenddate'
                    ORDER BY temporal_date_approval DESC,professionid,temporal_period DESC");
                $count = mysqli_num_rows($query);
            }
            else if ($search_profession == "Any") {
                $query = $mysqli->query("SELECT * FROM provisional WHERE res_region = '$search_region'
                                        AND temporal_registration = '1'
                                        AND temporal_date_approval BETWEEN '$start_date' AND '$newenddate'
                    ORDER BY temporal_date_approval DESC,professionid,temporal_period DESC");
                $count = mysqli_num_rows($query);
            }
            else {
                $query = $mysqli->query("SELECT * FROM provisional WHERE res_region = '$search_region'
                                        AND profession = '$search_profession'
                                        AND temporal_registration = '1'
                                        AND temporal_date_approval BETWEEN '$start_date' AND '$newenddate'
                    ORDER BY temporal_date_approval DESC,professionid,temporal_period DESC");
                $count = mysqli_num_rows($query);
            }


            ?>


        </div>
    </div>

    <?php   echo "Total Records:".'<b>'.$count.'</b>'; ?>

    <hr/>
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
                        text-align: center !important;">PIN
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
                            $img = $mysqli->query("select * from applicant_images where applicant_id = '$applicant_id'");
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
                            <?php echo $result['provisional_pin'] ?>
                        </td>
                        <td></td>
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
                NUMBER OF APPLICANTS
            </div>
            <div class="col-md-7">
                <?php echo $count;  ?>
            </div>
        </div>

        <hr class="dashed">

        <div class="row">
            <div class="col-md-2">
                MIS ADMIN
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
                SUPER ADMIN
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