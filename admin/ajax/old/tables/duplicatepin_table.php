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
                       placeholder="Search Full Name or email address" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="general-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Telephone</th>
                    <th>PIN</th>
                    <th>PIN Updated</th>
                    <th>Region</th>
                    <!-- <th>Registration Mode</th>-->
                    <th>Action</th>
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
            'url': 'ajax/paginations/dupicatepin_update.php'
        },
        'columns': [
            {data: 'provisionalid'},
            {data: 'email_address'},
            {data: 'telephone'},
            {data: 'provisional_pin'},
            {data: 'pin_updated'},
            {data: 'res_region'},
            /* {data: 'registration_mode'},*/
            {data: 'applicant_id'}
        ]
    });


    $('#general_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

</script>