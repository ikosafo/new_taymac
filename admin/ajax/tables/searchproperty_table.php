<?php
include('../../../config.php');
$property = $_POST['select_property'];
$getproperty = $mysqli->query("select * from admin_taymac_property where id = $property");
$resproperty = $getproperty->fetch_assoc();

?>


<div class="row">
    <div class="col-md-4">

        <p>
            <b> Property Name </b>: <?php echo $resproperty['property_name'];?><br/>
            <b> Property Type </b>: <?php echo $resproperty['property_type'];?><br/>
            <b> Property Location </b>: <?php echo $resproperty['property_location'];?><br/>
            <b> Property Address </b>: <?php echo $resproperty['property_address'];?><br/>
            <b> Description </b>: <?php echo $resproperty['property_description'];?><br/>

        </p>

    </div>
    <div class="col-md-8">

        <?php
        $gettenant = $mysqli->query("select * from admin_taymac_tenant where tenant_property = '$property'");
        ?>

        <div class="table-responsive">
            <table id="data-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>Tenant Name</th>
                    <th>Date Period</th>
                    <th>Rate</th>
                    <th>Telephone</th>
                    <th>Email</th>
                    <th>Description</th>
                </tr>
                </thead>

                <tbody>
                <?php
                while ($fetch = $gettenant->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $fetch['tenant_name']; ?></td>
                        <td><?php echo $fetch['date_started'].' <b>to</b><br/> '.$fetch['date_completed'] ?></td>
                        <td><?php echo $fetch['payment_rate'] ?></td>
                        <td><?php echo $fetch['tenant_telephone'] ?></td>
                        <td><?php echo $fetch['tenant_email'] ?></td>
                        <td><?php echo $fetch['tenant_description']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

