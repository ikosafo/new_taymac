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
                       Applicant Login Account Registrations
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
            <table id="acc-table" class="table" style="margin-top: 3% !important">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Date Account Created</th>
                    <th>Email Verified</th>
                    <th>Date Email Verified</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>
</div>


<script>
    oTable = $('#acc-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/useraccountsdel.php'
        },
        'columns': [
            {data: 'first_name'},
            {data: 'email_address'},
            {data: 'period'},
            {data: 'email_verified'},
            {data: 'email_verified_period'},
            {data: 'action'}
        ]
    });
    $('#account_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });



    $(document).off('click', '.deleteacc_btn').on('click', '.deleteacc_btn', function () {
        var i_index = $(this).attr('i_index');
        //alert(i_index);

        $.confirm({
            title: 'Delete Login Details!',
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
                            url: "ajax/queries/delete_loginaccount.php",
                            data: {
                                i_index: i_index
                            },
                            dataType: "html",
                            success: function (text) {
                                //alert(text);
                                if (text == 1) {
                                    $.ajax({
                                        url: "ajax/tables/delacc_table.php",
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
                                    alert('Applicant Email is already verified');
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