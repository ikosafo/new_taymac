<?php require('includes/header.php') ?>

<!-- begin:: Subheader -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader"></div>
<!-- end:: Subheader -->


<!-- begin:: Content -->
<div class="kt-container  kt-grid__item kt-grid__item--fluid">
    <!--Begin::Dashboard 3-->

    <div class="row">
        <div class="col-xl-12">
            <!--begin:: Widgets/Applications/User/Profile3-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__body">
                    <div class="kt-portlet__body">


                        <div class="kt-portlet__head kt-portlet__head--lg mb-4">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Property Management
                                    <small>Search Service and Maintenance Type</small>
                                </h3>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6">
                                <label for="sm_type">Select Bill Type</label>
                                <select id="sm_type" style="width: 100%">
                                    <option value="">Select Service Type</option>
                                    <option value="Cleaning">Cleaning</option>
                                    <option value="Air Conditioning">Air Conditioning</option>
                                    <option value="Generators">Generators</option>
                                    <option value="Electrical">Electrical</option>
                                    <option value="Swimming Pool">Swimming Pool</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div id="searchptable_div"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--end:: Widgets/Applications/User/Profile3-->
        </div>
    </div>

</div>
<!--End::Dashboard 3-->
<!-- end:: Content -->

<?php require('includes/footer.php') ?>

<script>
    $("#sm_type").select2({placeholder: "Select Service and Maintenance Type"});

    $("#sm_type").change(function(){
        var sm_type = $("#sm_type").val();
        //alert(select_bill);

        $.ajax({
            method:"post",
            url: "ajax/tables/searchservice_table.php",
            beforeSend: function () {
                KTApp.blockPage({
                    overlayColor: "#000000",
                    type: "v2",
                    state: "success",
                    message: "Please wait..."
                })
            },
            data:{
                select_sm:sm_type
            },
            success: function (text) {
                $('#searchptable_div').html(text);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function () {
                KTApp.unblockPage();
            },

        });
    });


</script>

