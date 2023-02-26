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
                                    Accounts Management
                                    <small>Cash Book</small>
                                </h3>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-4 col-md-4">
                                <label for="date_started">Year</label>
                                <input type="text" class="form-control" id="select_year"
                                       placeholder="Select Year">
                            </div>

                            <div class="col-lg-8 col-md-8">
                                <label for="search">Search</label> <br/>
                                <button type="button" class="btn btn-primary" id="search">Search</button>
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
    $('#select_year').datepicker({
        format: 'yyyy',
        autoclose: true,
        orientation: "bottom",
        viewMode: "years",
        minViewMode: "years"
    });

    $("#search").click(function(){
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();

        var error = '';
        if (start_date == "") {
            error += 'Please select start date\n';
            $("#start_date").focus();
        }
        if (end_date == "") {
            error += 'Please select end date\n';
            $("#end_date").focus();
        }
        if (start_date != "" && end_date != "" && start_date > end_date) {
            error += 'Please specify correct date range\n';
            $("#end_date").focus();
        }

        if (error == "") {
            $.ajax({
                method: "post",
                url: "ajax/tables/cashbook_table.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    start_date: start_date,
                    end_date: end_date
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

