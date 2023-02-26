<?php
include('../../../config.php');
$tenant = $_POST['select_tenant'];

$gettenant = $mysqli->query("select * from admin_taymac_tenant where id = '$tenant'");
$restenant = $gettenant->fetch_assoc();

?>


<div class="row">
    <div class="col-md-4">

        <p>
            <b> Property </b>: <?php
            $property =  $restenant['tenant_property'];
            $getproperty = $mysqli->query("select * from admin_taymac_property where id = $property");
            $resproperty = $getproperty->fetch_assoc();
            echo $resproperty['property_name'];
            ?><br/>
            <b> Period </b>: <?php echo $restenant['date_started'].' <b>to</b><br/> '.$restenant['date_completed'] ?><br/>
            <b> Payment Rate </b>: <?php echo $restenant['payment_rate'];?><br/>
            <b> Telephone </b>: <?php echo $restenant['tenant_telephone'];?><br/>
            <b> Email </b>: <?php echo $restenant['tenant_email'];?><br/>
            <b> Description </b>: <?php echo $restenant['tenant_description'];?><br/>

        </p>

    </div>
    <div class="col-md-8">

        <?php
        $gettenant = $mysqli->query("select * from admin_taymac_billing where billing_tenant = '$tenant'");
        ?>

        <div class="table-responsive">
            <table id="data-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
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

