<?php include('../../../config.php');
$pinq = $mysqli->query("select * from admin_staff ORDER BY id DESC");
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
                    <th>Staff Name</th>
                    <th>Staff Details</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                <?php
                while ($fetch = $pinq->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $fetch['staff_name']; ?></td>
                        <td><b>Employment Type :</b> <?php echo $fetch['employment_type']; ?> <br/>
                            <b>Staff ID :</b> <?php echo $fetch['staff_id']; ?> <br/>
                            <b>Staff Position :</b> <?php echo $fetch['staff_position']; ?> <br/>
                            <b>Staff Telephone :</b> <?php echo $fetch['staff_telephone']; ?> <br/>
                            <b>Staff Email :</b> <?php echo $fetch['staff_email']; ?> <br/>
                            <b>Staff Qualification :</b> <?php echo $fetch['staff_qualification']; ?> <br/>
                            <b>Department :</b> <?php echo $fetch['staff_department']; ?> <br/>
                            <b>Date Started :</b> <?php echo $fetch['date_started']; ?> <br/>

                        </td>
                        <td>

                            <button type="button"
                                    data-type="confirm"
                                    class="btn btn-sm btn-primary edit_staff"
                                    i_index="<?php echo $fetch['id']; ?>"
                                    title="Edit">
                                <i class="flaticon2-edit ml-1" style="color:#fff !important;"></i>
                            </button>
                            <p></p>
                            <button type="button"
                                    data-type="confirm"
                                    class="btn btn-sm btn-danger delete_staff"
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

    $(document).off('click', '.delete_staff').on('click', '.delete_staff', function () {
        var theindex = $(this).attr('i_index');
        //alert(theindex)
        $.confirm({
            title: 'Delete Staff!',
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
                            url: "ajax/queries/delete_adminstaff.php",
                            data: {
                                i_index: theindex
                            },
                            dataType: "html",
                            success: function (text) {
                                $.ajax({
                                    url: "ajax/tables/adminstaff_table.php",
                                    beforeSend: function () {
                                        KTApp.blockPage({
                                            overlayColor: "#000000",
                                            type: "v2",
                                            state: "success",
                                            message: "Please wait..."
                                        })
                                    },
                                    success: function (text) {
                                        $('#stafftable_div').html(text);
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

    $(document).off('click', '.edit_staff').on('click', '.edit_staff', function () {
        var theindex = $(this).attr('i_index');
        //alert(theindex)
        $.ajax({
            type: "POST",
            url: "ajax/forms/adminstaff_formedit.php",
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
                $('#staffform_div').html(text);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function () {
                KTApp.unblockPage();
            },
        });
    });
/*
    $(document).off('click', '.pay_salary').on('click', '.pay_salary', function () {
        var theindex = $(this).attr('i_index');
        //alert(theindex)
        $.ajax({
            type: "POST",
            url: "ajax/forms/adminstaffpay_form.php",
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
                $('#staffform_div').html(text);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function () {
                KTApp.unblockPage();
            },
        });
    });*/
</script>