<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
?>
<!--begin::Form-->

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group">
            <label>Property Image</label>
            <input type="file" class="form-control" id="fp_image">
            <input type="hidden" id="selected"/>
        </div>

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="permissions">Status</label> <br/>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="property_status1"
                           name="property_status" value="For Rent" class="custom-control-input">
                    <label class="custom-control-label" for="property_status1">For Rent</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="property_status2"
                           name="property_status" value="For Sale" class="custom-control-input">
                    <label class="custom-control-label" for="property_status2">For Sale</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="property_type">Property Type</label>
                <input type="text" class="form-control" id="property_type"
                       placeholder="Enter Property Type">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="property_location">Location</label>
                <input type="text" class="form-control" id="property_location"
                       placeholder="Enter Location">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="fp_text">Property Description</label>
                <textarea class="form-control" id="fp_description"
                          placeholder="Enter Description"></textarea>
            </div>
        </div>



    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="savefp">Submit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->



<script>

    $('#fp_image').uploadifive({
        'auto': false,
        'method': 'post',
        'buttonText': 'Upload image',
        'fileType': 'image/*',
        'multi': false,
        'width': 180,
        'formData': {'randno': '<?php echo $random?>'},
        'dnd': false,
        'uploadScript': 'ajax/queries/upload_fp_image.php',
        'onUploadComplete': function (file, data) {
            console.log(data);
        },
        'onSelect': function (file) {
            // Update selected so we know they have selected a file
            $("#selected").val('yes');

        },
        'onCancel': function (file) {
            // Update selected so we know they have no file selected
            $("#selected").val('');
        }
    });


    $("#savefp").click(function () {
        var fp_description = $("#fp_description").val();
        var selected = $("#selected").val();
        var property_status = $('input[name=property_status]:checked').val();
        var property_type = $("#property_type").val();
        var property_location = $("#property_location").val();
        var imageid = '<?php echo $random; ?>';

        var error = '';
        if (fp_description == "") {
            error += 'Please enter description\n';
            $("#fp_description").focus();
        }
        if (selected == "") {
            error += 'Please upload image\n';
            $("#fp_text").focus();
        }
        if (property_status == "") {
            error += 'Please select property status\n';
        }
        if (property_type == "") {
            error += 'Please enter property type\n';
            $("#property_type").focus();
        }
        if (property_location == "") {
            error += 'Please enter property location\n';
            $("#property_location").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_fp.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    fp_description: fp_description,
                    property_status: property_status,
                    property_type: property_type,
                    property_location:property_location,
                    imageid:imageid
                },
                success: function (text) {
                    //alert(text);

                    $('#fp_image').uploadifive('upload');
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/addfp_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#fpform_div').html(text);
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
                        url: "ajax/tables/addfp_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#fptable_div').html(text);
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