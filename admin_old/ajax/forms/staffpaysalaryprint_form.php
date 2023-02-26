<?php include ('../../../config.php');
//$random = date("Hymsdi");
$theindex = $_POST['theindex'];

$get = $mysqli->query("select * from admin_staff_salary where id = '$theindex' ORDER BY
payment_period DESC,payment_date DESC,dateupdated DESC");
$res = $get->fetch_assoc();

$staffid = $res['staff_id'];
$getname = $mysqli->query("select * from admin_staff where id = '$staffid'");
$resname = $getname->fetch_assoc();
$staff_name = $resname['staff_name'];

?>

<div class="kt-portlet__body">
    <div class="invoice-wrapper" id="print_this">


        <div class="invoice-header">
            <div class="row">
                <div class="col-md-3" align="center">
                    <img src="../../../assets/img/taymac.PNG"
                         style="border: 0 !important; width: 90%"/>
                </div>
                <div class="col-md-8" align="center">
                    <h6>
                        GROUND FLOOR, LE PIERRE, 14 SENCHI STREET, AIRPORT RESIDENTIAL AREA, ACCRA - GHANA. <br/>
                        TEL: 0302-789-025 / 0266-107-130
                        <hr/>
                        PAY SLIP - IOU
                    </h6>
                </div>

            </div>
            <div class="invoice-summary" style="padding-top: 10%">
                <div class="row">
                    <div class="col-md-12">
                        <b><?php echo $staff_name ?></b> <br/>
                        SLIP NUMBER: <?php
                        $billinv = 'SAL';
                        echo 'T/'.date('y',strtotime($res['payment_date'])).
                            '/'.$billinv.'/'.$res['id'].'/'.date('m',strtotime($res['payment_date']));?>
                    </div>
                </div>


                <div class="row" style="padding-top: 2%">
                    <div class="col-md-12">
                        <div class="body">
                            <div class="table-responsive">
                                <table
                                    class="table center-aligned-table">
                                    <thead>
                                    <tr>
                                        <th>Item No</th>
                                        <th>Item</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td><?php echo "1" ?></td>
                                        <td>Salary</td>
                                        <td>Gross Salary</td>
                                        <td><?php echo number_format($res['gross_salary'],2) ?></td>
                                        <td>Allowance</td>
                                        <td><?php echo number_format($res['allowance'],2) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo "2" ?></td>
                                        <td></td>
                                        <td>Over Time</td>
                                        <td><?php echo number_format($res['overtime'],2) ?></td>
                                        <td>Compensation</td>
                                        <td><?php echo number_format($res['compensation'],2) ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">DEBIT</td>
                                    </tr>
                                    <tr>
                                        <td><?php echo "1" ?></td>
                                        <td></td>
                                        <td>IOU</td>
                                        <td><?php echo number_format($res['iou_salary'],2) ?></td>
                                        <td>Income Tax</td>
                                        <td><?php echo number_format($res['income_tax'],2) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo "2" ?></td>
                                        <td></td>
                                        <td>Social Security</td>
                                        <td><?php echo number_format($res['ssnit'],2) ?></td>
                                        <td>Welfare</td>
                                        <td><?php echo number_format($res['welfare'],2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>TOTAL AMOUNT</td>
                                        <td colspan="4"></td>
                                        <td>
                                            <span style="font-size: large;font-weight: 700">
                                                <?php echo number_format($res['total'],2) ?>
                                            </span>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row" style="padding-top: 2%">
                    <div class="col-md-4"> Signature</div>

                    <div class="col-md-8">

                        .........................................................................................................

                    </div>

                </div>

                <div class="row" style="padding-top: 2%">
                    <div class="col-md-12">
                        Joshua M.K Kpakpah (Jnr.)<br/>
                        For & Behalf of TCL
                    </div>

                </div>



            </div>
        </div>

        <hr style="padding-top: 20%"/>

        <div class="invoice-header">
            <div class="row">
                <div class="col-md-3" align="center">
                    <img src="../../../assets/img/taymac.PNG"
                         style="border: 0 !important; width: 90%"/>
                </div>
                <div class="col-md-8" align="center">
                    <h6>
                        GROUND FLOOR, LE PIERRE, 14 SENCHI STREET, AIRPORT RESIDENTIAL AREA, ACCRA - GHANA. <br/>
                        TEL: 0302-789-025 / 0266-107-130
                        <hr/>
                        PAY SLIP - IOU
                    </h6>
                </div>

            </div>
            <div class="invoice-summary" style="padding-top: 10%">
                <div class="row">
                    <div class="col-md-12">
                        <b><?php echo $staff_name ?></b> <br/>
                        SLIP NUMBER: <?php
                        $billinv = 'IOU';
                        echo 'T/'.date('y',strtotime($res['payment_date'])).
                            '/'.$billinv.'/'.$res['id'].'/'.date('m',strtotime($res['payment_date']));?>
                    </div>
                </div>


                <div class="row" style="padding-top: 2%">
                    <div class="col-md-12">
                        <div class="body">
                            <div class="table-responsive">
                                <table
                                    class="table center-aligned-table">
                                    <thead>
                                    <tr>
                                        <th>Item No</th>
                                        <th>Item</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td><?php echo "1" ?></td>
                                        <td>IOU</td>
                                        <td>IOU Payment</td>
                                        <td><?php echo number_format($res['payment_amount'],2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>TOTAL AMOUNT</td>
                                        <td colspan="2"></td>
                                        <td>
                                            <span style="font-size: large;font-weight: 700">
                                                <?php echo number_format($res['payment_amount'],2) ?>
                                            </span>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row" style="padding-top: 2%">
                    <div class="col-md-4"> Signature</div>

                    <div class="col-md-8">

                        .........................................................................................................

                    </div>

                </div>

                <div class="row" style="padding-top: 2%">
                    <div class="col-md-12">
                        Joshua M.K Kpakpah (Jnr.)<br/>
                        For & Behalf of TCL
                    </div>

                </div>



            </div>
        </div>
    </div>
</div>


<div class="kt-portlet__foot">
    <div class="kt-form__actions">
        <button type="button" class="btn btn-primary" onclick="printContent('print_this')"><i
                class="flaticon2-printer"></i> Print Bill
        </button>
    </div>
</div>
</div>
