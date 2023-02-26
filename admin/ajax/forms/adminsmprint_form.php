<?php include ('../../../config.php');
//$random = date("Hymsdi");
$theindex = $_POST['theindex'];

$getsm = $mysqli->query("select * from admin_taymac_sm where id = '$theindex'");
$ressm = $getsm->fetch_assoc();
$currency = $ressm['sm_currency'];
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
                        SERVICE AND MAINTENANCE
                    </h6>
                </div>

            </div>
            <div class="invoice-summary" style="padding-top: 10%">
                <div class="row">
                    <div class="col-md-5">
                        <b>TAYMAC</b> <br/>
                        GROUND FLOOR, LE PIERRE, 14 SENCHI STREET, AIRPORT RESIDENTIAL AREA<br/>
                        ACCRA - GHANA
                        <p></p>
                        P: P.O. BOX AN 7310<br/>
                        E: mawusi.kpakpah@taymac.org
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5">
                        <b style="text-transform: uppercase"><?php $tenant = $ressm['sm_tenant'];
                            $gettenant = $mysqli->query("select * from admin_taymac_tenant where id = '$tenant'");
                            $restenant = $gettenant->fetch_assoc();
                            echo $tenant_name = $restenant['tenant_name']
                            ?>
                        </b> <br/>
                        CUSTOMER REF: <?php echo $tenant_name.'/'.$ressm['id'].'/'.date('md-y',strtotime($ressm['sm_date'])); ?> <br/>
                        ATTENTION: <?php echo $tenant_name; ?> <br/>
                        INVOICE NUMBER: <?php
                        $smtype = $ressm['sm_type'];
                        if ($smtype == 'Cleaning') {
                            $sminv = 'CLN';
                        }
                        else if ($smtype == 'Air Conditioning') {
                            $sminv = 'ARC';
                        }
                        else if ($smtype == 'Generators') {
                            $sminv = 'GEN';
                        }
                        else if ($smtype == 'Electrical') {
                            $sminv = 'ELE';
                        }
                        else if ($smtype == 'Swimming Pool') {
                            $sminv = 'SWP';
                        }
                        else {
                            $sminv = 'OTH';
                        }
                        echo 'T/'.date('y',strtotime($ressm['sm_date'])).
                            '/'.$sminv.'/'.$ressm['id'].'/'.date('m',strtotime($ressm['sm_date']));?> <br/>
                        DATE: <?php echo date('F j, Y',strtotime($ressm['sm_date'])) ?>
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
                                        <td><?php echo $ressm['sm_type'] ?></td>
                                        <td><?php echo $ressm['sm_description'] ?></td>
                                        <td><?php echo getCurrency($currency).' '.number_format($ressm['sm_amount'],2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>TOTAL AMOUNT</td>
                                        <td colspan="2"></td>
                                        <td>
                                            <span style="font-size: large;font-weight: 700">
                                                <?php echo getCurrency($currency).' '.number_format($ressm['sm_amount'],2) ?>
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
                        SERVICE AND MAINTENANCE
                    </h6>
                </div>

            </div>
            <div class="invoice-summary" style="padding-top: 10%">
                <div class="row">
                    <div class="col-md-5">
                        <b>TAYMAC</b> <br/>
                        GROUND FLOOR, LE PIERRE, 14 SENCHI STREET, AIRPORT RESIDENTIAL AREA<br/>
                        ACCRA - GHANA
                        <p></p>
                        P: P.O. BOX AN 7310<br/>
                        E: mawusi.kpakpah@taymac.org
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5">
                        <b style="text-transform: uppercase"><?php $tenant = $ressm['sm_tenant'];
                            $gettenant = $mysqli->query("select * from admin_taymac_tenant where id = '$tenant'");
                            $restenant = $gettenant->fetch_assoc();
                            echo $tenant_name = $restenant['tenant_name']
                            ?>
                        </b> <br/>
                        CUSTOMER REF: <?php echo $tenant_name.'/'.$ressm['id'].'/'.date('md-y',strtotime($ressm['sm_date'])); ?> <br/>
                        ATTENTION: <?php echo $tenant_name; ?> <br/>
                        INVOICE NUMBER: <?php
                        $billtype = $ressm['sm_type'];
                        if ($billtype == 'CAM Fees') {
                            $sminv = 'CAM';
                        }
                        else if ($billtype == 'Reimburse Bills') {
                            $sminv = 'REB';
                        }
                        else if ($billtype == 'Rent') {
                            $sminv = 'REN';
                        }
                        else {
                            $sminv = 'OTH';
                        }
                        echo 'T/'.date('y',strtotime($ressm['sm_date'])).
                            '/'.$sminv.'/'.$ressm['id'].'/'.date('m',strtotime($ressm['sm_date']));?> <br/>
                        DATE: <?php echo date('F j, Y',strtotime($ressm['sm_date'])) ?>

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
                                        <td><?php echo $sm_type = $ressm['sm_type'];
                                            if($sm_type == "") {
                                                echo $ressm['sm_type_other'];
                                            }
                                            ?></td>
                                        <td><?php echo $ressm['sm_description'] ?></td>
                                        <td><?php echo getCurrency($currency).' '.number_format($ressm['sm_amount'],2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>TOTAL AMOUNT</td>
                                        <td colspan="2"></td>
                                        <td>
                                            <span style="font-size: large;font-weight: 700">
                                                <?php echo getCurrency($currency).' '.number_format($ressm['sm_amount'],2) ?>
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
