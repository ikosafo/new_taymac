<?php include('../../../config.php');
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];
$year_search = $_POST['year_search'];

?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>

<div class="kt-separator kt-separator--dashed"></div>

<div class="kt-section">
                    <span class="kt-section__info">
                        <?php
                        if ($year_search == "All") {
                            echo "Bills for all years";
                        }
                        else {
                            echo "Bills for the year <strong>$year_search</strong>";
                        }
                        ?>
                    </span>
    `
    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">
                                <i class="la la-search"></i>
                            </span></div>
                <input type="text" id="mes_search" class="form-control"
                       placeholder="Search Full Name, PIN, profession or level" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="bill-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>PIN</th>
                    <th>Profession</th>
                    <th>Level</th>
                    <th>Years defaulted</th>
                    <th>Last Year</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<script>
    oTable = $('#bill-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/bills.php?year=<?php echo $year_search ?>'
        },
        'columns': [
            {data: 'fullname'},
            {data: 'pin'},
            {data: 'profession'},
            {data: 'level'},
            {data: 'yearsdefault'},
            {data: 'lastyear'},
            {data: 'amount'},
            {data: 'action'}
        ]
    });
    $('#mes_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

</script>