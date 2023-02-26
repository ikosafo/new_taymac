<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
?>
<!--begin::Form-->

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="product_name">Name of Product</label>
                <input type="text" class="form-control" id="product_name"
                       placeholder="Enter Product Name">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="product_type">Product Type</label>
                <select id="product_type" style="width: 100%">
                    <option value="">Select Product Type</option>
                    <option value="Vegetable">Vegetable</option>
                    <option value="Fruit">Fruit</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="product_type_other">If Product Type is 'Other', Specify</label>
                <input type="text" class="form-control" id="product_type_other"
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

    $("#product_type").select2({placeholder: "Select Product Type"});

    $("#saveinput").click(function () {
        var product_name = $("#product_name").val();
        var product_type = $("#product_type").val();
        var product_type_other = $("#product_type_other").val();

        var error = '';
        if (product_name == "") {
            error += 'Please enter product name\n';
            $("#product_name").focus();
        }
        if (product_type == "") {
            error += 'Please enter product type\n';
            $("#product_type").focus();
        }
        if (product_type == "Other" && product_type_other == "") {
            error += 'Please specify other type \n';
            $("#product_type_other").focus();
        }
        if (product_type != "Other" && product_type_other != "") {
            error += 'Please do not specify other type \n';
            $("#product_type_other").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_farmproduct.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    product_name: product_name,
                    product_type: product_type,
                    product_type_other: product_type_other
                },
                success: function (text) {
                    //alert(text);
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/farmproduct_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farmproductform_div').html(text);
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
                        url: "ajax/tables/farmproduct_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farmproducttable_div').html(text);
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