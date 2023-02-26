<?php include('../../../config.php');
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];
$year_search = $_POST['select_year'];
$select_year = $_POST['select_year'];
$center = $_POST['center'];
$attempts = $_POST['attempts'];

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
                <input type="text" id="itexamdetails_search" class="form-control"
                       placeholder="Search Index Number, Facility or Date Registered" aria-describedby="basic-addon1">
            </div>
        </div>


        <div class="table-responsive">
            <table id="itexam-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Internship <br/>Period</th>
                    <th>Facility</th>
                    <th>Previous Exam</th>
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

    oTable = $('#itexam-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/itexam_table.php?year=<?php echo $year_search ?>&center=<?php echo $center ?>&attempts=<?php echo $attempts ?>'
        },
        'columns': [
            {data: 'applicant_id'},
            {data: 'email_address'},
            {data: 'internship_period'},
            {data: 'facility'},
            {data: 'previous_exam'},
            {data: 'payment'},
            {data: 'period_registered'},
            {data: 'examination_id'}
        ]
    });

    $('#itexamdetails_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

</script>