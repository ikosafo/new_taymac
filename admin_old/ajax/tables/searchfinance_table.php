<?php include('../../../config.php');
$finance_type = $_POST['finance_type'];
?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>

<div class="kt-section">

    <?php
    if ($finance_type == "Sales") {
        $pinq = $mysqli->query("select * from farm_sales ORDER BY id DESC");
    ?>

    <div class="kt-section__content responsive">
        <div class="table-responsive">
            <table id="data-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Date of Sale</th>
                    <th>Weight</th>
                    <th>Cost</th>
                </tr>
                </thead>

                <tbody>
                <?php
                while ($fetch = $pinq->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $fetch['product']; ?></td>
                        <td><?php echo $fetch['date_sale']; ?></td>
                        <td><?php echo $fetch['input_kg']." kg"; ?></td>
                        <td><?php echo $fetch['input_price']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>

            </table>
        </div>
    </div>

    <?php } else {
        $pinq = $mysqli->query("select * from farm_purchases ORDER BY id DESC");
        ?>

    <div class="kt-section__content responsive">

            <div class="table-responsive">
                <table id="data-table" class="table" style="margin-top: 3% !important;">
                    <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Type</th>
                        <th>Date Purchased</th>
                        <th>Quantity</th>
                        <th>Cost</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    while ($fetch = $pinq->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $fetch['item_name']; ?></td>
                            <td><?php echo $fetch['input_type']; ?></td>
                            <td><?php echo $fetch['date_pf']; ?></td>
                            <td><?php echo $fetch['input_kg'];
                                if ($fetch['input_type'] == 'Fertilizer') {
                                    echo " kg";
                                }
                                if ($fetch['input_type'] == 'Pesticide') {
                                    echo " litres";
                                }
                                ?></td>
                            <td><?php echo $fetch['input_cost']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>

    <?php } ?>
</div>

