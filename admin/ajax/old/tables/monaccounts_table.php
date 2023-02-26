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



<section class="page-content container-fluid">
    <ul class="nav nav-tabs" id="app_reg_form">
        <li class="nav-item" role="presentation">
            <a href="#tab-1" class="nav-link active show"
               data-toggle="tab" aria-expanded="true">Table Records</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#tab-2" class="nav-link" data-toggle="tab"
               aria-expanded="true">Statistics</a>
        </li>
    </ul>
    <div class="row">
        <div class="col">
            <div class="tab-content">
                <div class="tab-pane fadeIn active" id="tab-1">

                    <div class="kt-section">
                    <span class="kt-section__info">
                        <?php
                        if ($year_search == "All") {
                            echo "Payment Received for all years";
                        }
                        else {
                            echo "Payment Received for the year <strong>$year_search</strong>";
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
                                    <input type="text" id="account_search" class="form-control"
                                           placeholder="Search Full Name or email address" aria-describedby="basic-addon1">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="acc-table" class="table" style="margin-top: 3% !important">
                                    <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Email Address</th>
                                        <th>Acc Type</th>
                                        <th>Amount Paid</th>
                                        <th>Date Received</th>
                                        <th>Profession</th>
                                        <!--<th>Telephone</th>-->
                                        <th>Action</th>

                                    </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="tab-pane fadeIn" id="tab-2">
                    <div class="row">
                        <div class="col-xl-12">
                            <!--begin:: Widgets/Applications/User/Profile3-->
                            <div class="kt-portlet kt-portlet--height-fluid">
                                <div class="kt-portlet__body">
                                    <div class="kt-widget kt-widget--user-profile-3">
                                        <div class="kt-widget__top">

                                            <div class="kt-widget__content">
                                                <div class="kt-widget__head">
                                                    <a href="#" class="kt-widget__username">
                                                        <?php echo $_SESSION['full_name']; ?>
                                                        <i class="flaticon2-user"></i>
                                                    </a>

                                                </div>

                                                <div class="kt-widget__subhead">
                                                    General Statistics
                                                </div>
                                            </div>
                                        </div>

                                        <div class="kt-widget__bottom">

                                            <div class="kt-widget__item">
                                                <div class="kt-widget__details">
                                                    <span class="kt-widget__title">By GCB (Total)</span>

                                                    <span class="kt-widget__value"><span><i class="la la-money"></i> </span>
                                                        <?php
                                                        $getsumg = $mysqli->query("select sum(amountpaid) as
                                                               totalamt from `accounts` where recievedby = 'GCB'");
                                                        $ressumg = $getsumg->fetch_assoc();
                                                        echo number_format($ressumg['totalamt'],2);
                                                        ?>
                                                        </span>
                                                </div>
                                            </div>

                                            <div class="kt-widget__item">
                                                <div class="kt-widget__details">
                                                    <span class="kt-widget__title">By Council (Total)</span>

                                                    <span class="kt-widget__value"><span><i class="la la-money"></i> </span>
                                                        <?php
                                                        $getsuma = $mysqli->query("select sum(amountpaid) as
                                                               totalamt from `accounts` where recievedby != 'GCB'");
                                                        $ressuma = $getsuma->fetch_assoc();
                                                        echo number_format($ressuma['totalamt'],2);
                                                        ?>
                                                        </span>
                                                </div>
                                            </div>

                                            <div class="kt-widget__item">
                                                <div class="kt-widget__details">
                                                    <span class="kt-widget__title">Accrued Sum (Total)</span>
                                                    <span class="kt-widget__value"><span><i class="la la-money"></i> </span>
                                                        <?php
                                                        $getsumt = $mysqli->query("select sum(amountpaid) as
                                                               totalamt from `accounts`");
                                                        $ressumt = $getsumt->fetch_assoc();
                                                        echo number_format($ressumt['totalamt'],2);
                                                        ?>
                                                        </span>
                                                </div>
                                            </div>

                                            <div class="kt-widget__item">
                                                <div class="kt-widget__details">
                                                    <span class="kt-widget__title">
                                                        Today (<?php echo date('l, F j, Y') ?>)</span>
                                                    <?php $today = date('Y-m-d');
                                                    //echo substr($today,0,10)
                                                    ?>
                                                    <span class="kt-widget__value"><span><i class="la la-money"></i> </span>
                                                        <?php
                                                        $getsum = $mysqli->query("select sum(amountpaid) as
                                                               totalamt from `accounts` where
                                                                 substr(paymentdate,1,10) = '$today'");
                                                        $ressum = $getsum->fetch_assoc();
                                                        echo number_format($ressum['totalamt'],2);
                                                        ?>
                                                        </span>
                                                </div>
                                            </div>

                                        </div>

                                        <hr/>

                                        Go to <b>Accounting Statistics</b> on the left sidebar menu for more details

                                    </div>
                                </div>
                            </div>
                            <!--end:: Widgets/Applications/User/Profile3-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>







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
            'url': 'ajax/paginations/monaccounts.php?year=<?php echo $year_search ?>'
        },
        'columns': [
            {data: 'full_name'},
            {data: 'email_address'},
            {data: 'acc_type'},
            {data: 'amt_paid'},
            {data: 'date_received'},
            {data: 'profession'},
            /* {data: 'telephone'},*/
            {data: 'action'}
        ]
    });
    $('#account_search').keyup(function () {
        oTable.search($(this).val()).draw();
    })


</script>