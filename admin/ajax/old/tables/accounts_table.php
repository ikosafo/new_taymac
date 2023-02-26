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
            echo "Login Account Registrations for all years";
        } else {
            echo "Login Account Registrations for the year <strong>$year_search</strong>";
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
                <input type="text" id="account_search" class="form-control" placeholder="Search Full Name or email address" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="acc-table" class="table" style="margin-top: 3% !important">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Date Account Created</th>
                        <th>Email Verified</th>
                        <th>Date Email Verified</th>

                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>


<script>
    oTable = $('#acc-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/useraccounts.php?year=<?php echo $year_search ?>'
        },
        'columns': [{
                data: 'first_name'
            },
            {
                data: 'email_address'
            },
            {
                data: 'period'
            },
            {
                data: 'email_verified'
            },
            {
                data: 'email_verified_period'
            }
        ]
    });
    $('#account_search').keyup(function() {
        oTable.search($(this).val()).draw();
    })
</script>