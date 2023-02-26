<?php include('../../../config.php');


?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>

<div class="kt-section">
                    <span class="kt-section__info">
                       Bulk SMS/Email Messages
                    </span>
    `
    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">
                                <i class="la la-search"></i>
                            </span></div>
                <input type="text" id="message_search" class="form-control"
                       placeholder="Search Applicant Type, Subject or Message" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="mail-table" class="table" style="margin-top: 3% !important">
                <thead>
                <tr>
                    <th>Subject</th>
                    <th>Applicant</th>
                    <th>Message</th>
                    <th>Date Sent</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>
</div>


<script>
    oTable = $('#mail-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/mailsms.php'
        },
        'columns': [
            {data: 'subject'},
            {data: 'applicant'},
            {data: 'message'},
            {data: 'datesent'}
        ]
    });
    $('#message_search').keyup(function () {
        oTable.search($(this).val()).draw();
    })


</script>