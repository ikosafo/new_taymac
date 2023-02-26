<?php include ('../../../config.php');
$random = rand(1,10000).date("Ymd");
?>
<!--begin::Form-->

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="member_name">Name</label>
                <input type="text" class="form-control" id="member_name"
                       placeholder="Enter Member Name">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="member_position">Position</label>
                <input type="text" class="form-control" id="member_position"
                       placeholder="Enter Member Position">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="member_mobile">Mobile</label>
                <input type="text" class="form-control" id="member_mobile"
                       placeholder="Enter Member Mobile">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="member_email">Email</label>
                <input type="text" class="form-control" id="member_email"
                       placeholder="Enter Member Email">
            </div>
        </div>
        
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="member_description">Description</label>
                <textarea class="form-control summernote" id="member_description"
                          placeholder="Enter team Text"></textarea>
            </div>
        </div>

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="saveteam">Submit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->



<script>

    $(".summernote").summernote({
        placeholder: 'Enter team text here',
        tabsize: 2,
        height: 200
    });


    $("#saveteam").click(function () {
        var member_name = $("#member_name").val();
        var member_position = $("#member_position").val();
        var member_mobile = $("#member_mobile").val();
        var member_email = $("#member_email").val();
        var member_description = $("#member_description").val();

        var error = '';
        if (member_name == "") {
            error += 'Please enter name of member\n';
            $("#member_name").focus();
        }
        if (member_position == "") {
            error += 'Please enter member position\n';
            $("#member_position").focus();
        }
        if (member_mobile == "") {
            error += 'Please enter telephone\n';
            $("#member_mobile").focus();
        }
        if (member_email == "") {
            error += 'Please enter email\n';
            $("#member_email").focus();
        }
        if (member_description == "") {
            error += 'Please enter description\n';
            $("#member_description").focus();
        }


        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_team.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    member_name: member_name,
                    member_position: member_position,
                    member_mobile: member_mobile,
                    member_email: member_email,
                    member_description:member_description
                },
                success: function (text) {
                    //alert(text);
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/addteam_form.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#teamform_div').html(text);
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
                        url: "ajax/tables/addteam_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function (text) {
                            $('#teamtable_div').html(text);
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