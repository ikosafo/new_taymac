<?php
include('../../../config.php');
$select_funnel = $_POST['select_funnel']; ?>

<div class="kt-section">

    <div class="kt-section__content responsive" id="print_this">


        Search Results for <?php $tunnel = $select_funnel;
        $gettunnelname = $mysqli->query("select * from farm_funnel where id = '$select_funnel'");
        $restunnelname = $gettunnelname->fetch_assoc();
        echo $tunnelname = $restunnelname['funnel_name']." activities";
        ?>


        <hr/>
        FERTILIZER APPLICATION

        <?php $pinq = $mysqli->query("select * from farm_fertilizer where tunnel = '$tunnel' ORDER BY date_activity DESC,id DESC");?>

            <table id="data-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Details</th>
                    <th>Date of Activity</th>
                    <th>Description</th>
                </tr>
                </thead>

                <tbody>
                <?php
                while ($fetch = $pinq->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $fetch['fertilizer_name']; ?></td>
                        <td><b>Application Area :</b> <?php echo $fetch['application_area']; ?><br/>
                            <b>Tunnel :</b> <?php $tunnel = $fetch['tunnel'];
                            $gettunnelname = $mysqli->query("select * from farm_funnel where id = '$tunnel'");
                            $restunnelname = $gettunnelname->fetch_assoc();
                            echo $restunnelname['funnel_name'];
                            ?> <br/>
                            <b>Product :</b> <?php $product = $fetch['product'];
                            $getproductname = $mysqli->query("select * from farm_products where id = '$product'");
                            $resproductname = $getproductname->fetch_assoc();
                            echo $resproductname['product_name'];
                            ?> <br/>
                            <b>Weight :</b> <?php echo $fetch['input_kg']." kg"; ?>
                        </td>
                        <td><?php echo $fetch['date_activity']; ?></td>
                        <td><?php echo $fetch['activity_description']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>

            </table>

        <hr/>
        PESTICIDE/INSECTICIDE APPLICATION

        <?php $pinq = $mysqli->query("select * from farm_pesticide where tunnel = '$tunnel' ORDER BY date_activity DESC,id DESC");?>

          <table id="data-table" class="table" style="margin-top: 3% !important;">
            <thead>
            <tr>
                <th>Name</th>
                <th>Details</th>
                <th>Date of Activity</th>
                <th>Description</th>
            </tr>
            </thead>

            <tbody>
            <?php
            while ($fetch = $pinq->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $fetch['pesticide_name']; ?></td>
                    <td><b>Tunnel :</b> <?php $tunnel = $fetch['tunnel'];
                        $gettunnelname = $mysqli->query("select * from farm_funnel where id = '$tunnel'");
                        $restunnelname = $gettunnelname->fetch_assoc();
                        echo $restunnelname['funnel_name'];
                        ?> <br/>
                        <b>Product :</b> <?php $product = $fetch['product'];
                        $getproductname = $mysqli->query("select * from farm_products where id = '$product'");
                        $resproductname = $getproductname->fetch_assoc();
                        echo $resproductname['product_name'];
                        ?> <br/>
                        <b>Weight :</b> <?php echo $fetch['input_kg']." litres"; ?>
                    </td>
                    <td><?php echo $fetch['date_activity']; ?></td>
                    <td><?php echo $fetch['activity_description']; ?></td>
                </tr>
            <?php } ?>
            </tbody>

        </table>

        <hr/>
        WATERING APPLICATION

        <?php  $pinq = $mysqli->query("select * from farm_watering  where tunnel = '$tunnel' ORDER BY date_activity DESC,id DESC");?>

        <table id="data-table" class="table" style="margin-top: 3% !important;">
            <thead>
            <tr>
                <th>Cycle</th>
                <th>Details</th>
                <th>Date of Activity</th>
                <th>Description</th>
            </tr>
            </thead>

            <tbody>
            <?php
            while ($fetch = $pinq->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $fetch['cycle']; ?></td>
                    <td><b>Tunnel :</b> <?php $tunnel = $fetch['tunnel'];
                        $gettunnelname = $mysqli->query("select * from farm_funnel where id = '$tunnel'");
                        $restunnelname = $gettunnelname->fetch_assoc();
                        echo $restunnelname['funnel_name'];
                        ?> <br/>
                        <b>Product :</b> <?php $product = $fetch['product'];
                        $getproductname = $mysqli->query("select * from farm_products where id = '$product'");
                        $resproductname = $getproductname->fetch_assoc();
                        echo $resproductname['product_name'];
                        ?> <br/>
                        <b>Weight :</b> <?php echo $fetch['input_kg']." litres"; ?>
                    </td>
                    <td><?php echo $fetch['date_activity']; ?><br/>
                        <b>Start Time :</b> <?php echo $fetch['starttime'];?><br/>
                        <b>End Time :</b> <?php echo $fetch['endtime'];?><br/>
                    </td>
                    <td><?php echo $fetch['activity_description']; ?></td>
                </tr>
            <?php } ?>
            </tbody>

        </table>


    </div>

    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" onclick="printContent('print_this')"><i
                    class="flaticon2-printer"></i> Print
            </button>
        </div>
    </div>

</div>

