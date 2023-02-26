<?php
include('../../../config.php');
$billing_type = $_POST['select_bill'];
$getbill = $mysqli->query("select * from admin_taymac_billing where billing_type = '$billing_type'");
$resbill = $getbill->fetch_assoc();

?>

<div class="row">
    <div class="col-md-4">

        <p>
            <b> Bill Type </b>: <?php echo $billing_type; ?>
        </p>

    </div>
    <div class="col-md-8">

        <?php
        $gettenant = $mysqli->query("select * from admin_taymac_billing where billing_type = '$billing_type'");
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
                while ($fetch = $gettenant->fetch_assoc()) {
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
                            <b>Billing Type : </b><?php echo $billing_type = $fetch['billing_type'];
                            if($billing_type == "") {
                                echo $fetch['billing_type_other'];
                            }
                            ?> <br/>
                            <b>Billing Currency : </b> <?php echo $currency = $fetch['billing_currency']; ?> <br/>
                            <b>Billed For : </b> <?php echo $fetch['billing_period']; ?> <br/>
                            <b>Bill Sent : </b> <?php echo $fetch['billing_delivered']; ?> <br/>
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

