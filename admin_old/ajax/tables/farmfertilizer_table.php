<?php include('../../../config.php');
$pinq = $mysqli->query("select * from farm_fertilizer ORDER BY id DESC");
?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>


<div class="kt-section">

    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">
                                <i class="la la-search"></i>
                            </span></div>
                <input type="text" id="data_search" class="form-control"
                       placeholder="Search..." aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="data-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Details</th>
                    <th>Date of Activity</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                <?php
                while ($fetch = $pinq->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $fetch['fertilizer_name']; ?></td>
                        <td><b>Application Area :</b> <?php echo $fetch['application_area']; ?><br/>
                            <b>Tunnel :</b> <?php $tunnel = $fetch['tunnel'];
                            $gettunnelname = $mysqli->query("select * from farm_funnel where id = '$tunnel'");
                            $restunnelname = $gettunnelname->fetch_assoc();
                            echo $restunnelname['funnel_name'];
                            ?> <br/>
                            <b>Product :</b> <?php $product = $fetch['product'];
                            $getproductname = $mysqli->query("select * from farm_products where id = '$product'");
                            $resproductname = $getproductname->fetch_assoc();
                            echo $resproductname['product_name'];
                            ?> <br/>
                            <b>Weight :</b> <?php echo $fetch['input_kg']." kg"; ?>
                        </td>
                         <td><?php echo $fetch['date_activity']; ?></td>
                         <td><?php echo $fetch['activity_description']; ?></td>
                        <td>
                            <button type="button"
                                    data-type="confirm"
                                    class="btn btn-sm btn-primary edit_fertilizer"
                                    i_index="<?php echo $fetch['id']; ?>"
                                    title="Edit">
                                <i class="flaticon2-edit ml-1" style="color:#fff !important;"></i>
                            </button>
                            <p></p>
                            <button type="button"
                                    data-type="confirm"
                                    class="btn btn-sm btn-danger delete_fertilizer"
                                    i_index="<?php echo $fetch['id']; ?>"
                                    title="Delete">
                                <i class="flaticon2-trash ml-1" style="color:#fff !important;"></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<script>
    oTable = $('#data-table').DataTable({
        "bLengthChange": false,"order": []
    });

    $('#data_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

    $(document).off('click', '.delete_fertilizer').on('click', '.delete_fertilizer', function () {
        var theindex = $(this).attr('i_index');
        //alert(theindex)
        $.confirm({
            title: 'Delete Fertilizer Application Activity!',
            content: 'Are you sure to continue?',
            buttons: {
                no: {
                    text: 'No',
                    keys: ['enter', 'shift'],
                    backdrop: 'static',
                    keyboard: false,
                    action: function () {
                        $.alert('Data is safe');
                    }
                },
                yes: {
                    text: 'Yes, Delete it!',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.ajax({
                            type: "POST",
                            url: "ajax/queries/delete_farmfertilizer.php",
                            data: {
                                i_index: theindex
                            },
                            dataType: "html",
                            success: function (text) {
                                $.ajax({
                                    url: "ajax/tables/farmfertilizer_table.php",
                                    beforeSend: function () {
                                        KTApp.blockPage({
                                            overlayColor: "#000000",
                                            type: "v2",
                                            state: "success",
                                            message: "Please wait..."
                                        })
                                    },
                                    success: function (text) {
                                        $('#farmfertilizertable_div').html(text);
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        alert(xhr.status + " " + thrownError);
                                    },
                                    complete: function () {
                                        KTApp.unblockPage();
                                    },
                                });
                            },

                            complete: function () {
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            }
                        });
                    }
                }
            }
        });
    });

    $(document).off('click', '.edit_fertilizer').on('click', '.edit_fertilizer', function () {
        var theindex = $(this).attr('i_index');
        //alert(theindex)
        $.ajax({
            type: "POST",
            url: "ajax/forms/farmfertilizer_formedit.php",
            beforeSend: function () {
                KTApp.blockPage({
                    overlayColor: "#000000",
                    type: "v2",
                    state: "success",
                    message: "Please wait..."
                })
            },
            data:{
                theindex:theindex
            },
            success: function (text) {
                $('#farmfertilizerform_div').html(text);
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