<?php include('../../../config.php');
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];
$year_search = $_POST['select_year'];
$examination_status = $_POST['examination_status'];
$admintype = $_POST['admintype'];

?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>

<div class="kt-separator kt-separator--dashed"></div>

<div class="kt-section">

    `
    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">
                                <i class="la la-search"></i>
                            </span></div>
                <input type="text" id="examination_search" class="form-control"
                       placeholder="Search Full Name or index number" aria-describedby="basic-addon1">
            </div>
        </div>


        <div class="table-responsive">
        <table id="prov-table" class="table" style="margin-top: 3% !important;">
            <thead>
            <tr>
                <th>Full Name</th>
                <th>Profession</th>
                <th>Index Number</th>
                <th>Results</th>
                <th>Remark</th>
                <th>Status</th>
                <th>PIN</th>
            </tr>
            </thead>
        </table>
            </div>
    </div>
</div>


<script>

    oTable = $('#prov-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/examination_status.php?year=<?php echo $year_search ?>&status=<?php echo $examination_status ?>'
        },
        'columns': [
            {data: 'fullname'},
            {data: 'profession'},
            {data: 'indexnumber'},
            {data: 'results'},
            {data: 'remarks'},
            {data: 'status'},
            {data: 'pin'}
        ]
    });


    $('#examination_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

</script>