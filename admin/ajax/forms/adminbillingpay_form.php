<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");

$theindex = $_POST['theindex'];

$getbilling = $mysqli->query("select * from admin_taymac_billing where id = '$theindex'");
$resbilling = $getbilling->fetch_assoc();
$currency = $resbilling['billing_currency'];
$tenant = $resbilling['billing_tenant'];
$gettenantname = $mysqli->query("select * from admin_taymac_tenant where id = '$tenant'");
$restenantname = $gettenantname->fetch_assoc();
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
                <label for="billing_period">Tenant Name</label>
                <input type="text" class="form-control" readonly
                       value="<?php echo $restenantname['tenant_name'] ?>"/>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="billing_period">Billing Type</label>
                <input type="text" class="form-control" readonly
                       value="<?php echo $billingtype = $resbilling['billing_type'];
                       if ($billingtype == "") {
                           echo $resbilling['billing_type_other'];
                       }
                       ?>"/>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="billing_period">Amount Billed</label>
                <input type="text" class="form-control" readonly
                       value="<?php echo getCurrency($currency).' '.number_format($resbilling['billing_total'],2) ?>"/>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="billing_period">Amount Paid</label>
                <input type="text" class="form-control" readonly
                       value="<?php echo getCurrency($currency).' '.$resbilling['amt_paid'] ?>"/>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="billing_period">Amount Left</label>
                <input type="text" class="form-control" readonly
                       value="<?php echo $amtleft =  getCurrency($currency).' '.number_format(($resbilling['billing_total'] - $resbilling['amt_paid']),2); ?>"/>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="billing_period">Update Payment</label>
                <input type="text" class="form-control" id="amount_paid" onkeypress="return isNumber(event)"
                       placeholder="Enter Amount"/>
            </div>
        </div>

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="savepayment">Submit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->



<script>


    $("#savepayment").click(function () {
        var amount_paid = $("#amount_paid").val();
        var theindex = '<?php echo $theindex; ?>';

        var error = '';
        if (amount_paid == "") {
            error += 'Please enter amount paid \n';
            $("#amount_paid").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_adminpaybill.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    amount_paid: amount_paid,
                    theindex: theindex
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