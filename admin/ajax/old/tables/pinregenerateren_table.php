<?php include('../../../config.php');
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
                <input type="text" id="general_search" class="form-control"
                       placeholder="Search..." aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="general-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>Old PIN</th>
                    <th>New PIN</th>
                    <th>Date Regenerated</th>
                    <th>User</th>
                    <th>Status</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<script>

    oTable = $('#general-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/pin_regenerate_ren.php'
        },
        'columns': [
            {data: 'oldpin'},
            {data: 'newpin'},
            {data: 'dateupdated'},
            {data: 'userid'},
            {data: 'status'}
        ]
    });


    $('#general_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

</script>