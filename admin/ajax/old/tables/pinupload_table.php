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

    `
    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">
                                <i class="la la-search"></i>
                            </span></div>
                <input type="text" id="pin_search" class="form-control"
                       placeholder="Search Full Name or PIN" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="pin-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>PIN</th>
                    <th>Profession</th>
                    <th>Date Uploaded</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>
</div>


<script>


    oTable = $('#pin-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/pinupload.php'
        },
        'columns': [
            {data: 'fullname'},
            {data: 'cpdpin'},
            {data: 'profession'},
            {data: 'dateuploaded'}
        ]
    });

    $('#pin_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

</script>