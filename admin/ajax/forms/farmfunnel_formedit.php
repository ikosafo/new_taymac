<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
$theindex = $_POST['theindex'];

$gettunnel = $mysqli->query("select * from farm_funnel where id = '$theindex'");
$restunnel = $gettunnel->fetch_assoc();
?>
<!--begin::Form-->

<form class="" autocomplete="off">
    <div class="kt-portlet__body">
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="funnel_name">Name of Tunnel</label>
                <input type="text" class="form-control" id="funnel_name"
                       placeholder="Enter Name of Tunnel" value="<?php echo $restunnel['funnel_name'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="funnel_description">Description</label>
                <textarea class="form-control" id="funnel_description"
                          placeholder="Enter Quantity"><?php echo $restunnel['funnel_description'] ?></textarea>
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <button type="button" class="btn btn-primary" id="editfunnel">Edit</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </div>


    </div>

</form>
<!--end::Form-->


<script>

    $('#editfunnel').click(function () {
        var funnel_name = $('#funnel_name').val();
        var funnel_description = $('#funnel_description').val();
        var theindex = '<?php echo $theindex ?>';

        var error = '';
        if (funnel_name == "") {
            error += 'Please enter name of funnel \n';
            $("#funnel_name").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/editform_farmfunnel.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    funnel_name: funnel_name,
                    funnel_description: funnel_description,
                    theindex:theindex
                },
                success: function (text) {
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/farmfunnel_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farmfunnelform_div').html(text);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function () {
                            KTApp.unblockPage();
                        },
                    });

                    $.ajax({
                        type: "POST",
                        url: "ajax/tables/farmfunnel_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#farmfunneltable_div').html(text);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function () {
                            KTApp.unblockPage();
                        },
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                },
                complete: function () {
                    KTApp.unblockPage();
                },
            });

        }
        else {
            $.notify(error, {position: "top center"});
        }
        return false;
    });

</script>