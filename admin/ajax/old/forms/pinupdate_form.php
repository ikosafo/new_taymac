<?php include ('../../../config.php');
$user_id = $_SESSION['user_id'];
?>
<!--begin::Form-->

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="correctpin">Applicant's Correct PIN</label>
                <input type="text" class="form-control" id="correctpin"
                       placeholder="Enter Correct Pin">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="correctpin">Wrong PIN (In database)</label>
                <input type="text" class="form-control" id="wrongpin"
                       placeholder="Enter Wrong Pin">
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

    $("#savechange").click(function () {
        var user_id = '<?php echo $user_id; ?>';
        var correct_pin = $("#correctpin").val();
        var wrong_pin = $("#wrongpin").val();

        var error = '';
        if (correct_pin == "") {
            error += "Please enter applicant's pin \n";
            $("#correctpin").focus();
        }
        if (wrong_pin == "") {
            error += "Please enter the wrong pin \n";
            $("#wrongpin").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_pinupdate.php",
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
                    correct_pin: correct_pin,
                    wrong_pin: wrong_pin
                },
                success: function (text) {
                    //alert(text);
                    if (text == 1) {
                        swal("Pin updated", "success");
                        //location.reload();
                    }
                    else if (text == 2) {
                        $.notify("Wrong Pin does not exist", {position: "top center"});
                    }
                    else if (text == 3) {
                        $.notify("Correct Pin already exists", {position: "top center"});
                    }
                    else if (text == 4) {
                        $.notify("Correct Pin does not exist", {position: "top center"});
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