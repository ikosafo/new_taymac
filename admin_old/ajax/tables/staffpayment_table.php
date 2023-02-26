<?php
include('../../../config.php');
$payment_type = $_POST['payment_type'];

if ($payment_type == "IOU") {
    $getiou = $mysqli->query("select * from admin_staff_iou ORDER BY payment_period DESC,payment_date DESC,dateupdated DESC")
?>

    <div class="table-responsive">
        <table id="data-table" class="table" style="margin-top: 3% !important;">
            <thead>
            <tr>
                <th>Payment For</th>
                <th>Staff</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Action</th>
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
                        <?php $staffid = $fetch['staff_id'];
                        $getname = $mysqli->query("select * from admin_staff where id = '$staffid'");
                        $resname = $getname->fetch_assoc();
                        echo $resname['staff_name'];
                        ?>
                    </td>
                    <td>
                        <?php echo date('l, F j, Y', strtotime($fetch['payment_date'])) ?>
                    </td>
                    <td>
                        <?php echo $fetch['payment_amount'] ?>
                    </td>
                    <td>
                        <button type="button"
                                data-type="confirm"
                                class="btn btn-sm btn-warning print_staffpayiou"
                                i_index="<?php echo $fetch['id']; ?>"
                                title="Print">
                            <i class="flaticon2-print ml-1" style="color:#fff !important;"></i>
                        </button>
                        <p></p>
                        <button type="button"
                                data-type="confirm"
                                class="btn btn-sm btn-danger delete_staffpayiou"
                                i_index="<?php echo $fetch['id']; ?>"
                                title="Delete">
                            <i class="flaticon2-trash ml-1" style="color:#fff !important;"></i>
                        </button>
                    </td>

                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>

<?php }  else {
    $getsal = $mysqli->query("select * from admin_staff_salary ORDER BY payment_period DESC,payment_date DESC,dateupdated DESC")
    ?>

    <div class="table-responsive">
        <table id="data-table" class="table" style="margin-top: 3% !important;">
            <thead>
            <tr>
                <th>Payment For</th>
                <th>Staff</th>
                <th>Date</th>
                <th>Credit</th>
                <th>Debit</th>
                <th>Net Salary</th>
                <th>Action</th>
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
                        <?php $staffid = $fetch['staff_id'];
                        $getname = $mysqli->query("select * from admin_staff where id = '$staffid'");
                        $resname = $getname->fetch_assoc();
                        echo $resname['staff_name'];
                        ?>
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
                    <td>
                        <button type="button"
                                data-type="confirm"
                                class="btn btn-sm btn-warning print_staffpaysalary"
                                i_index="<?php echo $fetch['id']; ?>"
                                title="Print">
                            <i class="flaticon2-print ml-1" style="color:#fff !important;"></i>
                        </button>
                        <p></p>
                        <button type="button"
                                data-type="confirm"
                                class="btn btn-sm btn-danger delete_staffpaysalary"
                                i_index="<?php echo $fetch['id']; ?>"
                                title="Delete">
                            <i class="flaticon2-trash ml-1" style="color:#fff !important;"></i>
                        </button>
                    </td>

                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>

<?php } ?>


<script>

    oTable = $('#data-table').DataTable({
        "bLengthChange": false,"order": []
    });

    $('#data_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });


    $(document).off('click', '.delete_staffpayiou').on('click', '.delete_staffpayiou', function () {
        var theindex = $(this).attr('i_index');
        //alert(theindex)
        $.confirm({
            title: 'Delete Staff IOU Payment!',
            content: 'Are you sure to continue?',
            buttons: {
                no: {
                    text: 'No',
                    keys: ['enter', 'shift'],
                    backdrop: 'static',
                    keyboard: false,
                    action: function () {
                        $.alert('Data is safe');
                    }
                },
                yes: {
                    text: 'Yes, Delete it!',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.ajax({
                            type: "POST",
                            url: "ajax/queries/delete_staffpayiou.php",
                            data: {
                                i_index: theindex
                            },
                            dataType: "html",
                            success: function (text) {
                                location.reload();
                            },

                            complete: function () {
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            }
                        });
                    }
                }
            }
        });
    });


    $(document).off('click', '.delete_staffpaysalary').on('click', '.delete_staffpaysalary', function () {
        var theindex = $(this).attr('i_index');
        //alert(theindex)
        $.confirm({
            title: 'Delete Staff Salary Payment!',
            content: 'Are you sure to continue?',
            buttons: {
                no: {
                    text: 'No',
                    keys: ['enter', 'shift'],
                    backdrop: 'static',
                    keyboard: false,
                    action: function () {
                        $.alert('Data is safe');
                    }
                },
                yes: {
                    text: 'Yes, Delete it!',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.ajax({
                            type: "POST",
                            url: "ajax/queries/delete_staffpaysalary.php",
                            data: {
                                i_index: theindex
                            },
                            dataType: "html",
                            success: function (text) {
                                location.reload();
                            },

                            complete: function () {
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            }
                        });
                    }
                }
            }
        });
    });


    $(document).off('click', '.print_staffpayiou').on('click', '.print_staffpayiou', function () {
        var theindex = $(this).attr('i_index');
        //alert(theindex);

        $.ajax({
            type: "POST",
            url: "ajax/forms/staffpayiouprint_form.php",
            beforeSend: function () {
                KTApp.blockPage({
                    overlayColor: "#000000",
                    type: "v2",
                    state: "success",
                    message: "Please wait..."
                })
            },
            data:{
                theindex:theindex
            },
            success: function (text) {
                $('#searchptable_div').html(text);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function () {
                KTApp.unblockPage();
            },
        });
    });


    $(document).off('click', '.print_staffpaysalary').on('click', '.print_staffpaysalary', function () {
        var theindex = $(this).attr('i_index');
        //alert(theindex);

        $.ajax({
            type: "POST",
            url: "ajax/forms/staffpaysalaryprint_form.php",
            beforeSend: function () {
                KTApp.blockPage({
                    overlayColor: "#000000",
                    type: "v2",
                    state: "success",
                    message: "Please wait..."
                })
            },
            data:{
                theindex:theindex
            },
            success: function (text) {
                $('#searchptable_div').html(text);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function () {
                KTApp.unblockPage();
            },
        });
    });

</script>

