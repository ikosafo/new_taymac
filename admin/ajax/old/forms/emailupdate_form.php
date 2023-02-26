<?php include ('../../../config.php');
$user_id = $_SESSION['user_id'];

$getemails = $mysqli->query("select * from provisional where email_address != '' ORDER BY email_address");
?>
<!--begin::Form-->

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="emailaddress">Applicant's Old Email Address</label>
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
                <label for="newemail">Applicant's New Email Address</label>
                <input type="text" class="form-control" id="newemail"
                       placeholder="Enter New Email Address">
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



    $("#savechange").click(function () {
        var user_id = '<?php echo $user_id; ?>';
        var emailapp = $("#emailapp").val();
        var newemail = $("#newemail").val();

        var error = '';

        if (emailapp == "") {
            error += "Please select email address of applicant \n";
            $("#emailapp").focus();
        }
        if (newemail == "") {
            error += "Please enter the new email \n";
            $("#newemail").focus();
        }


        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_emailupdate.php",
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
                    newemail: newemail
                },
                success: function (text) {
                    //alert(text);
                    if (text == 1) {
                        $.notify("Email updated", "success");
                        location.reload();
                    }
                    else if (text == 3) {
                        $.notify("New  Email already in Use","error");
                    }
                    else if (text == 4) {
                        $.notify("New Email is not verified","error");
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