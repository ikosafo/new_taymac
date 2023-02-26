<?php include('../../../config.php');
$random = rand(1, 10000) . date("Ymd");
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
                <label for="cycle">Select Cycle</label>
                <select id="cycle" style="width: 100%">
                    <option value="">Select Cycle</option>
                    <option value="First">First</option>
                    <option value="Second">Second</option>
                    <option value="Third">Third</option>
                    <option value="Fourth">Fourth</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
                <div class="col-lg-6 col-md-6">
                   <label for="tunnel">Select Tunnel</label>
                    <select id="tunnel" style="width: 100%">
                        <option value="">Select Tunnel</option>
                        <?php $gettunnel = $mysqli->query("select * from farm_funnel");
                        while ($restunnel = $gettunnel->fetch_assoc()) { ?>
                            <option
                                value="<?php echo $restunnel['id'] ?>"><?php echo $restunnel['funnel_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-lg-6 col-md-6">
                    <label for="product">Select Product</label>
                    <select id="product" style="width: 100%">
                        <option value="">Select Product</option>
                        <?php $getproduct = $mysqli->query("select * from farm_products");
                        while ($resproduct = $getproduct->fetch_assoc()) { ?>
                            <option
                                value="<?php echo $resproduct['id'] ?>"><?php echo $resproduct['product_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="time_start">Time Start</label>
                <input type="text" class="form-control" id="time_start"
                       placeholder="Enter Start Time">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="time_end">Time End</label>
                <input type="text" class="form-control" id="time_end"
                       placeholder="Enter End Time">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="input_kg">Amount (in l)</label>
                <input type="text" class="form-control" id="input_kg"
                       onkeypress="return isNumberKey(event)"
                       placeholder="Enter Amount">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="input_g">Amount (in ml)</label>
                <input type="text" class="form-control" id="input_g"
                       onkeypress="return isNumberKey(event)"
                       placeholder="Enter Amount">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6 col-md-6">
                <label for="date_activity">Date of Activity</label>
                <input type="text" class="form-control" id="date_activity"
                       placeholder="Enter Date of Activity">
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="activity_description">Description</label>
                <textarea class="form-control" id="activity_description"
                          placeholder="Enter Description"></textarea>
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <button type="button" class="btn btn-primary" id="saveactivity">Submit</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </div>


    </div>

</form>
<!--end::Form-->


<script>
    $("#cycle").select2({placeholder: "Select Cycle"});
    $("#product").select2({placeholder: "Select Product"});
    $("#tunnel").select2({placeholder: "Select Tunnel"});

    $('#date_activity').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation: "bottom"
    });

    $('#time_start').datetimepicker({
        autoclose: true,
        orientation: "bottom"
    });

    $('#time_end').datetimepicker({
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

    $('#saveactivity').click(function () {
        var cycle = $('#cycle').val();
        var tunnel = $('#tunnel').val();
        var product = $('#product').val();
        var input_kg = $('#input_kg').val();
        var input_g = $('#input_g').val();
        var date_activity = $('#date_activity').val();
        var time_start = $('#time_start').val();
        var time_end = $('#time_end').val();
        var activity_description = $('#activity_description').val();

        var error = '';
        if (cycle == "") {
            error += 'Please select cycle \n';
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
        if (time_start == "") {
            error += 'Please select time start \n';
            $("#time_start").focus();
        }
        if (time_end == "") {
            error += 'Please select time end \n';
            $("#time_end").focus();
        }
        if (time_start != "" && time_end != "" && time_start > time_end) {
            error += 'Please select correct time range \n';
            $("#time_end").focus();
        }
        if (input_kg == "" && input_g == "") {
            error += 'Please select weight in l or ml\n';
            $("#input_kg").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_farmwatering.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    cycle:cycle,
                    tunnel:tunnel,
                    product:product,
                    time_start:time_start,
                    time_end:time_end,
                    input_kg:input_kg,
                    input_g:input_g,
                    date_activity:date_activity,
                    activity_description:activity_description
                },
                success: function (text) {
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/farmwatering_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farmwateringform_div').html(text);
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
                        url: "ajax/tables/farmwatering_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farmwateringtable_div').html(text);
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