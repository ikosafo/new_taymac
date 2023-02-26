<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
$theindex = $_POST['theindex'];

$getproperty = $mysqli->query("select * from admin_taymac_property where id = '$theindex'");
$resproperty = $getproperty->fetch_assoc();
?>
<!--begin::Form-->
<small style="color: red">Field Marked * are required</small>

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="property_name">Name of Property *</label>
                <input type="text" class="form-control" id="property_name"
                       placeholder="Enter Property Name" value="<?php echo $resproperty['property_name']; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="property_type">Property Type *</label>
                <select id="property_type" style="width: 100%">
                    <option value="">Select Property Type</option>
                    <option <?php if (@$resproperty['property_type'] == "Shop") echo "Selected" ?>>Shop</option>
                    <option <?php if (@$resproperty['property_type'] == "Apartment") echo "Selected" ?>>Apartment</option>
                    <option <?php if (@$resproperty['property_type'] == "House") echo "Selected" ?>>House</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="property_location">Location of Property *</label>
                <input type="text" class="form-control" id="property_location"
                       placeholder="Enter Property Name" value="<?php echo $resproperty['property_location']; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="property_address">Address</label>
                <textarea class="form-control" id="property_address"
                          placeholder="Enter property Text"><?php echo $resproperty['property_address']; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="property_description">Description</label>
                <textarea class="form-control" id="property_description"
                          placeholder="Enter property Text"><?php echo $resproperty['property_description']; ?></textarea>
            </div>
        </div>

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="editproperty">Edit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->



<script>

    $("#property_type").select2({placeholder: "Select Property Type"});

    $("#editproperty").click(function () {
        var property_name = $("#property_name").val();
        var property_type = $("#property_type").val();
        var property_location = $("#property_location").val();
        var property_address = $("#property_address").val();
        var property_description = $("#property_description").val();
        var theindex = '<?php echo $theindex; ?>';

        var error = '';
        if (property_name == "") {
            error += 'Please enter property name\n';
            $("#property_name").focus();
        }
        if (property_type == "") {
            error += 'Please enter property type\n';
            $("#property_type").focus();
        }
        if (property_location == "") {
            error += 'Please enter location\n';
            $("#property_location").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/editform_adminproperty.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    property_name: property_name,
                    property_type: property_type,
                    property_location: property_location,
                    property_address:property_address,
                    property_description:property_description,
                    theindex:theindex
                },
                success: function (text) {
                    //alert(text);
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/adminproperty_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#propertyform_div').html(text);
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
                        url: "ajax/tables/adminproperty_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#propertytable_div').html(text);
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