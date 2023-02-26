<?php include('../../../config.php');
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];

?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>

<div class="kt-separator kt-separator--dashed"></div>

<div class="kt-section">

    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                                <i class="la la-search"></i>
                    </span>
                </div>
                <input type="text" id="examination_search" class="form-control"
                       placeholder="Search Full Name or email address" aria-describedby="basic-addon1">
            </div>
        </div>


        <div class="table-responsive">
            <table id="general-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th width="15%">Full Name</th>
                    <th>Email Address</th>
                    <th>Provisional PIN</th>
                    <th>Officer Status</th>
                    <th>Admin Status</th>
                    <th>Index Number</th>
                    <th>Period<br/>Regsitered</th>
                    <!-- <th width="20%">Examination Details</th>-->
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
            'url': 'ajax/paginations/examinationreg.php'
        },
        'columns': [
            {data: 'provisionalid'},
            {data: 'email_address'},
            {data: 'provisional_pin'},
            {data: 'examination_usercheck_status'},
            {data: 'examination_admincheck_status'},
            {data: 'index_number'},
            {data: 'examination_period'},
            /* {data: 'examination_details'},*/
            {data: 'examination_id'}
        ]
    });

    $('#examination_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

</script>