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
                <label for="product">Select Product</label>
                <select id="product" style="width: 100%">
                    <option value="">Select Product</option>
                    <?php $getproduct = $mysqli->query("select * from farm_purchases");
                    while ($resproduct= $getproduct->fetch_assoc()) { ?>
                        <option value="<?php echo $resproduct['item_name'] ?>"><?php echo $resproduct['item_name'] ?></option>
                    <?php  } ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="date_harvest">Date of Harvest</label>
                <input type="text" class="form-control" id="date_harvest"
                       placeholder="Enter Date of Harvest">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="input_kg">Weight Harvested (in kg)</label>
                <input type="text" class="form-control" id="input_kg"
                       onkeypress="return isNumberKey(event)"
                       placeholder="Enter Quantity">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="input_g">Weight Harvested (in g)</label>
                <input type="text" class="form-control" id="input_g"
                       onkeypress="return isNumberKey(event)"
                       placeholder="Enter Quantity">
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <button type="button" class="btn btn-primary" id="saveharvest">Submit</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </div>


    </div>

</form>
<!--end::Form-->


<script>
    $("#product").select2({placeholder: "Select Product"});

    $('#date_harvest').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });

    $("#input_kg").keyup(function () {
        var input_kg = $(this).val();
        $("#input_g").val(input_kg * 1000);
    });
    $("#input_g").keyup(function () {
        var input_g = $(this).val();
        $("#input_kg").val(input_g / 1000);
    });

    $('#saveharvest').click(function () {
        var product = $('#product').val();
        var date_harvest = $('#date_harvest').val();
        var input_kg = $('#input_kg').val();
        var input_g = $('#input_g').val();

        var error = '';
        if (product == "") {
            error += 'Please select product \n';
        }
        if (date_harvest == "") {
            error += 'Please enter of sale \n';
        }
        if (input_kg == "" && input_g=="") {
            error += 'Please select weight in kg or g\n';
            $("#input_kg").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_farmharvest.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    product: product,
                    input_kg: input_kg,
                    input_g: input_g,
                    date_harvest:date_harvest
                },
                success: function (text) {
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/farmharvest_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farmharvestform_div').html(text);
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
                        url: "ajax/tables/farmharvest_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farmharvesttable_div').html(text);
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