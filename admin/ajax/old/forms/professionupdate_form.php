<?php include ('../../../config.php');
$user_id = $_SESSION['user_id'];

$getemails = $mysqli->query("select * from provisional where email_address != '' ORDER BY email_address");
?>
<!--begin::Form-->

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="emailaddress">Applicant's Email Address</label>
                <select id="emailapp" style="width: 100%">
                    <option value="" selected hidden>Select Email Address</option>
                    <?php while ($resemail = $getemails->fetch_assoc()){ ?>
                        <option value="<?php echo $resemail['provisionalid']?>"><?php echo $resemail['surname'].' '.$resemail['first_name'].' '.$resemail['other_name'].' - '.$resemail['email_address'] ?></option>
                    <?php } ?>

                </select>
                <div class="col-lg-12 col-md-12">
                    <p style="color:blue" id="gettxt"></p>
                </div>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="profession">Applicant's Current Profession</label>
                <select id="profession" style="width: 100%">
                    <option value="">Select profession</option>
                    <?php
                    $query = $mysqli->query("select * from professions ORDER BY professionname");
                    while ($result = $query->fetch_assoc()) { ?>
                        <option value="<?php echo $result['professionid'] ?>">
                            <?php echo $result['professionname'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="newprofession">Applicant's New Profession</label>
                <select id="newprofession" style="width: 100%">
                    <option value="">Select Profession</option>
                    <?php
                    $query = $mysqli->query("select * from professions ORDER BY professionname");
                    while ($result = $query->fetch_assoc()) { ?>
                        <option value="<?php echo $result['professionid'] ?>">
                            <?php echo $result['professionname'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="savechange">Submit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->



<script>

    $('#emailapp').on('change',function(){
        var optionText = $("#emailapp option:selected").text();
        //$('#name-search').val(optionText);
        //var gettxt = $('#gettxt').val(optionText);
        document.getElementById('gettxt').innerHTML = optionText;
        //alert(optionText);
    });

    $("#emailapp").select2();
    $("#profession").select2();
    $("#newprofession").select2();


    $("#savechange").click(function () {
        var user_id = '<?php echo $user_id; ?>';
        var emailapp = $("#emailapp").val();
        var profession = $("#profession").val();
        var newprofession = $("#newprofession").val();

        var error = '';
        if (emailapp == "") {
            error += "Please select email address of applicant \n";
            $("#emailapp").focus();
        }
        if (profession == "") {
            error += "Please select applicant's current profession \n";
            $("#profession").focus();
        }
        if (newprofession == "") {
            error += "Please select applicant's new profession \n";
            $("#newprofession").focus();
        }


        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_professionupdate.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    user_id:user_id,
                    emailapp: emailapp,
                    profession: profession,
                    newprofession:newprofession
                },
                success: function (text) {
                    //alert(text);
                    if (text == 1) {
                        $.ajax({
                            url: "ajax/forms/professionupdate_form.php",
                            beforeSend: function () {
                                KTApp.blockPage({
                                    overlayColor: "#000000",
                                    type: "v2",
                                    state: "success",
                                    message: "Please wait..."
                                })
                            },
                            success: function (text) {
                                $('#professionupdate_div').html(text);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            },
                            complete: function () {
                                KTApp.unblockPage();
                            },

                        });

                        $.ajax({
                            url: "ajax/tables/professionupdate_table.php",
                            beforeSend: function () {
                                KTApp.blockPage({
                                    overlayColor: "#000000",
                                    type: "v2",
                                    state: "success",
                                    message: "Please wait..."
                                })
                            },
                            success: function (text) {
                                $('#professionupdatetable_div').html(text);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            },
                            complete: function () {
                                KTApp.unblockPage();
                            },

                        });

                    }
                    else if (text == 2) {
                        $.notify("Wrong current profession chosen for applicant", {position: "top center"});
                    }
                    else if (text == 3) {
                        $.notify("Same profession chosen for applicant", {position: "top center"});
                    }
                },

                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                },
                complete: function () {
                    KTApp.unblockPage();
                },

            });
        }

        else {
            $.notify(error, {position: "top center"});
        }
        return false;
    });


</script>