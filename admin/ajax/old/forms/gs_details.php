<?php include('../../../config.php');

$pin = $_POST['pin'];
$getdetails = $mysqli->query("select * from provisional where provisional_pin = '$pin'");
$resdetails = $getdetails->fetch_assoc();
$applicant_id = $resdetails['applicant_id'];

//Good standing calculation
$permanent_registration = $resdetails['permanent_registration'];
$provisional_registration = $resdetails['provisional_registration'];

if ($permanent_registration == '1') {
    $period_registered = $resdetails['period_registered'];
    $year_registered = substr($period_registered, 0, 4);
    if ($year_registered == date('Y')) {
        $approvedreg = $resdetails['permanent_admincheck_status'];
        if ($approvedreg == 'Approved') {
            $good_standing_status = 1;
        } else {
            $good_standing_status = 0;
        }
    } else {
        //Check for renewal
        $getrenewaldetails = $mysqli->query("select * from renewal where applicant_id = '$applicant_id' ORDER BY renewal_id DESC LIMIT 1");
        $resrenewaldetails = $getrenewaldetails->fetch_assoc();
        $cpdyear = $resrenewaldetails['cpdyear'];
        $getmonth = date('m');
        if ($getmonth > 9) {
            $cpdyearnext = date('Y') + 1;
            if ($cpdyear == $cpdyearnext) {
                $cpdapprovedreg = $resrenewaldetails['cpd_admincheck_status'];
                if ($cpdapprovedreg == 'Approved') {
                    $good_standing_status = 1;
                } else {
                    $good_standing_status = 0;
                }
            } else {
                $good_standing_status = 0;
            }
        } else {
            $cpdyearcur = date('Y');
            if ($cpdyear == $cpdyearcur) {
                $cpdapprovedreg = $resrenewaldetails['cpd_admincheck_status'];
                if ($cpdapprovedreg == 'Approved') {
                    $good_standing_status = 1;
                } else {
                    $good_standing_status = 0;
                }
            } else {
                $good_standing_status = 0;
            }
        }
    }
} else if ($provisional_registration == '1') {
    $approvedprovreg = $resdetails['provisional_admincheck_status'];
    if ($approvedprovreg == 'Approved') {
        $good_standing_status = 2;
    } else {
        $good_standing_status = 0;
    }
} else {
    //Check for renewal
    $getrenewaldetails = $mysqli->query("select * from renewal where applicant_id = '$applicant_id' ORDER BY renewal_id DESC LIMIT 1");
    $resrenewaldetails = $getrenewaldetails->fetch_assoc();
    $cpdyear = $resrenewaldetails['cpdyear'];
    $getmonth = date('m');
    if ($getmonth > 9) {
        $cpdyearnext = date('Y') + 1;
        if ($cpdyear == $cpdyearnext) {
            $cpdapprovedreg = $resrenewaldetails['cpd_admincheck_status'];
            if ($cpdapprovedreg == 'Approved') {
                $good_standing_status = 1;
            } else {
                $good_standing_status = 0;
            }
        } else {
            $good_standing_status = 0;
        }
    } else {
        $cpdyearcur = date('Y');
        if ($cpdyear == $cpdyearcur) {
            $cpdapprovedreg = $resrenewaldetails['cpd_admincheck_status'];
            if ($cpdapprovedreg == 'Approved') {
                $good_standing_status = 1;
            } else {
                $good_standing_status = 0;
            }
        } else {
            $good_standing_status = 0;
        }
    }
}


//echo $good_standing_status;


if (mysqli_num_rows($getdetails) == '0') { ?>
    <div class="col-md-12">
        <div class="kt-portlet text-white" style="background-color: #960808;text-align:center">
            PIN does not exist
        </div>
    </div>
<?php } else { ?>


    <style>
        .text-muted {
            color: white !important;
        }

        .text-muted~p {
            color: white !important
        }

        strong,
        span,
        p {
            color: white !important
        }
    </style>

    <div class="col-md-12">
        <div class="kt-portlet" style="display:flex;background-color: #960808;width:80%;margin: 0 auto">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title text-white">
                        <div style="display: flex;flex-direction:row;
                            justify-content:center;align-items:center;">
                            <div s><img src="newassets/img/ahpc_logo.png" style="width: 90px;height:90px"></div>
                            <div> ALLIED HEALTH PROFESSIONS COUNCIL</div>
                        </div>
                    </h3>
                </div>
            </div>

            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        $img = $mysqli->query("select * from applicant_images
                    where applicant_id = '$applicant_id'");
                        $fetch_img = $img->fetch_assoc()
                        ?>
                        <div class="profile-image"><img src="<?php echo $reg_root . '/' . $fetch_img['image_location'] ?>" alt="" style="width: 100px;height:100px;">
                        </div>
                        <hr />
                        <div>
                            <h4 class="m-b-0">
                                <strong>
                                    <?php
                                    $fname = $resdetails['surname'] . ' ' . $resdetails['first_name'] . ' ' . $resdetails['other_name'];
                                    $title = $resdetails['title'];

                                    if ($title == "Other") {
                                        $title = $resdetails['othertitle'];
                                        $title . ' ' . $resdetails["full_name"];
                                    } else {
                                        $title . ' ' . $resdetails["full_name"];
                                    }

                                    echo $title . ' ' . $fname;
                                    ?>
                                </strong>
                            </h4>
                            <span>
                                <?php echo $profession = $resdetails['profession'];
                                $professionid = $resdetails['professionid'];
                                if ($profession == "") {
                                    $q = $mysqli->query("select * from professions where professionid = '$professionid'");
                                    $result = $q->fetch_assoc();
                                    echo $result['professionname'];
                                }
                                ?>
                            </span>

                        </div>

                        <hr class="dashed">
                        <p>
                            AHPC PIN: <?php echo $resdetails['provisional_pin']; ?>
                        </p>
                        <hr class="dashed">

                        <p>
                            Good Standing for (<b><?php echo date('Y'); ?></b>):
                            <?php
                            if ($good_standing_status == '1') {
                                echo "<img src='newassets/media/demos/demo4/right.jpg' style='width:30px;height:30px'><br/><br/>
                                <b>PERMANENT PIN</b>";
                            } else if ($good_standing_status == '2') {
                                echo "<img src='newassets/media/demos/demo4/right.jpg' style='width:30px;height:30px'><br/><br/>
                                <b>INTERNSHIP</b>";
                            } else {
                                echo "<img src='newassets/media/demos/demo4/wrong.jpg' style='width:30px;height:30px'>";
                            } ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Level:</small>
                        <p><?php echo $resdetails['acad_level']; ?></p>
                        <hr>
                        <small class="text-muted">Gender:</small>
                        <p><?php echo $resdetails['gender'] ?></p>
                        <hr>
                        <small class="text-muted">Telephone:</small>
                        <p><?php echo $resdetails['telephone'] ?></p>
                        <hr>
                        <small class="text-muted">Email Address:</small>
                        <p style="overflow-wrap: break-word;"><?php echo $resdetails['email_address'] ?></p>
                        <hr>

                        <small class="text-muted">Nationality:</small>
                        <p><?php echo $resdetails['nationality'] ?></p>
                        <hr>
                    </div>


                </div>


            </div>

        </div>
    </div>
<?php }
?>