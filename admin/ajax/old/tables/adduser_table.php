<?php include('../../../config.php');

$query = $mysqli->query("select * from mis_users where see =1
ORDER BY full_name DESC");


?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>


<div class="kt-section">

    `
    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">
                        <i class="la la-search"></i>
                    </span></div>
                <input type="text" id="user_search" class="form-control" placeholder="Search Full Name or email address" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="prov-table" class="table" style="margin-top: 3% !important">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>User Type</th>
                        <th>Permissions</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    while ($result = $query->fetch_assoc()) {
                        $user_id = $result['user_id'];
                    ?>
                        <tr>
                            <td>
                                <?php echo $result['full_name'] ?>
                            </td>
                            <td>
                                <?php echo $result['username'] ?>
                            </td>
                            <td>
                                <?php echo $result['approval'] ?>
                            </td>

                            <td>
                                <?php $q = $mysqli->query("select * from permission where user_id = '$user_id'");
                                while ($r = $q->fetch_assoc()) {
                                ?>

                                    <i class="la la-angle-right"></i> <?php echo $r['permission'] ?><br />

                                <?php } ?>
                            </td>

                            <td>
                                <button type="button" data-type="confirm" class="btn btn-primary js-sweetalert edit_user mb-2" i_index="<?php echo $result['id']; ?>" user_index="<?php echo $result['user_id']; ?>" title="Edit">
                                    <i class="flaticon2-edit ml-2" style="color:#fff !important;"></i>
                                </button>

                                <button type="button" data-type="confirm" class="btn btn-danger delete_user" i_index="<?php echo $result['id']; ?>" user_index="<?php echo $result['user_id']; ?>" title="Delete">
                                    <i class="flaticon2-trash ml-2" style="color:#fff !important;"></i>
                                </button>


                            </td>

                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


<script>
    oTable = $('#prov-table').DataTable({
        "bLengthChange": false
    });

    $('#user_search').keyup(function() {
        oTable.search($(this).val()).draw();
    });

    $(document).off('click', '.edit_user').on('click', '.edit_user', function() {
        var theindex = $(this).attr('i_index');
        var user_index = $(this).attr('user_index');
        //alert(theindex)
        $.ajax({
            type: "POST",
            url: "ajax/forms/edituser_form.php",
            beforeSend: function() {
                KTApp.blockPage({
                    overlayColor: "#000000",
                    type: "v2",
                    state: "success",
                    message: "Please wait..."
                })
            },
            data: {
                theindex: theindex,
                user_index: user_index
            },
            success: function(text) {
                $('#userform_div').html(text);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function() {
                KTApp.unblockPage();
            },
        });
    });

    $(document).off('click', '.delete_user').on('click', '.delete_user', function() {
        var theindex = $(this).attr('i_index');
        var user_index = $(this).attr('user_index');
        //alert(theindex)
        $.confirm({
            title: 'Delete Record!',
            content: 'Are you sure to continue?',
            buttons: {
                no: {
                    text: 'No',
                    keys: ['enter', 'shift'],
                    backdrop: 'static',
                    keyboard: false,
                    action: function() {
                        $.alert('Data is safe');
                    }
                },
                yes: {
                    text: 'Yes, Delete it!',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.ajax({
                            type: "POST",
                            url: "ajax/queries/delete_user.php",
                            data: {
                                i_index: theindex,
                                user_index: user_index
                            },
                            dataType: "html",
                            success: function(text) {
                                $.ajax({
                                    url: "ajax/tables/adduser_table.php",
                                    beforeSend: function() {
                                        KTApp.blockPage({
                                            overlayColor: "#000000",
                                            type: "v2",
                                            state: "success",
                                            message: "Please wait..."
                                        })
                                    },
                                    success: function(text) {
                                        $('#usertable_div').html(text);
                                    },
                                    error: function(xhr, ajaxOptions, thrownError) {
                                        alert(xhr.status + " " + thrownError);
                                    },
                                    complete: function() {
                                        KTApp.unblockPage();
                                    },
                                });
                            },

                            complete: function() {},
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            }
                        });
                    }
                }
            }
        });


    });
</script>