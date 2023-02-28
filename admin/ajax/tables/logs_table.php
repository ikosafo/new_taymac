<?php include('../../../config.php');

$username = $_POST['username'];

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
                <input type="text" id="log_search" class="form-control" placeholder="Search..." aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="log-table" class="table" style="margin-top: 3% !important;">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>IP Address</th>
                        <th>Mac Address</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>


<script>
    oTable = $('#log-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/queries/log_pagination.php'
        },
        'columns': [{
                data: 'message'
            },
            {
                data: 'logdate'
            },
            {
                data: 'action'
            },
            {
                data: 'ip_address'
            },
            {
                data: 'mac_address'
            }
        ]
    });

    $('#log_search').keyup(function() {
        oTable.search($(this).val()).draw();
    });
</script>