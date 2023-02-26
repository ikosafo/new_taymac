<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
$theindex = $_POST['theindex'];

$getsm = $mysqli->query("select * from admin_taymac_sm where id = '$theindex'");
$ressm = $getsm->fetch_assoc();
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
                <label for="sm_type">Service Type *</label>
                <select id="sm_type" style="width: 100%">
                    <option value="">Select Service Type</option>
                    <option <?php if (@$ressm['sm_type'] == "Cleaning") echo "Selected" ?>>Cleaning</option>
                    <option <?php if (@$ressm['sm_type'] == "Air Conditioning") echo "Selected" ?>>Air Conditioning</option>
                    <option <?php if (@$ressm['sm_type'] == "Generators") echo "Selected" ?>>Generators</option>
                    <option <?php if (@$ressm['sm_type'] == "Electrical") echo "Selected" ?>>Electrical</option>
                    <option <?php if (@$ressm['sm_type'] == "Swimming Pool") echo "Selected" ?>>Swimming Pool</option>
                    <option <?php if (@$ressm['sm_type'] == "Other") echo "Selected" ?>>Other</option>
                </select>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="sm_type_other">If Service Type is 'Other', Specify</label>
                <input type="text" class="form-control" id="sm_type_other"
                       placeholder="If Other, Specify" value="<?php echo $ressm['sm_type_other'] ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="sm_tenant">Select Tenant *</label>
                <select id="sm_tenant" style="width: 100%">
                    <option value="">Select Tenant</option>
                    <?php
                    $sm_tenant = $ressm['sm_tenant'];
                    $gettenant = $mysqli->query("select * from admin_taymac_tenant");
                    while ($restenant = $gettenant->fetch_assoc()) { ?>
                        <option <?php if (@$sm_tenant == $restenant['id']) echo "Selected" ?>><?php echo $restenant['tenant_name'] ?></option>
                    <?php  } ?>
                </select>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="sm_currency">Currency *</label>
                <select id="sm_currency" style="width: 100%">
                    <option value="">Select Currency</option>
                    <option <?php if (@$ressm['sm_currency'] == "US Dollars") echo "Selected" ?>>US Dollars</option>
                    <option <?php if (@$ressm['sm_currency'] == "GH Cedis") echo "Selected" ?>>GH Cedis</option>
                    <option <?php if (@$ressm['sm_currency'] == "GB Pounds") echo "Selected" ?>>GB Pounds</option>
                    <option <?php if (@$ressm['sm_currency'] == "Euros") echo "Selected" ?>>Euros</option>
                    <option <?php if (@$ressm['sm_currency'] == "Other") echo "Selected" ?>>Other</option>
                </select>
            </div>
        </div>

        <div class="form-group row">

            <div class="col-lg-6 col-md-6">
                <label for="sm_amount">Cost *</label>
                <input type="text" class="form-control" id="sm_amount" value="<?php echo $ressm['sm_amount'] ?>"
                       placeholder="Enter Service Cost" onkeypress="return isNumberKey(event)">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="sm_date">Date Billed *</label>
                <input type="text" class="form-control" id="sm_date"
                       placeholder="Select Date Billed For" value="<?php echo $ressm['sm_date'] ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="sm_description">Description</label>
                <textarea class="form-control" id="sm_description"
                          placeholder="Enter Description"><?php echo $ressm['sm_description'] ?></textarea>
            </div>
        </div>


    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="savesm">Edit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->



<script>

    $("#sm_type").select2({placeholder: "Select Service Type"});
    $("#sm_tenant").select2({placeholder: "Select Tenant"});
    $("#sm_currency").select2({placeholder: "Select Currency"});

    $('#sm_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });

    $("#savesm").click(function () {
        var sm_type = $("#sm_type").val();
        var sm_type_other = $("#sm_type_other").val();
        var sm_tenant = $("#sm_tenant").val();
        var sm_currency = $("#sm_currency").val();
        var sm_amount = $("#sm_amount").val();
        var sm_date = $("#sm_date").val();
        var sm_description = $("#sm_description").val();
        var theindex = '<?php echo $theindex; ?>';

        var error = '';
        if (sm_type == "") {
            error += 'Please select Service type \n';
            $("#sm_type").focus();
        }
        if (sm_type == "Other" && sm_type_other == "") {
            error += 'Please specify other type \n';
            $("#sm_type_other").focus();
        }
        if (sm_type != "Other" && sm_type_other != "") {
            error += 'Please do specify other type \n';
            $("#sm_type_other").focus();
        }
        if (sm_tenant == "") {
            error += 'Please select tenant\n';
            $("#sm_tenant").focus();
        }
        if (sm_currency == "") {
            error += 'Please select currency\n';
            $("#sm_currency").focus();
        }
        if (sm_amount == "") {
            error += 'Please enter amount\n';
            $("#sm_amount").focus();
        }
        if (sm_date == "") {
            error += 'Please select date\n';
            $("#sm_date").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/editform_adminsm.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    sm_type: sm_type,
                    sm_type_other: sm_type_other,
                    sm_tenant: sm_tenant,
                    sm_currency:sm_currency,
                    sm_amount:sm_amount,
                    sm_date:sm_date,
                    sm_description:sm_description,
                    theindex:theindex
                },
                success: function (text) {
                    //alert(text);
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/adminsm_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#smform_div').html(text);
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
                        url: "ajax/tables/adminsm_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#smtable_div').html(text);
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