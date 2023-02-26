<?php include ('../../../config.php');

$id = $_POST['i_index'];
$que = $mysqli->query("select * from date_config where id = '$id'");
$res = $que->fetch_assoc();

?>
<!--begin::Form-->

<form class="" autocomplete="off">

    <h6>Edit Date Config</h6>
    <div class="kt-portlet__body">
        <input type="hidden" value="<?php echo $res['id'] ?>" id="config_id"/>

        <div class="form-group">
            <label>Registration Type </label>
            <select id="reg_type" class="whyn" style="width: 100%">
                <option value="">Select Registration Type</option>
                <option <?php if (@$res['registration_type'] == "Provisional") echo "selected" ?>>Provisional</option>
                <option <?php if (@$res['registration_type'] == "Permanent") echo "selected" ?>>Permanent</option>
                <option <?php if (@$res['registration_type'] == "Temporal") echo "selected" ?>>Temporal</option>
                <option <?php if (@$res['registration_type'] == "Examination") echo "selected" ?>>Examination</option>
                <option <?php if (@$res['registration_type'] == "Renewal") echo "selected" ?>>Renewal</option>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Date of Opening</label>
            <input type="text" id="date_started" class="form-control"
                   value="<?php echo $res['date_started'] ?>"
                   placeholder="Select Year" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Deadline</label>
            <input type="text" id="date_completed" class="form-control"
                   value="<?php echo $res['date_completed'] ?>"
                   placeholder="Select Year">
        </div>

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="editdateconfig">Edit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->



<script>

    $("#reg_type").select2({placeholder: "Select Type"});

    $('#date_started').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });

    $('#date_completed').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });


    $("#editdateconfig").click(function () {
        var date_started = $("#date_started").val();
        var date_completed = $("#date_completed").val();
        var reg_type = $("#reg_type").val();
        var config_id = $("#config_id").val();

        var error = '';
        if (date_started == "") {
            error += 'Please select opening date \n';
        }
        if (date_completed == "") {
            error += 'Please select deadline \n';
        }
        if (date_completed < date_started) {
            error += 'Please specify correct date range \n';
        }
        if (reg_type == "") {
            error += 'Please select registration type \n';
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_dateconfigedit.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    date_started: date_started,
                    date_completed: date_completed,
                    reg_type: reg_type,
                    config_id:config_id
                },
                success: function (text) {
                    //alert(text);
                    if (text == 2) {
                        $.notify("Registration already exists", {position: "top center"});
                    }
                    else {
                        $.notify("Form Submitted","success", {position: "top center"});
                        $.ajax({
                            url: "ajax/forms/dateconfig_form.php",
                            success: function (text) {
                                $('#dateconfigform_div').html(text);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            },
                        });

                        $.ajax({
                            url: "ajax/tables/dateconfig_table.php",
                            success: function (text) {
                                $('#dateconfigtable_div').html(text);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
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
    })

</script>