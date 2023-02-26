<?php
include('../../../config.php');
$sm_type = $_POST['select_sm'];
$getsm = $mysqli->query("select * from admin_taymac_sm where sm_type = '$sm_type'");
//$ressm = $getsm->fetch_assoc();
//echo mysqli_num_rows($getsm);

?>

<div class="row">
    <div class="col-md-4">
        <p>
            <b> Service and Maintenance Type </b>: <?php echo $sm_type; ?>
        </p>
    </div>
    <div class="col-md-8">

        <div class="table-responsive">
            <table id="data-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>Service Details</th>
                    <th>Service Cost</th>
                    <th>Description</th>
                </tr>
                </thead>

                <tbody>
                <?php
                while ($fetch = $getsm->fetch_assoc()) {
                    ?>
                    <tr>
                        <td>
                            <b>Service Type : </b><?php echo $sm_type = $fetch['sm_type'];
                            if($sm_type == "") {
                                echo $fetch['sm_type_other'];
                            }
                            ?> <br/>
                            <b>Tenant :</b> <?php $tenant =  $fetch['sm_tenant'];
                            $gettenant = $mysqli->query("select * from admin_taymac_tenant where id = '$tenant'");
                            $restenant = $gettenant->fetch_assoc();
                            echo $restenant['tenant_name'];
                            ?> <br/>
                            <b>Currency : </b> <?php echo $currency = $fetch['sm_currency']; ?> <br/>
                        </td>
                        <td>
                            <b>Total Bill : </b>  <?php echo getCurrency($currency).' '.number_format($fetch['sm_amount'],2); ?> <br/>
                            <b>Debt : </b>  <?php echo getCurrency($currency).' '.number_format(($fetch['sm_amount'] - $fetch['amt_paid']),2); ?> <br/>

                        </td>
                        <td><?php echo $fetch['sm_description']; ?></td>

                    </tr>
                <?php } ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

