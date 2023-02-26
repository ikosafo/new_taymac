<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
$theindex = $_POST['theindex'];

$getstaff = $mysqli->query("select * from admin_staff where id = '$theindex'");
$resstaff = $getstaff->fetch_assoc();
?>
<!--begin::Form-->

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="staff_name">Name of Staff</label>
                <input type="text" class="form-control" id="staff_name"
                       placeholder="Enter Staff Name" value="<?php echo $resstaff['staff_name']; ?>">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="employment_type">Select Employment Type</label>
                <select id="employment_type" style="width: 100%">
                    <option value="">Select Employment Type</option>
                    <option <?php if (@$resstaff['employment_type'] == "Full Time") echo "Selected" ?>>Full Time</option>
                    <option <?php if (@$resstaff['employment_type'] == "Part Time") echo "Selected" ?>>Part Time</option>
                    <option <?php if (@$resstaff['employment_type'] == "Contract") echo "Selected" ?>>Contract</option>
                    <option <?php if (@$resstaff['employment_type'] == "Probation") echo "Selected" ?>>Probation</option>
                    <option <?php if (@$resstaff['employment_type'] == "Intern") echo "Selected" ?>>Intern</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="staff_id">Staff ID</label>
                <input type="text" class="form-control" id="staff_id"
                       placeholder="Enter Staff ID" value="<?php echo $resstaff['staff_id']; ?>">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="staff_position">Position</label>
                <input type="text" class="form-control" id="staff_position"
                       placeholder="Enter Staff Position" value="<?php echo $resstaff['staff_position']; ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="staff_telephone">Telephone</label>
                <input type="text" class="form-control" id="staff_telephone"
                       placeholder="Enter Telephone" value="<?php echo $resstaff['staff_telephone']; ?>">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="staff_email">Email</label>
                <input type="text" class="form-control" id="staff_email"
                       placeholder="Enter Email" value="<?php echo $resstaff['staff_email']; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="staff_qualification">Qualification</label>
                <input type="text" class="form-control" id="staff_qualification"
                       placeholder="Enter Qualification" value="<?php echo $resstaff['staff_qualification']; ?>">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="staff_department">Department</label>
                <input type="text" class="form-control" id="staff_department"
                       placeholder="Enter Department" value="<?php echo $resstaff['staff_department']; ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="date_started">Date of Commencement</label>
                <input type="text" class="form-control" id="date_started"
                       placeholder="Select Date Commenced" value="<?php echo $resstaff['date_started']; ?>">
            </div>
        </div>

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="editstaff">Edit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->


<script>

    $("#employment_type").select2({placeholder: "Select Employment Type"});

    $('#date_started').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });

    $("#editstaff").click(function () {
        var staff_name = $("#staff_name").val();
        var employment_type = $("#employment_type").val();
        var staff_id = $("#staff_id").val();
        var staff_position = $("#staff_position").val();
        var staff_telephone = $("#staff_telephone").val();
        var staff_email = $("#staff_email").val();
        var staff_qualification = $("#staff_qualification").val();
        var staff_department = $("#staff_department").val();
        var date_started = $("#date_started").val();
        var theindex = '<?php echo $theindex ?>';

        var error = '';
        if (staff_name == "") {
            error += 'Please name of staff\n';
            $("#staff_name").focus();
        }
        if (employment_type == "") {
            error += 'Please select employment type\n';
            $("#employment_type").focus();
        }
        if (staff_id == "") {
            error += 'Please enter staff ID\n';
            $("#staff_id").focus();
        }
        if (date_started == "") {
            error += 'Please select date started\n';
            $("#date_started").focus();
        }
        if (staff_email != "" && !staff_email.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
            error += 'Please enter valid email \n';
            $("#staff_email").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/editform_adminstaff.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    staff_name: staff_name,
                    employment_type: employment_type,
                    staff_id: staff_id,
                    staff_position:staff_position,
                    staff_telephone:staff_telephone,
                    staff_email:staff_email,
                    staff_qualification:staff_qualification,
                    staff_department:staff_department,
                    date_started:date_started,
                    theindex:theindex
                },
                success: function (text) {
                    //alert(text);
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/adminstaff_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#staffform_div').html(text);
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
                        url: "ajax/tables/adminstaff_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#stafftable_div').html(text);
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