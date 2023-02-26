<?php
include('../../../config.php');
$staffid = $_POST['select_staff'];
$payment_type = $_POST['payment_type'];

if ($payment_type == "IOU") {
    $getiou = $mysqli->query("select * from admin_staff_iou where staff_id = '$staffid' ORDER BY payment_period DESC,payment_date DESC,dateupdated DESC")
    ?>

    <div class="table-responsive">
        <table id="data-table" class="table" style="margin-top: 3% !important;">
            <thead>
            <tr>
                <th>Payment For</th>
                <th>Date</th>
                <th>Amount</th>
            </tr>
            </thead>

            <tbody>
            <?php
            while ($fetch = $getiou->fetch_assoc()) {
                ?>
                <tr>
                    <td>
                        <?php echo date('F - Y', strtotime($fetch['payment_period'])) ?>
                    </td>
                    <td>
                        <?php echo date('l, F j, Y', strtotime($fetch['payment_date'])) ?>
                    </td>
                    <td>
                        <?php echo $fetch['payment_amount'] ?>
                    </td>

                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>

<?php }  else {
    $getsal = $mysqli->query("select * from admin_staff_salary where staff_id = '$staffid' ORDER BY payment_period DESC,payment_date DESC,dateupdated DESC")
    ?>

    <div class="table-responsive">
        <table id="data-table" class="table" style="margin-top: 3% !important;">
            <thead>
            <tr>
                <th>Payment For</th>
                <th>Date</th>
                <th>Credit</th>
                <th>Debit</th>
                <th>Net Salary</th>
            </tr>
            </thead>

            <tbody>
            <?php
            while ($fetch = $getsal->fetch_assoc()) {
                ?>
                <tr>
                    <td>
                        <?php echo date('F - Y', strtotime($fetch['payment_period'])) ?>
                    </td>
                    <td>
                        <?php echo date('l, F j, Y', strtotime($fetch['payment_date'])) ?>
                    </td>
                    <td>
                        <b>Gross Salary :</b> <?php echo $fetch['gross_salary'];?><br/>
                        <b>Allowance :</b> <?php echo $fetch['allowance'];?><br/>
                        <b>Overtime :</b> <?php echo $fetch['overtime'];?><br/>
                        <b>Compensation :</b> <?php echo $fetch['compensation'];?><br/>
                    </td>
                    <td>
                        <b>IOU Salary :</b> <?php echo $fetch['iou_salary'];?><br/>
                        <b>Income Tax :</b> <?php echo $fetch['allowance'];?><br/>
                        <b>SSNIT :</b> <?php echo $fetch['ssnit'];?><br/>
                        <b>Welfare :</b> <?php echo $fetch['welfare'];?><br/>
                    </td>
                    <td>
                        <?php echo $fetch['total'] ?>
                    </td>

                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>

<?php } ?>
