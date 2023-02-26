<?php include('../../../config.php');
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];
$year_search = $_POST['select_year'];
$permanent_status = $_POST['permanent_status'];
$admintype = $_POST['admintype'];

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
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">
                                <i class="la la-search"></i>
                            </span></div>
                <input type="text" id="permanent_search" class="form-control"
                       placeholder="Search Full Name or email address" aria-describedby="basic-addon1">
            </div>
        </div>


        <div class="table-responsive">
        <table id="prov-table" class="table" style="margin-top: 3% !important;">
            <thead>
            <tr>
                <th>Full Name</th>
                <th>Email Address</th>
                <th>PIN</th>
                <th>MIS Status</th>
                <th>Admin Status</th>
                <th>Payment</th>
                <th>Period Registered</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
            </div>
    </div>
</div>


<script>

    var admintype = '<?php echo $admintype ?>';
    //alert(admintype);

    if (admintype == 'Super Admin') {
        oTable = $('#prov-table').DataTable({
            stateSave: true,
            "bLengthChange": false,
            dom: "rtiplf",
            "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': 'ajax/paginations/permanent_super.php?year=<?php echo $year_search ?>&status=<?php echo $permanent_status ?>'
            },
            'columns': [
                {data: 'provisionalid'},
                {data: 'email_address'},
                {data: 'provisional_pin'},
                {data: 'permanent_usercheck_status'},
                {data: 'permanent_admincheck_status'},
                {data: 'permanent_payment'},
                {data: 'permanent_period'},
                {data: 'applicant_id'}
            ]
        });
    }

    else {
        oTable = $('#prov-table').DataTable({
            stateSave: true,
            "bLengthChange": false,
            dom: "rtiplf",
            "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': 'ajax/paginations/permanent_mis.php?year=<?php echo $year_search ?>&status=<?php echo $permanent_status ?>'
            },
            'columns': [
                {data: 'provisionalid'},
                {data: 'email_address'},
                {data: 'provisional_pin'},
                {data: 'permanent_usercheck_status'},
                {data: 'permanent_admincheck_status'},
                {data: 'permanent_payment'},
                {data: 'permanent_period'},
                {data: 'applicant_id'}
            ]
        });
    }


    $('#permanent_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

</script>