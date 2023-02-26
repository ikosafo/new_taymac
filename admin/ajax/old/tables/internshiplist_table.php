<?php include('../../../config.php');


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
                <input type="text" id="internshiplist_search" class="form-control" placeholder="Search Applicant" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="list_table" class="table" style="margin-top: 3% !important">
                <thead>
                    <tr>
                        <th>Full Name of Intern/Professional</th>
                        <th>PIN</th>
                        <th>Place of Posting</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>


<script>
    oTable = $('#list_table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/internshiplist.php'
        },
        'columns': [{
                data: 'fullname'
            },
            {
                data: 'pin'
            },
            {
                data: 'placeofposting'
            },
            {
                data: 'internid'
            }
        ]
    });
    $('#internshiplist_search').keyup(function() {
        oTable.search($(this).val()).draw();
    });

    $(document).off('click', '.delete_intern').on('click', '.delete_intern', function() {
        var theindex = $(this).attr('i_index');
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
                            url: "ajax/queries/delete_internlist.php",
                            data: {
                                i_index: theindex
                            },
                            dataType: "html",
                            success: function(text) {
                                //alert(text);
                                $.ajax({
                                    url: "ajax/tables/internshiplist_table.php",
                                    beforeSend: function() {
                                        KTApp.blockPage({
                                            overlayColor: "#000000",
                                            type: "v2",
                                            state: "success",
                                            message: "Please wait..."
                                        })
                                    },
                                    success: function(text) {
                                        $('#internshiplist_table_div').html(text);
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