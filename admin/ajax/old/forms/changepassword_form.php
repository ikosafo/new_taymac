<?php include ('../../../config.php');
$user_id = $_SESSION['user_id'];
?>
<!--begin::Form-->

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="password">Current Password</label>
                <input type="password" class="form-control" id="currentpassword"
                       placeholder="Enter Current Password">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="confirmpassword">New Password</label>
                <input type="password" class="form-control" id="newpassword"
                       placeholder="Enter New Password">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" class="form-control" id="confirmpassword"
                       placeholder="Confirm New Password">
            </div>
        </div>


    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="updatepassword">Change Password</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->



<script>

    $("#updatepassword").click(function () {
        //alert('hi');
         var user_id = '<?php echo $user_id; ?>';
        var currentpassword = $("#currentpassword").val();
        var newpassword = $("#newpassword").val();
        var confirmpassword = $("#confirmpassword").val();

        var error = '';
        if (newpassword != "" && confirmpassword == "") {
            error += 'Please confirm password \n';
            $("#confirmpassword").focus();
        }
        if (newpassword != "" && newpassword.length < 6) {
            error += 'Minimum password characters should be six \n';
            $("#newpassword").focus();
        }
        if (newpassword != "" && confirmpassword != "" && confirmpassword != newpassword) {
            error += 'Passwords do not match \n';
            $("#confirmpassword").focus();
        }
        if (newpassword == "") {
            error += 'Please enter new password \n';
            $("#newpassword").focus();
        }
        if (currentpassword == "") {
            error += 'Please enter current password \n';
            $("#currentpassword").focus();
        }

        if (error == "") {

            $.ajax({
                type: "POST",
                url: "ajax/queries/changepassword.php",
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
                    current_password: currentpassword,
                    new_password: newpassword
                },
                success: function (text) {
                    //alert(text);
                    if (text == 1) {
                        $.notify("Password changed", "success", {position: "top center"});
                        location.reload();
                    }
                    else {
                        $.notify("Password does not exist", "error", {position: "top center"});
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