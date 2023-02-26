<?php
include('../../../config.php');
$billing_delivered = $_POST['select_bill'];
?>

<div class="row">
    <div class="col-md-4">
        <p>
            <b> Bill Sent </b>: <?php echo $billing_delivered; ?>
        </p>
    </div>
    <div class="col-md-8">
        <?php
        $getbill = $mysqli->query("select * from admin_taymac_billing where billing_delivered = '$billing_delivered'");
        ?>

        <div class="table-responsive">
            <table id="data-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>Tenant</th>
                    <th>Billing Details</th>
                    <th>Billing Amount(s)</th>
                    <th>Description</th>
                </tr>
                </thead>

                <tbody>
                <?php
                while ($fetch = $getbill->fetch_assoc()) {
                    ?>
                    <tr>
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
                        </td>
                        <td>
                            <b>Amt Per Month : </b>  <?php echo getCurrency($currency).' '.number_format($fetch['billing_amount'],2); ?> <br/>
                            <b>Number of Months : </b>  <?php echo $fetch['billing_months']; ?> <br/>
                            <b>Total Bill : </b>  <?php echo getCurrency($currency).' '.number_format($fetch['billing_total'],2); ?> <br/>
                            <b>Debt : </b>  <?php echo getCurrency($currency).' '.number_format(($fetch['billing_total'] - $fetch['amt_paid']),2); ?> <br/>

                        </td>
                        <td><?php echo $fetch['billing_description']; ?></td>

                    </tr>
                <?php } ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

