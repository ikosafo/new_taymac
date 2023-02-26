<?php include('../../../config.php');
$random = rand(1, 10000) . date("Ymd");
$theindex = $_POST['theindex'];

$getactivity = $mysqli->query("select * from farm_otheractivity where id = '$theindex'");
$resactivity = $getactivity->fetch_assoc();
?>
<!--begin::Form-->

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

</script>


<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="otheractivity_name">Name of Activity</label>
                <input type="text" class="form-control" id="otheractivity_name"
                       placeholder="Enter Name of Activity" value="<?php echo $resactivity['activity'] ?>">
            </div>

        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="date_activity">Date of Activity</label>
                <input type="text" class="form-control" id="date_activity"
                       placeholder="Enter Date of Activity"  value="<?php echo $resactivity['date_activity'] ?>">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="activity_description">Description</label>
                <textarea class="form-control" id="activity_description"
                          placeholder="Enter Description"><?php echo $resactivity['activity_description'] ?></textarea>
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <button type="button" class="btn btn-primary" id="editactivity">Edit</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </div>

    </div>

</form>
<!--end::Form-->


<script>

    $('#date_activity').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });

    $('#editactivity').click(function () {
        var otheractivity_name = $('#otheractivity_name').val();
        var date_activity = $('#date_activity').val();
        var activity_description = $('#activity_description').val();
        var theindex = '<?php echo $theindex; ?>'

        var error = '';
        if (otheractivity_name == "") {
            error += 'Please select activity name \n';
            $("#otheractivity_name").focus();
        }
        if (date_activity == "") {
            error += 'Please select date of activity \n';
            $("#date_activity").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/editform_farmotheractivity.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    otheractivity_name:otheractivity_name,
                    date_activity:date_activity,
                    activity_description:activity_description,
                    theindex:theindex
                },
                success: function (text) {
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/farmotheractivity_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farmotheractivityform_div').html(text);
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
                        url: "ajax/tables/farmotheractivity_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farmotheractivitytable_div').html(text);
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