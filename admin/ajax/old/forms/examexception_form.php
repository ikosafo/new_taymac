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
                    <span class="kt-section__info">
                        All Examination Records
                    </span>
    `
    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon2">
                                <i class="la la-search"></i>
                            </span></div>
                <input type="text" id="examsearch" class="form-control"
                       placeholder="Search Index Number or Facility" aria-describedby="basic-addon2">
            </div>
        </div>

        <div class="table-responsive">
            <table id="exam-table" class="table" style="margin-top: 3% !important">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Attempts</th>
                    <th>Facility</th>
                    <th>Exam Center</th>
                    <th>Payment</th>
                    <th>Index Number</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>
</div>


<script>
    dTable = $('#exam-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/examcodeexception.php'
        },
        'columns': [
            {data: 'full_name'},
            {data: 'email_address'},
            {data: 'attempts'},
            {data: 'facility'},
            {data: 'center'},
            {data: 'payment'},
            {data: 'indexnumber'},
            {data: 'action'}
        ]
    });
    $('#examsearch').keyup(function () {
        dTable.search($(this).val()).draw();
    })
</script>