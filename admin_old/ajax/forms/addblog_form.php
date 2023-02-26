<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
?>
<!--begin::Form-->

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category"
                       placeholder="Enter Category">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title"
                       placeholder="Enter Title">
            </div>
        </div>
        <div class="form-group">
            <label>Blog Image</label>
            <input type="file" class="form-control" id="blog_image">
            <input type="hidden" id="selected"/>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="title">Content</label>
                <textarea class="form-control summernote" id="content"
                       placeholder="Enter Title"></textarea>
            </div>
        </div>


    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="saveblog">Submit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->



<script>

    $(".summernote").summernote({
        placeholder: 'Enter blog text here',
        tabsize: 2,
        height: 400
    });

    $('#blog_image').uploadifive({
        'auto': false,
        'method': 'post',
        'buttonText': 'Upload image',
        'fileType': 'image/*',
        'multi': false,
        'width': 180,
        'formData': {'randno': '<?php echo $random?>'},
        'dnd': false,
        'uploadScript': 'ajax/queries/upload_blog_image.php',
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
    });


    $("#saveblog").click(function () {
        var category = $("#category").val();
        var title = $("#title").val();
        var content = $("#content").val();
        var selected = $("#selected").val();
        var imageid = '<?php echo $random; ?>';

        var error = '';
        if (category == "") {
            error += 'Please enter category\n';
            $("#category").focus();
        }
        if (title == "") {
            error += 'Please enter title\n';
            $("#title").focus();
        }
        if (selected == "") {
            error += 'Please upload image\n';
            $("#blog_text").focus();
        }
        if (content == "") {
            error += 'Please enter blog content\n';
            $("#content").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_blog.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    category: category,
                    title: title,
                    content: content,
                    selected: selected,
                    imageid:imageid
                },
                success: function (text) {
                    //alert(text);

                    $('#blog_image').uploadifive('upload');
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/addblog_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#blogform_div').html(text);
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
                        url: "ajax/tables/addblog_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#blogtable_div').html(text);
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