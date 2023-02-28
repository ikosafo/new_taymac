<?php include('../../../config.php');
$random = rand(1, 10000) . date("Ymd");
?>

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" placeholder="Enter Full Name">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter Username">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter Password">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" class="form-control" id="confirmpassword" placeholder="Confirm Password">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="permissions">Permissions</label>

                <select id="permissions" multiple style="width: 100%">
                    <option value="">Select Permission</option>
                    <option value="All Permissions">All Permissions</option>
                    <optgroup label="Property Management">
                        <option value="permission_property">Property</option>
                        <option value="permission_tenants">Tenants</option>
                        <option value="permission_billing">Billing</option>
                        <option value="permission_service">Service & Maintenance</option>
                    </optgroup>
                    <optgroup label="Farm Management">
                        <option value="permission_categories">Categories</option>
                        <option value="permission_finance">Finance</option>
                        <option value="permission_harvesting">Harvesting</option>
                        <option value="permission_tunnels">Tunnels</option>
                        <option value="permission_factivities">Farm Activities</option>
                        <option value="permission_freport">Report</option>
                    </optgroup>
                    <optgroup label="Staff Management">
                        <option value="permission_staff">Staff</option>
                        <option value="permission_payroll">Payroll</option>
                    </optgroup>
                    <optgroup label="Acounts Management">
                        <option value="permission_apayments">Payments</option>
                        <option value="permission_aentry">Account Entry</option>
                        <option value="permission_acashbook">Cash Book</option>
                    </optgroup>

                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="usertype">Select User Type</label>
                <select id="usertype" style="width: 100%">
                    <option value="">Select Input Type</option>
                    <option value="Admin">Admin</option>
                    <option value="Normal">Normal</option>
                </select>
            </div>
            <small class="ml-4">Normal users cannot only create new users</small>
        </div>

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="saveuser">Submit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>

<script>
    $("#usertype").select2({
        placeholder: "Select User Type"
    });
    $("#usertype").select2({
        placeholder: "Select User Type"
    });
    $("#permissions").select2({
        placeholder: "Select Permission(s)"
    });

    $("#saveuser").click(function() {
        var fullname = $("#fullname").val();
        var username = $("#username").val();
        var password = $("#password").val();
        var confirmpassword = $("#confirmpassword").val();
        var usertype = $("#usertype").val();
        var permission = $("#permissions").val();


        var error = '';
        if (fullname == "") {
            error += 'Please enter full name\n';
            $("#fullname").focus();
        }
        if (username == "") {
            error += 'Please enter username\n';
            $("#username").focus();
        }
        if (password == "") {
            error += 'Please enter password\n';
            $("#password").focus();
        }
        if (password != "" && confirmpassword == "") {
            error += 'Please confirm password\n';
            $("#confirmpassword").focus();
        }
        if (password != "" && password.length < 6) {
            error += 'Password should have a minimum of 6 characters \n';
            $("#password").focus();
        }
        if (password != "" && confirmpassword != "" && password != confirmpassword) {
            error += 'Passwords do not match \n';
            $("#confirmpassword").focus();
        }
        if (permission == "") {
            error += 'Please select permission\n';
            $("#permission").focus();
        }
        if (usertype == "") {
            error += 'Please specify user type\n';
            $("#usertype").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_user.php",
                beforeSend: function() {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    fullname: fullname,
                    username: username,
                    password: password,
                    usertype: usertype,
                    permission: permission
                },
                success: function(text) {
                    alert(text);
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/adminuser_form.php",
                        beforeSend: function() {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function(text) {
                            $('#userform_div').html(text);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function() {
                            KTApp.unblockPage();
                        },
                    });


                    $.ajax({
                        type: "POST",
                        url: "ajax/tables/adminuser_table.php",
                        beforeSend: function() {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function(text) {
                            $('#usertable_div').html(text);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function() {
                            KTApp.unblockPage();
                        },
                    });
                },

                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                },
                complete: function() {
                    KTApp.unblockPage();
                },
            });
        } else {
            $.notify(error, {
                position: "top center"
            });
        }
        return false;

    });
</script>