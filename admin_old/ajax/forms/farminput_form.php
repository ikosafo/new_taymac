<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
?>
<!--begin::Form-->

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="input_name">Name of Input</label>
                <input type="text" class="form-control" id="input_name"
                       placeholder="Enter Input Name">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="input_type">Input Type</label>
                <select id="input_type" style="width: 100%">
                    <option value="">Select Input Type</option>
                    <option value="Fertilizer">Fertilizer</option>
                    <option value="Pesticide">Pesticide</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="input_type_other">If Input Type is 'Other', Specify</label>
                <input type="text" class="form-control" id="input_type_other"
                       placeholder="If Other, Specify">
            </div>
        </div>
  

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="saveinput">Submit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->



<script>

    $("#input_type").select2({placeholder: "Select Input Type"});

    $("#saveinput").click(function () {
        var input_name = $("#input_name").val();
        var input_type = $("#input_type").val();
        var input_type_other = $("#input_type_other").val();
        
        var error = '';
        if (input_name == "") {
            error += 'Please enter input name\n';
            $("#input_name").focus();
        }
        if (input_type == "") {
            error += 'Please enter input type\n';
            $("#input_type").focus();
        }
        if (input_type == "Other" && input_type_other == "") {
            error += 'Please specify other type \n';
            $("#input_type_other").focus();
        }
        if (input_type != "Other" && input_type_other != "") {
            error += 'Please do not specify other type \n';
            $("#input_type_other").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_farminput.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    input_name: input_name,
                    input_type: input_type,
                    input_type_other: input_type_other
                },
                success: function (text) {
                    //alert(text);
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/farminput_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farminputform_div').html(text);
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
                        url: "ajax/tables/farminput_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farminputtable_div').html(text);
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