<?php include('../../../config.php'); ?>
<!--begin::Form-->

<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

</script>

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="surname">Surname</label>
                <input type="text" class="form-control" id="surname"
                       placeholder="Enter Surname">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="firstname">First name</label>
                <input type="text" class="form-control" id="firstname"
                       placeholder="Enter First name">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="othername">Other name(s)</label>
                <input type="text" class="form-control" id="othername"
                       placeholder="Enter Other name(s)">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="email_address">Email Address</label>
                <input type="text" class="form-control" id="email_address"
                       placeholder="Enter Email Address">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="telephone">Telephone</label>
                <input type="text" class="form-control" id="telephone" onkeypress="return isNumber(event)"
                       minlength="10"
                       placeholder="Enter Telephone">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="institution">Institution</label>
                <select id="institution" style="width: 100%">
                    <option value="">Select Institution</option>
                    <?php
                    $quer = $mysqli->query("select nameofinstitution from institutions ORDER BY nameofinstitution");
                    while ($resr = $quer->fetch_assoc()) { ?>
                        <option <?php if (@$nameofinstitution == $resr['nameofinstitution']) echo "Selected" ?>><?php echo $resr['nameofinstitution'] ?></option>
                    <?php } ?>
                    <option value="Other">Other</option>

                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="other_institution">Institution (If Other, Specify)</label>
                <input type="text" class="form-control" id="other_institution"
                       placeholder="Specify Other Institution">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="completion_year">Year of Completion</label>
                <input type="text" class="form-control" id="completion_year" readonly="" placeholder="Select year">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="profession">Profession</label>
                <select id="profession" style="width: 100%">
                    <option value="">Select profession</option>
                    <?php
                    $que = $mysqli->query("select professionname from professions ORDER BY professionname");
                    while ($res = $que->fetch_assoc()) { ?>
                        <option <?php if (@$profession == $res['professionname']) echo "Selected" ?>><?php echo $res['professionname'] ?></option>
                    <?php } ?>

                </select>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="reason">Reason for Special Case</label>
                <select id="reason" style="width: 100%">
                    <option value="">Select reason</option>
                    <option value="Failed and coming for a resit">Failed and coming for a resit</option>
                    <option value="PIN not required">PIN not required</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="other_reason">Reason for Special Case (If Other, Specify)</label>
                    <textarea class="form-control" id="other_reason"
                              placeholder="Enter reason" rows="4"></textarea>
            </div>
        </div>

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="saveexception">Submit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->


<script>

    $("#profession").select2({placeholder: "Select Profession"});
    $("#institution").select2({placeholder: "Select Institution"});
    $("#reason").select2({placeholder: "Select Reason"});

    $('#completion_year').datepicker({
        format: 'yyyy',
        autoclose: true,
        orientation: "bottom",
        viewMode: "years",
        minViewMode: "years",
        templates: {
            leftArrow: '<i class="flaticon2-left-arrow"></i>',
            rightArrow: '<i class="flaticon2-right-arrow"></i>'
        }
    });


    $("#saveexception").click(function () {

        var surname = $("#surname").val();
        var firstname = $("#firstname").val();
        var othername = $("#othername").val();
        var email_address = $("#email_address").val();
        var telephone = $("#telephone").val();
        var institution = $("#institution").val();
        var completion_year = $("#completion_year").val();
        var reason = $("#reason").val();
        var other_reason = $("#other_reason").val();
        var other_institution = $("#other_institution").val();
        var profession = $("#profession").val();
        var error = '';

        if (surname == "") {
            error += 'Please enter surname \n';
            $("#surname").focus();
        }
        if (firstname == "") {
            error += 'Please enter first name \n';
            $("#firstname").focus();
        }
        if (email_address == "") {
            error += 'Please enter email address \n';
            $("#email_address").focus();
        }
        if (!email_address.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
            error += 'Please enter valid email \n';
            $("#email_address").focus();
        }
        if (telephone == "") {
            error += 'Please enter telephone \n';
            $("#telephone").focus();
        }
        if (telephone.length < 10) {
            error += 'Please enter valid telephone \n';
            $("#telephone").focus();
        }
        if (institution == "") {
            error += 'Please enter institution \n';
            $("#institution").focus();
        }
        if (institution == "Other" && other_institution == "") {
            error += 'Please specify other institution \n';
            $("#other_institution").focus();
        }
        if (institution != "Other" && other_institution != "") {
            error += 'Please do not specify other institution \n';
            $("#other_institution").focus();
        }
        if (profession == "") {
            error += 'Please select profession \n';
            $("#profession").focus();
        }
        if (completion_year == "") {
            error += 'Please enter year of completion \n';
        }
        if (reason == "") {
            error += 'Please select reason for special case \n';
            $("#reason").focus();
        }
        if (reason == "Other" && other_reason == "") {
            error += 'Please specify other reason \n';
            $("#other_reason").focus();
        }
        if (reason != "Other" && other_reason != "") {
            error += 'Please do not specify other reason \n';
            $("#other_reason").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_exceptionex.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    surname:surname,
                    firstname:firstname,
                    othername:othername,
                    email_address:email_address,
                    telephone:telephone,
                    institution:institution,
                    completion_year:completion_year,
                    reason:reason,
                    other_reason:other_reason,
                    profession:profession
                },
                success: function (text) {
                    //alert(text);
                    if (text == 1) {
                        $.notify("Form Submitted", "success", {position: "top center"});
                        $.ajax({
                            url: "ajax/forms/specialcaseex_form.php",
                            success: function (text) {
                                $('#specialcaseex_div').html(text);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            },

                        });
                        $.ajax({
                            url: "ajax/tables/specialcaseex_form.php",
                            success: function (text) {
                                $('#specialcasetableex_div').html(text);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            },
                        });
                    }
                    else if (text == 2) {
                        $.notify("Duplicate Entry", "error", {position: "top center"});
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
    })

</script>