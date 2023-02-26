<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
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
            <div class="col-lg-12 col-md-12">
                <label for="receiver_name">Receiver *</label>
                <input type="text" class="form-control" id="receiver_name"
                       placeholder="Enter name of receiver">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="payment_amount">Amount *</label>
                <input type="text" class="form-control" id="payment_amount"
                       placeholder="Enter Payment Amount" onkeypress="return isNumberKey(event)">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="payment_date">Date Paid *</label>
                <input type="text" class="form-control" id="payment_date"
                       placeholder="Select Date">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="payment_purpose">Purpose *</label>
                <textarea class="form-control" id="payment_purpose"
                          placeholder="Enter Purpose"></textarea>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="payment_description">Description</label>
                <textarea class="form-control" id="payment_description"
                          placeholder="Enter Description"></textarea>
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

    $('#payment_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });

    $("#savepayment").click(function () {
        var receiver_name = $("#receiver_name").val();
        var payment_amount = $("#payment_amount").val();
        var payment_date = $("#payment_date").val();
        var payment_purpose = $("#payment_purpose").val();
        var payment_description = $("#payment_description").val();

        var error = '';
        if (receiver_name == "") {
            error += 'Please enter name of receiver \n';
            $("#receiver_name").focus();
        }
        if (payment_amount == "") {
            error += 'Please enter amount \n';
            $("#payment_amount").focus();
        }
        if (payment_date == "") {
            error += 'Please select date of payment \n';
            $("#payment_date").focus();
        }
        if (payment_purpose == "") {
            error += 'Please enter purpose \n';
            $("#payment_purpose").focus();
        }
       
        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_adminpayment.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    receiver_name: receiver_name,
                    payment_amount: payment_amount,
                    payment_date: payment_date,
                    payment_purpose:payment_purpose,
                    payment_description:payment_description
                },
                success: function (text) {
                    //alert(text);
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/adminpayment_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#paymentform_div').html(text);
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
                        url: "ajax/tables/adminpayment_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#paymenttable_div').html(text);
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