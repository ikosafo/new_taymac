<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
?>
<!--begin::Form-->

<script>
    function isNumberKey(evt)
    {
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
                <label for="account_type">Select Account Type</label>
                <select id="account_type" style="width: 100%" onchange="SelectType(this.value);">
                    <option value="">Select Account Type</option>
                    <option value="Income">Income</option>
                    <option value="Expenditure">Expenditure</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <div id="show_income" style="display: none">
            <div class="form-group row">
                <div class="col-lg-12 col-md-12">
                    <label for="income_source">Source</label>
                    <input type="text" class="form-control" id="income_source"
                           placeholder="Enter Income Source">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 col-md-12">
                    <label for="income_date">Date</label>
                    <input type="text" class="form-control" id="income_date"
                           placeholder="Select Date">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 col-md-12">
                    <label for="income_amount">Amount</label>
                    <input type="text" class="form-control" id="income_amount"
                           onkeypress="return isNumberKey(event)"
                           placeholder="Enter Amount">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 col-md-12">
                    <label for="income_description">Description</label>
                <textarea class="form-control" id="income_description"
                          placeholder="Enter Description"></textarea>
                </div>
            </div>
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <button type="button" class="btn btn-primary" id="saveincome">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>

        <div id="show_expenditure" style="display: none">
            <div class="form-group row">
                <div class="col-lg-12 col-md-12">
                    <label for="expense_source">Expense</label>
                    <input type="text" class="form-control" id="expense_source"
                           placeholder="Enter Expenditure">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 col-md-12">
                    <label for="expense_date">Date</label>
                    <input type="text" class="form-control" id="expense_date"
                           placeholder="Select Date">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 col-md-12">
                    <label for="expense_amount">Amount</label>
                    <input type="text" class="form-control" id="expense_amount"
                           onkeypress="return isNumberKey(event)"
                           placeholder="Enter Amount">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 col-md-12">
                    <label for="expense_description">Description</label>
                <textarea class="form-control" id="expense_description"
                          placeholder="Enter Description"></textarea>
                </div>
            </div>
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <button type="button" class="btn btn-primary" id="saveexpense">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>

        <div id="show_other" style="display: none">
            <div class="form-group row">
                <div class="col-lg-12 col-md-12">
                    <label for="other_source">Specify Account</label>
                    <input type="text" class="form-control" id="other_source"
                           placeholder="Enter Account">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 col-md-12">
                    <label for="other_date">Date</label>
                    <input type="text" class="form-control" id="other_date"
                           placeholder="Select Date">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 col-md-12">
                    <label for="other_amount">Amount</label>
                    <input type="text" class="form-control" id="other_amount"
                           onkeypress="return isNumberKey(event)"
                           placeholder="Enter Amount">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 col-md-12">
                    <label for="other_description">Description</label>
                <textarea class="form-control" id="other_description"
                          placeholder="Enter Description"></textarea>
                </div>
            </div>
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <button type="button" class="btn btn-primary" id="saveother">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>

    </div>

</form>
<!--end::Form-->


<script>
    function SelectType(val) {
        var element = document.getElementById('show_income');
        if (val == 'Income')
            element.style.display = 'block';
        else
            element.style.display = 'none';

        var element2 = document.getElementById('show_expenditure');
        if (val == 'Expenditure')
            element2.style.display = 'block';
        else
            element2.style.display = 'none';

        var element3 = document.getElementById('show_other');
        if (val == 'Other')
            element3.style.display = 'block';
        else
            element3.style.display = 'none';
    }

</script>


<script>

    $("#account_type").select2({placeholder: "Select Account Type"});

    $('#income_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });

    $('#expense_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });

    $('#other_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });

    $('#saveincome').click(function () {
        var account_type = $('#account_type').val();
        var income_source = $('#income_source').val();
        var income_date = $('#income_date').val();
        var income_amount = $('#income_amount').val();
        var income_description = $('#income_description').val();

        var error = '';
        if (account_type == "") {
            error += 'Please specify account type \n';
        }
        if (income_source == "") {
            error += 'Please make input \n';
            $("#income_source").focus();
        }
        if (income_date == "") {
            error += 'Please select date \n';
            $("#income_date").focus();
        }
        if (income_amount == "") {
            error += 'Please enter amount \n';
            $("#income_amount").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_accentry.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    account_type: account_type,
                    source: income_source,
                    date: income_date,
                    amount:income_amount,
                    description:income_description
                },
                success: function (text) {

                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/accentry_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#accentryform_div').html(text);
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
                        url: "ajax/tables/accentry_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#accentrytable_div').html(text);
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


    $('#saveexpense').click(function () {
        var account_type = $('#account_type').val();
        var expense_source = $('#expense_source').val();
        var expense_date = $('#expense_date').val();
        var expense_amount = $('#expense_amount').val();
        var expense_description = $('#expense_description').val();

        var error = '';
        if (account_type == "") {
            error += 'Please specify account type \n';
        }
        if (expense_source == "") {
            error += 'Please make input \n';
            $("#expense_source").focus();
        }
        if (expense_date == "") {
            error += 'Please select date \n';
            $("#expense_date").focus();
        }
        if (expense_amount == "") {
            error += 'Please enter amount \n';
            $("#expense_amount").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_accentry.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    account_type: account_type,
                    source: expense_source,
                    date: expense_date,
                    amount:expense_amount,
                    description:expense_description
                },
                success: function (text) {

                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/accentry_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#accentryform_div').html(text);
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
                        url: "ajax/tables/accentry_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#accentrytable_div').html(text);
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


    $('#saveother').click(function () {
        var account_type = $('#account_type').val();
        var other_source = $('#other_source').val();
        var other_date = $('#other_date').val();
        var other_amount = $('#other_amount').val();
        var other_description = $('#other_description').val();

        var error = '';
        if (account_type == "") {
            error += 'Please specify account type \n';
        }
        if (other_source == "") {
            error += 'Please make input \n';
            $("#other_source").focus();
        }
        if (other_date == "") {
            error += 'Please select date \n';
            $("#expense_date").focus();
        }
        if (other_amount == "") {
            error += 'Please enter amount \n';
            $("#expense_amount").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_accentry.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    account_type: account_type,
                    source: other_source,
                    date: other_date,
                    amount:other_amount,
                    description:other_description
                },
                success: function (text) {

                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/accentry_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#accentryform_div').html(text);
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
                        url: "ajax/tables/accentry_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#accentrytable_div').html(text);
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