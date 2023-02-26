<?php include('../../../config.php');
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];
$year_search = $_POST['select_year'];
$provisional_status = $_POST['provisional_status'];
$admintype = $_POST['admintype'];

?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>

<div class="kt-separator kt-separator--dashed"></div>

<div class="kt-section">
    <!-- <span class="kt-section__info">
                        <?php
    /*                        if ($year_search == "All") {
                                echo "All Years".'<br/>';
                                echo "Status: ".$provisional_status ;
                            }
                            else {
                                echo "Year: ".$year_search.'<br/>';
                                echo "Status: ".$provisional_status ;
                            }
                            */?>
                    </span>-->
    `
    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">
                                <i class="la la-search"></i>
                            </span></div>
                <input type="text" id="provisional_search" class="form-control"
                       placeholder="Search Full Name or email address" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="prov-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Provisional PIN</th>
                    <th>MIS Status</th>
                    <th>Admin Status</th>
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
                'url': 'ajax/paginations/provisional_super_upgrade.php?year=<?php echo $year_search ?>&status=<?php echo $provisional_status ?>'
            },
            'columns': [
                {data: 'provisionalid'},
                {data: 'email_address'},
                {data: 'provisional_pin'},
                {data: 'provisional_usercheck_status'},
                {data: 'provisional_admincheck_status'},
                {data: 'provisional_period'},
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
                'url': 'ajax/paginations/provisional_mis_upgrade.php?year=<?php echo $year_search ?>&status=<?php echo $provisional_status ?>'
            },
            'columns': [
                {data: 'provisionalid'},
                {data: 'email_address'},
                {data: 'provisional_pin'},
                {data: 'provisional_usercheck_status'},
                {data: 'provisional_admincheck_status'},
                {data: 'provisional_period'},
                {data: 'applicant_id'}
            ]
        });
    }


    $('#provisional_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

</script>