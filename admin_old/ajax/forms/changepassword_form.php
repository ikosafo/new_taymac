<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
?>

<form class="" autocomplete="off">
    <div class="kt-portlet__body">
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="currentpassword">Current Password</label>
                <input type="password" class="form-control" id="currentpassword"
                       placeholder="Enter Current Password">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="password">New Password</label>
                <input type="password" class="form-control" id="password"
                       placeholder="Enter New Password">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="confirmpassword">Confirm New Password</label>
                <input type="password" class="form-control" id="confirmpassword"
                       placeholder="Confirm New Password">
            </div>
        </div>

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="changepassword">Update</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>

<script>

    $("#usertype").select2({placeholder: "Select User Type"});

    $("#changepassword").click(function () {
        var currentpassword = $("#currentpassword").val();
        var password = $("#password").val();
        var confirmpassword = $("#confirmpassword").val();

        var error = '';

        if (currentpassword == "") {
            error += 'Please enter current password\n';
            $("#currentpassword").focus();
        }
        if (password == "") {
            error += 'Please enter new password\n';
            $("#password").focus();
        }
        if (password != "" && confirmpassword == "") {
            error += 'Please confirm new password\n';
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

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_password.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    currentpassword: currentpassword,
                    newpassword:password
                },
                success: function (text) {
                    //alert(text);
                    if (text == 2) {
                        $.notify("Current password error", {position: "top center"});
                    }
                    else {
                        $.notify("Password changed", "success",{position: "top center"});
                        $.ajax({
                            type: "POST",
                            url: "ajax/forms/changepassword_form.php",
                            beforeSend: function () {
                                KTApp.blockPage({
                                    overlayColor: "#000000",
                                    type: "v2",
                                    state: "success",
                                    message: "Please wait..."
                                })
                            },
                            success: function (text) {
                                $('#passwordform_div').html(text);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            },
                            complete: function () {
                                KTApp.unblockPage();
                            },
                        });
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