<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
$theindex = $_POST['theindex'];

$gettenant = $mysqli->query("select * from admin_taymac_tenant where id = '$theindex'");
$restenant = $gettenant->fetch_assoc();
?>
<!--begin::Form-->
<small style="color: red">Field Marked * are required</small>

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="tenant_name">Name of tenant *</label>
                <input type="text" class="form-control" id="tenant_name"
                       placeholder="Enter Tenant Name" value="<?php echo $restenant['tenant_name'] ?>">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="tenant_property">Select Property *</label>
                <select id="tenant_property" style="width: 100%">
                    <option value="">Select tenant Type</option>
                    <?php
                    $tenant_property = $restenant['tenant_property'];
                    $getproperty = $mysqli->query("select * from admin_taymac_property");
                    while ($resproperty = $getproperty->fetch_assoc()) { ?>
                        <option <?php if (@$tenant_property == $resproperty['id']) echo "Selected" ?>><?php echo $resproperty['property_name'] ?></option>
                    <?php  } ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="date_started">Date of Commencement *</label>
                <input type="text" class="form-control" id="date_started"
                       placeholder="Select Date Commenced" value="<?php echo $restenant['date_started'] ?>">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="date_completed">Date of Completion *</label>
                <input type="text" class="form-control" id="date_completed"
                       placeholder="Select Date Completed" value="<?php echo $restenant['date_completed'] ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="payment_rate">Select Payment Rate *</label>
                <select id="payment_rate" style="width: 100%">
                    <option value="">Select Rate</option>
                    <option <?php if (@$restenant['payment_rate'] == "Weekly") echo "Selected" ?>>Weekly</option>
                    <option <?php if (@$restenant['payment_rate'] == "Monthly") echo "Selected" ?>>Monthly</option>
                    <option <?php if (@$restenant['payment_rate'] == "Quarterly") echo "Selected" ?>>Quarterly</option>
                    <option <?php if (@$restenant['payment_rate'] == "Half Yearly") echo "Selected" ?>>Half Yearly</option>
                    <option <?php if (@$restenant['payment_rate'] == "Yearly") echo "Selected" ?>>Yearly</option>
                </select>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="tenant_telephone">Telephone</label>
                <input type="text" class="form-control" id="tenant_telephone"
                       placeholder="Enter Telephone" value="<?php echo $restenant['tenant_telephone'] ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="tenant_email">Email Address </label>
                <input type="text" class="form-control" id="tenant_email"
                       placeholder="Enter tenant Name" value="<?php echo $restenant['tenant_email'] ?>">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="tenant_description">Description</label>
                <textarea class="form-control" id="tenant_description"
                          placeholder="Enter Description"><?php echo $restenant['tenant_description'] ?></textarea>
            </div>
        </div>


    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="edittenant">Edit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->



<script>

    $("#tenant_property").select2({placeholder: "Select Property"});
    $("#payment_rate").select2({placeholder: "Select Rate"});

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

    $("#edittenant").click(function () {
        var tenant_name = $("#tenant_name").val();
        var tenant_property = $("#tenant_property").val();
        var date_started = $("#date_started").val();
        var date_completed = $("#date_completed").val();
        var tenant_telephone = $("#tenant_telephone").val();
        var tenant_email = $("#tenant_email").val();
        var tenant_description = $("#tenant_description").val();
        var payment_rate = $("#payment_rate").val();
        var theindex = '<?php echo $theindex ?>';

        //alert(tenant_property);

        var error = '';
        if (tenant_name == "") {
            error += 'Please name of tenant\n';
            $("#tenant_name").focus();
        }
        if (tenant_property == "") {
            error += 'Please select property\n';
            $("#tenant_property").focus();
        }
        if (date_started == "") {
            error += 'Please select date started\n';
            $("#date_started").focus();
        }
        if (date_completed == "") {
            error += 'Please select date completed\n';
            $("#date_completed").focus();
        }
        if (date_started > date_completed) {
            error += 'Please select correct date range \n';
            $("#date_completed").focus();
        }
        if (payment_rate == "") {
            error += 'Please select payment rate\n';
            $("#payment_rate").focus();
        }
        if (tenant_email != "" && !tenant_email.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
            error += 'Please enter valid email \n';
            $("#tenant_email").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/editform_admintenant.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    tenant_name: tenant_name,
                    tenant_property: tenant_property,
                    date_started: date_started,
                    date_completed:date_completed,
                    tenant_telephone:tenant_telephone,
                    tenant_email:tenant_email,
                    tenant_description:tenant_description,
                    payment_rate:payment_rate,
                    theindex:theindex
                },
                success: function (text) {
                    //alert(text);
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/admintenant_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#tenantform_div').html(text);
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
                        url: "ajax/tables/admintenant_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#tenanttable_div').html(text);
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