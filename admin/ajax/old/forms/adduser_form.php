<?php include ('../../../config.php');
$random = rand(1,10000).date("Y");
?>
<!--begin::Form-->

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname"
                       placeholder="Enter Full Name">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="permissions">Permissions</label>

                <select id="permission" multiple style="width: 100%">
                    <option value="">Select Permission</option>
                    <option value="All Permissions">All Permissions</option>
                    <option value="Configuration">Configuration</option>
                    <option value="Add User">Add User</option>
                    <option value="IT Section">IT Section</option>
                    <option value="Provisional Registration">Provisional Registration</option>
                    <option value="Examination Registration">Examination Registration</option>
                    <option value="Examination Registration for Upgrade">Examination Registration for Upgrade</option>
                    <option value="Permanent Registration">Permanent Registration</option>
                    <option value="Permanent Renewal (CPD)">Permanent Renewal (CPD)</option>
                    <option value="Permanent Registration (Upgrade)">Permanent Registration (Upgrade)</option>
                    <option value="Temporal Pin Renewal">Temporal Registration</option>
                    <option value="Temporal Pin Renewal">Temporal PIN Renewal</option>

                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="permissions">User Type</label> <br/>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline1"
                           name="approval" value="Regular" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline1">Regular</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2"
                           name="approval" value="MIS Admin" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline2">MIS Admin</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline3"
                           name="approval" value="Super Admin" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline3">Super Admin</label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username"
                       placeholder="Enter Username">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password"
                       placeholder="Enter Password">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" class="form-control" id="confirmpassword"
                       placeholder="Confirm Password">
            </div>
        </div>


    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="saveuser">Submit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->



<script>

    $("#permission").select2({placeholder: "Select Permission(s)"});


    $("#saveuser").click(function () {

        var full_name = $("#fullname").val();
        var user_id = '<?php echo $random; ?>';
        var approval = $('input[name=approval]:checked').val();
        var permission = $("#permission").val();
        var username = $("#username").val();
        var password = $("#password").val();
        var confirm_password = $("#confirmpassword").val();

        var error = '';

        if (full_name == "") {
            error += 'Please enter full name\n';
            $("#fullname").focus();
        }
        if (approval == undefined) {
            error += 'Please select user type \n';
        }
        if (permission == "") {
            error += 'Please select permission\n';
            $("#permission").focus();
        }
        if (username == "") {
            error += 'Please enter username\n';
            $("#username").focus();
        }
        if (password == "") {
            error += 'Please enter password \n';
            $("#password").focus();
        }
        if (password != "" && password.length < 6) {
            error += 'Minimum characters should be six \n';
            $("#password").focus();
        }
        if (password != "" && confirm_password == "") {
            error += 'Please confirm password \n';
            $("#confirmpassword").focus();
        }
        if (confirm_password != "" && password != confirm_password){
            error += 'Passwords are not the same \n';
            $("#confirm_password").focus();
        }

        if (error == "") {

            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_user.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    full_name: full_name,
                    permission: permission,
                    username: username,
                    password: password,
                    user_id:user_id,
                    approval:approval
                },
                success: function (text) {
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/adduser_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#userform_div').html(text);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function () {
                            KTApp.unblockPage();
                        },

                    });


                    $.ajax({
                        type: "POST",
                        url: "ajax/tables/adduser_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#usertable_div').html(text);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function () {
                            KTApp.unblockPage();
                        },

                    });
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