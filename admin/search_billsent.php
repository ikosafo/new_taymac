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
                                    <small>Search Bill Delivered</small>
                                </h3>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6">
                                <label for="billing_sent">Select Bill Delivered Status</label>
                                <select id="billing_sent" style="width: 100%">
                                    <option value="">Select Bill Delivered Status</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
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
    $("#billing_sent").select2({placeholder: "Select Bill Delivered"});

    $("#billing_sent").change(function(){
        var select_bill = $("#billing_sent").val();
        //alert(select_bill);

        $.ajax({
            method:"post",
            url: "ajax/tables/searchbillsent_table.php",
            beforeSend: function () {
                KTApp.blockPage({
                    overlayColor: "#000000",
                    type: "v2",
                    state: "success",
                    message: "Please wait..."
                })
            },
            data:{
                select_bill:select_bill
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

