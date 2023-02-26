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
                                    Staff Management
                                    <small>Search Payment</small>
                                </h3>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-4 col-md-4">
                                <label for="select_staff">Select Staff</label>
                                <select id="select_staff" style="width: 100%">
                                    <option value="">Select staff</option>
                                    <?php $getstaff = $mysqli->query("select * from admin_staff ORDER BY staff_name");
                                    while ($resstaff = $getstaff->fetch_assoc()) { ?>
                                        <option value="<?php echo $resstaff['id'] ?>"><?php echo $resstaff['staff_name'] ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label for="payment_type">Payment Type</label>
                                <select id="payment_type" style="width: 100%">
                                    <option value="">Select Payment Type</option>
                                    <option value="IOU">IOU</option>
                                    <option value="Salary">Salary</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label for="">Search</label> <br/>
                                <button type="button" class="btn btn-primary" id="search">Search</button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-3 col-md-3">

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
    $("#select_staff").select2({placeholder: "Select Staff"});
    $("#payment_type").select2({placeholder: "Select Payment Type"});

    $("#search").click(function(){
        var select_staff = $("#select_staff").val();
        var payment_type = $("#payment_type").val();

        var error = '';
        if (select_staff == "") {
            error += 'Please select staff\n';
        }
        if (payment_type == "") {
            error += 'Please select payment type\n';
            $("#payment_type").focus();
        }

        if (error == "") {
            $.ajax({
                method: "post",
                url: "ajax/tables/searchstaffpay_table.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    select_staff: select_staff,
                    payment_type: payment_type
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
        }
        else {
            $.notify(error, {position: "top center"});
        }
        return false;
    });


</script>

