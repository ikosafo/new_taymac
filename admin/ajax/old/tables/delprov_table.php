<?php include('../../../config.php');
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];
//$year_search = $_POST['year_search'];

?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>

<div class="kt-separator kt-separator--dashed"></div>

<div class="kt-section">
                    <span class="kt-section__info">
                       Provisional Applicant Registrations
                    </span>
    `
    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">
                                <i class="la la-search"></i>
                            </span></div>
                <input type="text" id="account_search" class="form-control"
                       placeholder="Search Full Name or email address" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="del-table" class="table" style="margin-top: 3% !important">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Payment</th>
                    <th>MIS <br/> Approval<br/> Status</th>
                    <th>Admin <br/> Approval<br/> Status</th>
                    <th>PIN</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>
</div>


<script>
    oTable = $('#del-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/provregdel.php'
        },
        'columns': [
            {data: 'fulldetails'},
            {data: 'email_address'},
            {data: 'payment'},
            {data: 'mis_status'},
            {data: 'admin_status'},
            {data: 'pin'},
            {data: 'action'}
        ]
    });
    $('#account_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });



    $(document).off('click', '.deleteprov_btn').on('click', '.deleteprov_btn', function () {
        var i_index = $(this).attr('i_index');
        //alert(i_index);

        $.confirm({
            title: 'Delete Provisional Registration Details!',
            content: 'Are you sure to continue?<br/><small>You will not be able to recover details</small>',
            buttons: {
                no: {
                    text: 'No',
                    keys: ['enter', 'shift'],
                    backdrop: 'static',
                    keyboard: false,
                    action: function () {
                        $.alert('Details are safe!');
                    }
                },
                yes: {
                    text: 'Yes, Continue!',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.ajax({
                            type: "POST",
                            url: "ajax/queries/delete_provreg.php",
                            data: {
                                i_index: i_index
                            },
                            dataType: "html",
                            success: function (text) {
                                alert(text);
                                if (text == '1') {
                                    $.ajax({
                                        url: "ajax/tables/delprov_table.php",
                                        beforeSend: function () {
                                            KTApp.blockPage({
                                                overlayColor: "#000000",
                                                type: "v2",
                                                state: "success",
                                                message: "Please wait..."
                                            })
                                        },
                                        success: function (text) {
                                            $('#appinfo_table_div').html(text);
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
                                    alert ("You cannot delete provisional reg. data");
                                }
                               

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