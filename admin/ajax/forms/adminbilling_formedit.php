<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
$theindex = $_POST['theindex'];

$getbilling = $mysqli->query("select * from admin_taymac_billing where id = '$theindex'");
$resbilling = $getbilling->fetch_assoc();
?>

<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>
<!--begin::Form-->
<small style="color: red">Field Marked * are required</small>

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="billing_type">Billing Type *</label>
                <select id="billing_type" style="width: 100%">
                    <option value="">Select Billing Type</option>
                    <option <?php if (@$resbilling['billing_type'] == "Rent") echo "Selected" ?>>Rent</option>
                    <option <?php if (@$resbilling['billing_type'] == "CAM Fees") echo "Selected" ?>>CAM Fees</option>
                    <option <?php if (@$resbilling['billing_type'] == "Reimburse Bills") echo "Selected" ?>>Reimburse Bills</option>
                    <option <?php if (@$resbilling['billing_type'] == "Other") echo "Selected" ?>>Other</option>
                </select>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="billing_type_other">If Billing Type is 'Other', Specify</label>
                <input type="text" class="form-control" id="billing_type_other"
                       placeholder="If Other, Specify" value="<?php echo $resbilling['billing_type_other'] ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="billing_tenant">Select Tenant *</label>
                <select id="billing_tenant" style="width: 100%">
                    <option value="">Select Tenant</option>
                    <?php
                    $billing_tenant = $resbilling['billing_tenant'];
                    $gettenant = $mysqli->query("select * from admin_taymac_tenant");
                    while ($restenant = $gettenant->fetch_assoc()) { ?>
                        <option <?php if (@$billing_tenant == $restenant['id']) echo "Selected" ?>><?php echo $restenant['tenant_name'] ?></option>
                    <?php  } ?>
                </select>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="billing_currency">Currency *</label>
                <select id="billing_currency" style="width: 100%">
                    <option value="">Select Currency</option>
                    <option <?php if (@$resbilling['billing_currency'] == "US Dollars") echo "Selected" ?>>US Dollars</option>
                    <option <?php if (@$resbilling['billing_currency'] == "GH Cedis") echo "Selected" ?>>GH Cedis</option>
                    <option <?php if (@$resbilling['billing_currency'] == "GB Pounds") echo "Selected" ?>>GB Pounds</option>
                    <option <?php if (@$resbilling['billing_currency'] == "Euros") echo "Selected" ?>>Euros</option>
                    <option <?php if (@$resbilling['billing_currency'] == "Other") echo "Selected" ?>>Other</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="billing_period">Billing For *</label>
                <input type="text" class="form-control" id="billing_period"
                       placeholder="Select Date Billed For" value="<?php echo $resbilling['billing_period'] ?>">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="billing_amount">Amount Per Month *</label>
                <input type="text" class="form-control" id="billing_amount"
                       placeholder="Enter Billing Amount" onkeypress="return isNumberKey(event)"
                       value="<?php echo $resbilling['billing_amount'] ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="billing_months">Number of Months *</label>
                <input type="text" class="form-control" id="billing_months"
                       placeholder="Enter Number of Months" onkeypress="return isNumber(event)"
                       value="<?php echo $resbilling['billing_months'] ?>">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="billing_date">Date Billed *</label>
                <input type="text" class="form-control" id="billing_date"
                       placeholder="Select Date Billed For" value="<?php echo $resbilling['billing_date'] ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label>Bill Delivered *</label> <br/>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="billing_delivered1"
                           name="billing_delivered" value="Yes" class="custom-control-input"
                        <?php if (@$resbilling['billing_delivered'] == "Yes") echo "checked" ?>>
                    <label class="custom-control-label" for="billing_delivered1">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="billing_delivered2"
                           name="billing_delivered" value="No" class="custom-control-input"
                        <?php if (@$resbilling['billing_delivered'] == "No") echo "checked" ?>>
                    <label class="custom-control-label" for="billing_delivered2">No</label>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="billing_description">Description</label>
                <textarea class="form-control" id="billing_description"
                          placeholder="Enter Description"><?php echo $resbilling['billing_description'] ?></textarea>
            </div>
        </div>


    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="savebilling">Edit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->


<script>
    $("#billing_type").select2({placeholder: "Select Billing Type"});
    $("#billing_tenant").select2({placeholder: "Select Tenant"});
    $("#billing_currency").select2({placeholder: "Select Currency"});

    $('#billing_period').datepicker({
        format: 'yyyy-mm',
        autoclose: true,
        orientation: "bottom",
        viewMode: "months",
        minViewMode: "months"
    });

    $('#billing_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });

    $("#savebilling").click(function () {
        var billing_type = $("#billing_type").val();
        var billing_type_other = $("#billing_type_other").val();
        var billing_tenant = $("#billing_tenant").val();
        var billing_currency = $("#billing_currency").val();
        var billing_period = $("#billing_period").val();
        var billing_amount = $("#billing_amount").val();
        var billing_months = $("#billing_months").val();
        var billing_date = $("#billing_date").val();
        var billing_delivered = $('input[name=billing_delivered]:checked').val();
        var billing_description = $("#billing_description").val();
        var theindex = '<?php echo $theindex ?>';

        var error = '';
        if (billing_type == "") {
            error += 'Please billing type \n';
            $("#billing_type").focus();
        }
        if (billing_type == "Other" && billing_type_other == "") {
            error += 'Please specify other type \n';
            $("#billing_type_other").focus();
        }
        if (billing_type != "Other" && billing_type_other != "") {
            error += 'Please do not specify other type \n';
            $("#billing_type_other").focus();
        }
        if (billing_tenant == "") {
            error += 'Please select tenant\n';
            $("#billing_tenant").focus();
        }
        if (billing_currency == "") {
            error += 'Please select currency\n';
            $("#billing_currency").focus();
        }
        if (billing_period == "") {
            error += 'Please select billing period\n';
            $("#billing_period").focus();
        }
        if (billing_amount == "") {
            error += 'Please enter amount\n';
            $("#billing_amount").focus();
        }
        if (billing_months == "") {
            error += 'Please specify number of months\n';
            $("#billing_months").focus();
        }
        if (billing_date == "") {
            error += 'Please select date\n';
            $("#billing_date").focus();
        }
        if (billing_delivered == undefined) {
            error += 'Please specify whether bill is generated \n';
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/editform_adminbilling.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    billing_type: billing_type,
                    billing_type_other: billing_type_other,
                    billing_tenant: billing_tenant,
                    billing_currency:billing_currency,
                    billing_period:billing_period,
                    billing_amount:billing_amount,
                    billing_months:billing_months,
                    billing_date:billing_date,
                    billing_delivered:billing_delivered,
                    billing_description:billing_description,
                    theindex:theindex
                },
                success: function (text) {
                    //alert(text);
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/adminbilling_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#billingform_div').html(text);
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
                        url: "ajax/tables/adminbilling_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#billingtable_div').html(text);
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