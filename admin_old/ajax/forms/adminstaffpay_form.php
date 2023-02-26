<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
$theindex = $_POST['theindex'];

$getstaff = $mysqli->query("select * from admin_staff where id = '$theindex'");
$resstaff = $getstaff->fetch_assoc();
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

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label>Staff Name</label>
                <input type="text" class="form-control" readonly
                       value="<?php echo $resstaff['staff_name'] ?>"/>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="payment_type">Select Payment Type</label>
                <select id="payment_type" style="width: 100%" onchange="SelectPayment(this.value);">
                    <option value="">Select Payment Type</option>
                    <option value="IOU">IOU</option>
                    <option value="Monthly Salary">Monthly Salary</option>
                </select>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="payment_for">Payment For</label>
                <input type="text" class="form-control" id="payment_for"
                       placeholder="Select Date Billed For">
            </div>
        </div>

        <div id="showiou" style="display: none">
            <div class="form-group row">
                <div class="col-lg-6 col-md-6">
                    <label for="payment_date">Payment Date</label>
                    <input type="text" class="form-control" id="payment_date"
                           placeholder="Select Payment Date">
                </div>
                <div class="col-lg-6 col-md-6">
                    <label for="iou_amount">IOU Amount</label>
                    <input type="text" class="form-control" id="iou_amount"
                           placeholder="Enter IOU Amount" onkeypress="return isNumberKey(event)">
                </div>
            </div>

            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <button type="button" class="btn btn-primary" id="saveiou">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>

        <div id="showsalary" style="display: none">
            <div class="form-group row">
                <div class="col-lg-6 col-md-6">
                    <label for="payment_date_salary">Payment Date</label>
                    <input type="text" class="form-control" id="payment_date_salary"
                           placeholder="Select Payment Date">
                </div>
            </div>
            CREDIT<br/><hr/>
            <div class="form-group row">
                <div class="col-lg-6 col-md-6">
                    <label for="gross_salary">Gross Salary</label>
                    <input type="text" class="form-control" id="gross_salary" value="0.00"
                           placeholder="Enter Gross Amount" onkeypress="return isNumberKey(event)">
                </div>
                <div class="col-lg-6 col-md-6">
                    <label for="allowance">Allowance / Bonus</label>
                    <input type="text" class="form-control" id="allowance" value="0.00"
                           placeholder="Enter Gross Amount" onkeypress="return isNumberKey(event)">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6 col-md-6">
                    <label for="overtime">Over Time</label>
                    <input type="text" class="form-control" id="overtime" value="0.00"
                           placeholder="Enter Over Time Amount" onkeypress="return isNumberKey(event)">
                </div>
                <div class="col-lg-6 col-md-6">
                    <label for="compensation">Compensation</label>
                    <input type="text" class="form-control" id="compensation" value="0.00"
                           placeholder="Enter Compensation" onkeypress="return isNumberKey(event)">
                </div>
            </div>

            DEBIT<br/><hr/>
            <div class="form-group row">
                <div class="col-lg-6 col-md-6">
                    <label for="iou_salary">IOU</label>
                    <input type="text" class="form-control" id="iou_salary" value="0.00"
                           placeholder="Enter Gross Amount" onkeypress="return isNumberKey(event)">
                </div>
                <div class="col-lg-6 col-md-6">
                    <label for="income_tax">Federal Income Tax</label>
                    <input type="text" class="form-control" id="income_tax" value="0.00"
                           placeholder="Enter Gross Amount" onkeypress="return isNumberKey(event)">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6 col-md-6">
                    <label for="ssnit">Social Security</label>
                    <input type="text" class="form-control" id="ssnit" value="0.00"
                           placeholder="Enter Over Time Amount" onkeypress="return isNumberKey(event)">
                </div>
                <div class="col-lg-6 col-md-6">
                    <label for="welfare">Welfare</label>
                    <input type="text" class="form-control" id="welfare" value="0.00"
                           placeholder="Enter Compensation" onkeypress="return isNumberKey(event)">
                </div>
            </div>

            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <button type="button" class="btn btn-primary" id="savesalary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>

    </div>

</form>
<!--end::Form-->

<script>
    function SelectPayment(val) {
        var element = document.getElementById('showiou');
        if (val == 'IOU')
            element.style.display = 'block';
        else
            element.style.display = 'none';

        var element2 = document.getElementById('showsalary');
        if (val == 'Monthly Salary')
            element2.style.display = 'block';
        else
            element2.style.display = 'none';

    }

</script>

<script>

    $("#payment_type").select2({placeholder: "Select Payment Type"});

    $('#payment_for').datepicker({
        format: 'yyyy-mm',
        autoclose: true,
        orientation: "bottom",
        viewMode: "months",
        minViewMode: "months"
    });

    $('#payment_date_salary').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });

    $('#payment_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });

    $("#saveiou").click(function () {
        var payment_for = $("#payment_for").val();
        var payment_date = $("#payment_date").val();
        var iou_amount = $("#iou_amount").val();
        var theindex = '<?php echo $theindex; ?>';

        var error = '';
        if (payment_for == "") {
            error += 'Please specify month and year paid for \n';
            $("#payment_for").focus();
        }
        if (payment_date == "") {
            error += 'Please select date \n';
            $("#payment_date").focus();
        }
        if (iou_amount == "") {
            error += 'Please enter IOU amount \n';
            $("#iou_amount").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_staffiou.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    payment_for: payment_for,
                    payment_date: payment_date,
                    iou_amount: iou_amount,
                    theindex:theindex
                },
                success: function (text) {
                    //alert(text);
                    window.location.href = "/admin/admin_staffpaydetails";
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

    $("#savesalary").click(function () {
        var payment_for = $("#payment_for").val();
        var payment_date_salary = $("#payment_date_salary").val();
        var gross_salary = $("#gross_salary").val();
        var allowance = $("#allowance").val();
        var overtime = $("#overtime").val();
        var compensation = $("#compensation").val();
        var iou_salary = $("#iou_salary").val();
        var income_tax = $("#income_tax").val();
        var ssnit = $("#ssnit").val();
        var welfare = $("#welfare").val();
        var theindex = '<?php echo $theindex; ?>';

        var error = '';
        if (payment_for == "") {
            error += 'Please specify month and year paid for \n';
            $("#payment_for").focus();
        }
        if (payment_date_salary == "") {
            error += 'Please select date \n';
            $("#payment_date_salary").focus();
        }
        if (gross_salary == "") {
            error += 'Please enter IOU amount \n';
            $("#gross_salary").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_staffsalary.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    payment_for: payment_for,
                    payment_date: payment_date_salary,
                    gross_salary: gross_salary,
                    allowance: allowance,
                    overtime: overtime,
                    compensation: compensation,
                    iou_salary: iou_salary,
                    income_tax: income_tax,
                    ssnit: ssnit,
                    welfare: welfare,
                    theindex:theindex
                },
                success: function (text) {
                    //alert(text);
                    window.location.href = "/admin/admin_staffpaydetails";
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