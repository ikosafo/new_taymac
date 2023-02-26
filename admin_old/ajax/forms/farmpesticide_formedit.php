<?php include('../../../config.php');
$random = rand(1, 10000) . date("Ymd");
$theindex = $_POST['theindex'];

$getpesticide = $mysqli->query("select * from farm_pesticide where id = '$theindex'");
$respesticide= $getpesticide->fetch_assoc();
?>
<!--begin::Form-->

<script>
    function isNumberKey(evt) {
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
                <label for="pesticide_name">Name of Pesticide</label>
                <input type="text" class="form-control" id="pesticide_name"
                       placeholder="Enter Name of Pesticide" value="<?php echo $respesticide['pesticide_name']; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="tunnel">Select Tunnel</label>
                <select id="tunnel" style="width: 100%">
                    <option value="">Select Tunnel</option>
                    <?php
                    $tunnel = $respesticide['tunnel'];
                    $gettunnel = $mysqli->query("select * from farm_funnel");
                    while ($restunnel = $gettunnel->fetch_assoc()) { ?>
                        <option <?php if (@$tunnel == $restunnel['id']) echo "Selected" ?>><?php echo $restunnel['funnel_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="product">Select Product</label>
                <select id="product" style="width: 100%">
                    <option value="">Select Product</option>
                    <?php
                    $product = $respesticide['product'];
                    $getproduct = $mysqli->query("select * from farm_products");
                    while ($resproduct = $getproduct->fetch_assoc()) { ?>
                        <option <?php if (@$product == $resproduct['id']) echo "Selected" ?>><?php echo $resproduct['product_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="input_kg">Weight (in kg)</label>
                <input type="text" class="form-control" id="input_kg"
                       onkeypress="return isNumberKey(event)"
                       placeholder="Enter Quantity" value="<?php echo $respesticide['input_kg'] ?>">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="input_g">Weight (in g)</label>
                <input type="text" class="form-control" id="input_g"
                       onkeypress="return isNumberKey(event)"
                       placeholder="Enter Quantity" value="<?php echo $respesticide['input_g'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="date_activity">Date of Activity</label>
                <input type="text" class="form-control" id="date_activity"
                       placeholder="Enter Date of Activity" value="<?php echo $respesticide['date_activity'] ?>">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="activity_description">Description</label>
                <textarea class="form-control" id="activity_description"
                          placeholder="Enter Description"><?php echo $respesticide['activity_description'] ?></textarea>
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <button type="button" class="btn btn-primary" id="editactivity">Edit</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </div>


    </div>

</form>
<!--end::Form-->


<script>
    $("#application_area").select2({placeholder: "Select Application Area"});
    $("#product").select2({placeholder: "Select Product"});
    $("#tunnel").select2({placeholder: "Select Tunnel"});

    $('#date_activity').datepicker({
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

    $('#editactivity').click(function () {
        var pesticide_name = $('#pesticide_name').val();
        var tunnel = $('#tunnel').val();
        var product = $('#product').val();
        var input_kg = $('#input_kg').val();
        var input_g = $('#input_g').val();
        var date_activity = $('#date_activity').val();
        var activity_description = $('#activity_description').val();
        var theindex = '<?php echo $theindex ?>';
        //alert(tunnel+' '+product);

        var error = '';
        if (pesticide_name == "") {
            error += 'Please select pesticide name \n';
            $("#pesticide_name").focus();
        }
        if (tunnel == "") {
            error += 'Please select tunnel \n';
        }
        if (product == "") {
            error += 'Please select product \n';
        }
        if (date_activity == "") {
            error += 'Please select date of activity \n';
            $("#date_activity").focus();
        }
        if (input_kg == "" && input_g == "") {
            error += 'Please select weight in kg or g\n';
            $("#input_kg").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/editform_farmpesticide.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    pesticide_name:pesticide_name,
                    tunnel:tunnel,
                    product:product,
                    input_kg:input_kg,
                    input_g:input_g,
                    date_activity:date_activity,
                    activity_description:activity_description,
                    theindex:theindex
                },
                success: function (text) {
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/farmpesticide_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farmpesticideform_div').html(text);
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
                        url: "ajax/tables/farmpesticide_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farmpesticidetable_div').html(text);
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