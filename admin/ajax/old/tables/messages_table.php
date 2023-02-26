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
                            echo "Messages for all years";
                        }
                        else {
                            echo "Messages for the year <strong>$year_search</strong>";
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
                       placeholder="Search Full Name, Subject or Message" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
        <table id="mes-table" class="table" style="margin-top: 3% !important;">
            <thead>
            <tr>
                <th width="20%">Full Name</th>
                <th width="10%">Subject</th>
                <th width="30%">Message</th>
                <th width="15%">Reply</th>
                <th width="15%">Period Sent</th>
                <th width="10%">Action</th>

            </tr>
            </thead>
        </table>
            </div>
    </div>
</div>


<script>
    oTable = $('#mes-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/messages.php?year=<?php echo $year_search ?>'
        },
        'columns': [
            {data: 'applicant_id'},
            {data: 'subject'},
            {data: 'message'},
            {data: 'reply'},
            {data: 'period'},
            {data: 'id'}
        ]
    });
    $('#mes_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

</script>