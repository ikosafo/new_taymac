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

    <div id="print_this">

    <div class="row">
        <div class="col-md-12" style="text-align: center;font-weight: bold">
            <h2>ALLIED HEALTH PROFESSIONS COUNCIL</h2>
        </div>
    </div>

    <hr class="dashed">

    <div class="row">
        <div class="col-md-3">
            PERMANENT REGISTRATIONS FOR <b><?php echo $search_year ?></b>
        </div>
        <div class="col-md-3">
            PROFESSION: <b><?php echo $search_profession ?></b>
        </div>
        <div class="col-md-3">
            STATUS: <b><?php echo $search_approval ?></b>
        </div>
        <div class="col-md-3">
            REGION: <b><?php echo $search_region ?></b>
        </div>
    </div>


    <div class="kt-separator kt-separator--dashed"></div>

    <div class="kt-section">

        <div class="kt-section__content responsive">

            <?php

            //ALL
            if ($search_year == "All" && $search_region == "Any" && $search_approval == "Any" && $search_profession == "Any") {
                $query = $mysqli->query("select * from provisional where permanent_registration = '1' ORDER BY professionid,permanent_period DESC");
                $count = mysqli_num_rows($query);
            }

            //ALL THREE
            else if ($search_region == "Any" && $search_approval == "Any" && $search_profession == "Any") {
                $query = $mysqli->query("select * from provisional where SUBSTRING(permanent_period,1,4) = '$search_year'
ORDER BY professionid,permanent_period DESC");
                $count = mysqli_num_rows($query);
            }

            //TWO's
            //Approval and Profession
            else if ($search_approval == "Any" && $search_profession == "Any") {
                $query = $mysqli->query("select * from provisional where SUBSTRING(permanent_period,1,4) = '$search_year'
AND res_region = '$search_region' ORDER BY professionid,permanent_period DESC");
                $count = mysqli_num_rows($query);
            } //Region and Profession
            else if ($search_region == "Any" && $search_profession == "Any") {
                if ($search_approval == "Pending") {
                    $query = $mysqli->query("select * from provisional where SUBSTRING(permanent_period,1,4) = '$search_year'
AND permanent_admincheck_status IS NULL ORDER BY professionid,permanent_period DESC");
                    $count = mysqli_num_rows($query);
                } else {
                    if ($search_year == "All") {
                        $query = $mysqli->query("select * from provisional where permanent_admincheck_status = '$search_approval'
ORDER BY professionid,permanent_period DESC");
                        $count = mysqli_num_rows($query);
                    }
                    else {
                        $query = $mysqli->query("select * from provisional where SUBSTRING(permanent_period,1,4) = '$search_year'
AND permanent_admincheck_status = '$search_approval' ORDER BY professionid,permanent_period DESC");
                        $count = mysqli_num_rows($query);
                    }

                }
            } //Approval and Region
            else if ($search_region == "Any" && $search_approval == "Any") {
                $query = $mysqli->query("select * from provisional where
SUBSTRING(permanent_period,1,4) = '$search_year' AND profession = '$search_profession'
ORDER BY professionid,permanent_period DESC");
                $count = mysqli_num_rows($query);
            } //ONE's
            else if ($search_region == "Any") {
                if ($search_approval == "Pending") {
                    $query = $mysqli->query("select * from provisional where
SUBSTRING(permanent_period,1,4) = '$search_year'
AND profession = '$search_profession' AND permanent_admincheck_status IS NULL
ORDER BY professionid,permanent_period DESC");
                    $count = mysqli_num_rows($query);
                }
                else {
                    $query = $mysqli->query("select * from provisional where
SUBSTRING(permanent_period,1,4) = '$search_year'
AND profession = '$search_profession' AND permanent_admincheck_status = '$search_approval'
ORDER BY professionid,permanent_period DESC");
                    $count = mysqli_num_rows($query);
                }
            } else if ($search_approval == "Any") {
                $query = $mysqli->query("select * from provisional where SUBSTRING(permanent_period,1,4) = '$search_year'
AND profession = '$search_profession' AND res_region = '$search_region'
ORDER BY professionid,permanent_period DESC");
                $count = mysqli_num_rows($query);
            } else if ($search_profession == "Any") {
                if ($search_approval == "Pending") {
                    $query = $mysqli->query("select * from provisional where SUBSTRING(permanent_period,1,4) = '$search_year'
AND permanent_admincheck_status IS NULL AND res_region = '$search_region'
ORDER BY professionid,permanent_period DESC");
                    $count = mysqli_num_rows($query);
                } else {
                    $query = $mysqli->query("select * from provisional where SUBSTRING(permanent_period,1,4) = '$search_year'
AND permanent_admincheck_status = '$search_approval' AND res_region = '$search_region'
ORDER BY professionid,permanent_period DESC");
                    $count = mysqli_num_rows($query);
                }

            } //NONE
            else if ($search_region != "Any" && $search_approval != "Any" && $search_profession != "Any") {
                if ($search_approval == "Pending") {
                    $query = $mysqli->query("select * from provisional where permanent_admincheck_status IS NULL
 AND res_region = '$search_region' AND profession = '$search_profession'
 AND SUBSTRING(permanent_period,1,4) = '$search_year'
ORDER BY professionid,permanent_period DESC");
                    $count = mysqli_num_rows($query);
                } else {
                    $query = $mysqli->query("select * from provisional where profession = '$search_profession'
 AND res_region = '$search_region' AND permanent_admincheck_status = '$search_approval' AND  SUBSTRING(permanent_period,1,4) = '$search_year'
ORDER BY professionid,permanent_period DESC");
                    $count = mysqli_num_rows($query);
                }
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