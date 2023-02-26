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


<div class="kt-section">
    `
    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">
                                <i class="la la-search"></i>
                            </span></div>
                <input type="text" id="cpd_search" class="form-control"
                       placeholder="Search CPD Activities" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="cpd-table" class="table" style="margin-top: 3% !important">
                <thead>
                <tr>
                    <th>Activity</th>
                    <th>Credit</th>
                    <th>Date Uploaded</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>
</div>


<script>
    oTable = $('#cpd-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/cpdlist.php'
        },
        'columns': [
            {data: 'activity'},
            {data: 'credit'},
            {data: 'dateuploaded'}
        ]
    });
    $('#cpd_search').keyup(function () {
        oTable.search($(this).val()).draw();
    })


</script>