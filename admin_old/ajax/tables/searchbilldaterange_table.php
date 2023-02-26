<?php
include('../../../config.php');
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
?>

<div class="row">
    <div class="col-md-4">
        <p>
            <b> Start Date </b>: <?php echo $start_date; ?>
        </p>
        <p>
            <b> End Date </b>: <?php echo $end_date; ?>
        </p>
    </div>
    <div class="col-md-8">
        <?php
        $getbill = $mysqli->query("select * from admin_taymac_billing where
billing_date >= '$start_date' and billing_date <= '$end_date' ORDER BY billing_date DESC");
        ?>

        <div class="table-responsive">
            <table id="data-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tenant</th>
                    <th>Billing Details</th>
                    <th>Billing Amount(s)</th>
                    <th>Description</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $countnum = 1;
                while ($fetch = $getbill->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $countnum; ?></td>
                        <td>
                            <?php
                            $tenant =  $fetch['billing_tenant'];
                            $gettenantname = $mysqli->query("select * from admin_taymac_tenant where id = '$tenant'");
                            $restenant = $gettenantname->fetch_assoc();
                            echo $restenant['tenant_name'];
                            ?>
                        </td>
                        <td>
                            <b>Billing Type : </b><?php echo $billing_delivered = $fetch['billing_delivered'];
                            if($billing_delivered == "") {
                                echo $fetch['billing_delivered_other'];
                            }
                            ?> <br/>
                            <b>Billing Currency : </b> <?php echo $currency = $fetch['billing_currency']; ?> <br/>
                            <b>Billed For : </b> <?php echo $fetch['billing_period']; ?> <br/>
                            <b>Bill Date : </b> <?php echo date('l,F j, Y',strtotime($fetch['billing_date'])) ; ?> <br/>
                        </td>
                        <td>
                            <b>Amt Per Month : </b>  <?php echo getCurrency($currency).' '.number_format($fetch['billing_amount'],2); ?> <br/>
                            <b>Number of Months : </b>  <?php echo $fetch['billing_months']; ?> <br/>
                            <b>Total Bill : </b>  <?php echo getCurrency($currency).' '.number_format($fetch['billing_total'],2); ?> <br/>
                            <b>Debt : </b>  <?php echo getCurrency($currency).' '.number_format(($fetch['billing_total'] - $fetch['amt_paid']),2); ?> <br/>

                        </td>
                        <td><?php echo $fetch['billing_description']; ?></td>

                    </tr>
                <?php  $countnum++; }

                ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

