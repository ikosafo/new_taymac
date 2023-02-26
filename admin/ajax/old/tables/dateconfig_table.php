<?php include('../../../config.php');


$ex_qu = $mysqli->query("select * from date_config ORDER BY registration_type");
$config_count = mysqli_num_rows($ex_qu);

if ($config_count == 0) {

    echo "";
} else {


?>


<div class="kt-section">

    <div class="kt-section__content responsive">

        <div class="table-responsive">
        <table
            class="table center-aligned-table">
            <thead>
            <tr>
                <th>Registration Type</th>
                <th>Opening Date</th>
                <th>Deadline</th>
                <th align="center">Action</th>
            </tr>
            </thead>
            <tbody>

            <?php
            while ($fetch_ex = $ex_qu->fetch_assoc()) {
                ?>

                <tr>
                    <td><?php echo $fetch_ex['registration_type'] ?></td>
                    <td><?php echo $fetch_ex['date_started'] ?></td>
                    <td><?php echo $fetch_ex['date_completed'] ?></td>

                    <td>
                        <button type="button"
                                class="btn btn-info edit_dateconfig"
                                i_index="<?php echo $fetch_ex['id']; ?>"
                                title="Edit"><i
                                class="flaticon2-edit ml-2" style="color:#fff !important;"></i>
                        </button>
                        <button type="button"
                                data-type="confirm"
                                class="btn btn-danger js-sweetalert delete_dateconfig"
                                i_index="<?php echo $fetch_ex['id']; ?>"
                                title="Delete">
                            <i class="flaticon2-trash ml-2" style="color:#fff !important;"></i>
                        </button>


                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
            </div>


    </div>
</div>

<?php } ?>




<script>

    $(document).on('click', '.edit_dateconfig', function () {
        var i_index = $(this).attr('i_index');

        $.ajax({
            type: "POST",
            url: "ajax/forms/dateconfig_formedit.php",
            data: {
                i_index: i_index
            },
            success: function (text) {
                $('#dateconfigform_div').html(text);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },


        });

    });

    $(document).off('click', '.delete_dateconfig').on('click', '.delete_dateconfig', function () {
        var theindex = $(this).attr('i_index');
        $.confirm({
            title: 'Delete Record!',
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
                            url: "ajax/queries/delete_dateconfig.php",
                            data: {
                                i_index: theindex
                            },
                            dataType: "html",
                            success: function (text) {
                                $.ajax({
                                    url: "ajax/tables/dateconfig_table.php",
                                    beforeSend: function () {
                                        KTApp.blockPage({
                                            overlayColor: "#000000",
                                            type: "v2",
                                            state: "success",
                                            message: "Please wait..."
                                        })
                                    },
                                    success: function (text) {
                                        $('#dateconfigtable_div').html(text);
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

</script>



