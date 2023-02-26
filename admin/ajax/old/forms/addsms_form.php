<?php include ('../../../config.php');
$random = rand(1,10000).date("Y");
?>
<!--begin::Form-->

<!-- include libraries(jQuery, bootstrap) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>

<form class="" autocomplete="off">
    <div class="kt-portlet__body">


        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="regtype">Applicants</label>

                <select id="regtype" style="width: 100%">
                    <option value="">Select Registration Type</option>
                    <option value="All Applicants">All Applicants</option>
                    <option value="Permanent">Permanent</option>
                    <option value="Provisional">Provisional</option>
                    <option value="Temporal">Temporal</option>
                    <option value="Indexing">Indexing</option>
                    <option value="Examination">Examination</option>
                    <option value="General Public">General Public</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject"
                       placeholder="Enter Subject">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="message">Message</label>
                <textarea id="message" name="editordata"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label>Upload Attachment</label>
            <input type="file" class="form-control" id="upload_attachment">
        </div>

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="saveuser">Submit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->


<script>

    $("#regtype").select2({placeholder: "Select Registration Type"});
    $('#message').summernote({
        placeholder: 'Enter Message here',
        tabsize: 2,
        height: 300
    });

   /* $('#applicant_picture').uploadifive({
        'auto': false,
        'method': 'post',
        'buttonText': 'Upload attachment',
        'fileType': 'image/!*',
        'multi': false,
        'width': 180,
        'formData': {'randno': '<?php echo $random?>'},
        'dnd': false,
        'uploadScript': 'ajax/queries/upload_mail_attachment.php',
        'onUploadComplete': function (file, data) {
            console.log(data);
        },
        'onSelect': function (file) {
            // Update selected so we know they have selected a file
            $("#selected").val('yes');

        },
        'onCancel': function (file) {
            // Update selected so we know they have no file selected
            $("#selected").val('');
        }
    });*/

    $("#saveuser").click(function () {
        var regtype = $("#regtype").val();
        var subject = $("#subject").val();
        var message = $("#message").val();
        var random = '<?php echo $random; ?>';

        var error = '';
        if (regtype == "") {
            error += 'Please select registration type \n';
            $("#regtype").focus();
        }
        if (subject == "") {
            error += 'Please enter subject \n';
            $("#subject").focus();
        }
        if (message == "") {
            error += 'Please enter message \n';
            $("#message").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_sms.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    regtype: regtype,
                    subject: subject,
                    message: message,
                    random:random
                },
                success: function (text) {
                    //alert(text);
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/addsms_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#smsform_div').html(text);
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
                        url: "ajax/tables/addsms_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#smstable_div').html(text);
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