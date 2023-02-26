<?php include('../../../config.php');

$gs_status = $_POST['gs_status'];

?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>

<h3 style="text-align: center;text-transform:uppercase">
    <?php echo $gs_status; ?>
</h3>

<div class="kt-separator kt-separator--dashed"></div>

<div class="kt-section">

    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">
                        <i class="la la-search"></i>
                    </span></div>
                <input type="text" id="gs_search" class="form-control" placeholder="Search Full Name, PIN, email address or Telephone" aria-describedby="basic-addon1">
            </div>
        </div>


        <div class="table-responsive">
            <table id="prov-table" class="table" style="margin-top: 3% !important;">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Gender</th>
                        <th>Email Address</th>
                        <th>Telephone</th>
                        <th>PIN</th>
                        <th>Profession</th>
                        <th>Region</th>
                        <th>Districy</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<script>
    //var admintype = '<?php echo $admintype ?>';
    //alert(admintype);

    oTable = $('#prov-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/gs_table.php'
        },
        'columns': [{
                data: 'provisionalid'
            },
            {
                data: 'gender'
            },
            {
                data: 'email_address'
            },
            {
                data: 'telephone'
            },
            {
                data: 'provisional_pin'
            },
            {
                data: 'gs_usercheck_status'
            },
            {
                data: 'gs_admincheck_status'
            },
            {
                data: 'gs_payment'
            },
            {
                data: 'gs_period'
            },
            {
                data: 'applicant_id'
            }
        ]
    });

    $('#gs_search').keyup(function() {
        oTable.search($(this).val()).draw();
    });
</script>