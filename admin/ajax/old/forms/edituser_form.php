<?php include('../../../config.php');

$theindex = $_POST['theindex'];
$userindex = $_POST['user_index'];

$query = $mysqli->query("select * from mis_users where id = '$theindex'");
$result = $query->fetch_assoc();


?>
<!--begin::Form-->
<p>
    Edit User
</p>

<form class="" autocomplete="off">
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" placeholder="Enter Full Name" value="<?php echo $result['full_name']; ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="fullname">Remove Permission</label>

                <?php $getpermission = $mysqli->query("select * from permission where user_id = $userindex");
                while ($respermission = $getpermission->fetch_assoc()) {
                ?>
                    <table class="table">
                        <tr>
                            <td width="70%"><?php echo $respermission['permission'] ?></td>
                            <td width="30%"><a href="#" class="remove_permission" p_index="<?php echo $respermission['id'] ?>" user_index="<?php echo $userindex ?>" i_index="<?php echo $theindex ?>">
                                    Remove
                                </a>
                            </td>
                        </tr>
                    </table>

                <?php }
                ?>

            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="permissions">Reassign Permissions <br /> (<small style="color:red !important;">
                        NB: This will overwrite the current permissions. Ignore if you are not sure</small>)</label>

                <select id="permission" multiple style="width: 100%">
                    <option value="">Select Permission</option>
                    <option value="All Permissions">All Permissions</option>
                    <option value="Configuration">Configuration</option>
                    <option value="Add User">Add User</option>
                    <option value="Provisional Registration">Provisional Registration</option>
                    <option value="Examination Registration">Examination Registration</option>
                    <option value="Examination Registration for Upgrade">Examination Registration for Upgrade</option>
                    <option value="Permanent Registration">Permanent Registration</option>
                    <option value="Permanent Renewal (CPD)">Permanent Renewal (CPD)</option>
                    <option value="Permanent Registration (Upgrade)">Permanent Registration (Upgrade)</option>
                    <option value="Temporal Pin Renewal">Temporal Registration</option>
                    <option value="Temporal Pin Renewal">Temporal PIN Renewal</option>

                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="permissions">User Type</label> <br />
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline1" <?php if (@$result['approval'] == "Regular") echo "checked" ?> name="approval" value="Regular" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline1">Regular</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2" <?php if (@$result['approval'] == "MIS Admin") echo "checked" ?> name="approval" value="MIS Admin" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline2">MIS Admin</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline3" <?php if (@$result['approval'] == "Super Admin") echo "checked" ?> name="approval" value="Super Admin" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline3">Super Admin</label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12 col-md-12">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter Username" value="<?php echo $result['username']; ?>">
            </div>
        </div>



    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="button" class="btn btn-primary" id="edituser">Edit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</form>
<!--end::Form-->



<script>
    $("#permission").select2({
        placeholder: "Select Permission(s)"
    });

    $(document).off('click', '.remove_permission').on('click', '.remove_permission', function() {
        var pindex = $(this).attr('p_index');
        var userindex = $(this).attr('user_index');
        var theindex = $(this).attr('i_index');
        //alert(userindex+' '+theindex);
        $.confirm({
            title: 'Delete Permission!',
            content: 'Are you sure to continue?',
            buttons: {
                no: {
                    text: 'No',
                    keys: ['enter', 'shift'],
                    backdrop: 'static',
                    keyboard: false,
                    action: function() {
                        $.alert('Data is safe');
                    }
                },
                yes: {
                    text: 'Yes, Delete it!',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.ajax({
                            type: "POST",
                            url: "ajax/queries/delete_permission.php",
                            data: {
                                p_index: pindex
                            },
                            dataType: "html",
                            success: function(text) {
                                $.ajax({
                                    url: "ajax/tables/adduser_table.php",
                                    beforeSend: function() {
                                        KTApp.blockPage({
                                            overlayColor: "#000000",
                                            type: "v2",
                                            state: "success",
                                            message: "Please wait..."
                                        })
                                    },
                                    success: function(text) {
                                        $('#usertable_div').html(text);
                                    },
                                    error: function(xhr, ajaxOptions, thrownError) {
                                        alert(xhr.status + " " + thrownError);
                                    },
                                    complete: function() {
                                        KTApp.unblockPage();
                                    },
                                });

                                $.ajax({
                                    type: "POST",
                                    url: "ajax/forms/edituser_form.php",
                                    beforeSend: function() {
                                        KTApp.blockPage({
                                            overlayColor: "#000000",
                                            type: "v2",
                                            state: "success",
                                            message: "Please wait..."
                                        })
                                    },
                                    data: {
                                        theindex: theindex,
                                        userindex: userindex
                                    },
                                    success: function(text) {
                                        $('#userform_div').html(text);
                                    },
                                    error: function(xhr, ajaxOptions, thrownError) {
                                        alert(xhr.status + " " + thrownError);
                                    },
                                    complete: function() {
                                        KTApp.unblockPage();
                                    },
                                });
                            },

                            complete: function() {},
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            }
                        });
                    }
                }
            }
        });


    });


    $("#saveuser").click(function() {

        var full_name = $("#fullname").val();
        var user_id = '<?php echo $userindex; ?>';
        var approval = $('input[name=approval]:checked').val();
        var permission = $("#permission").val();
        var username = $("#username").val();
        var password = $("#password").val();
        var confirm_password = $("#confirmpassword").val();

        var error = '';

        if (full_name == "") {
            error += 'Please enter full name\n';
            $("#fullname").focus();
        }
        if (approval == undefined) {
            error += 'Please select user type \n';
        }
        if (permission == "") {
            error += 'Please select permission\n';
            $("#permission").focus();
        }
        if (username == "") {
            error += 'Please enter username\n';
            $("#username").focus();
        }
        if (password == "") {
            error += 'Please enter password \n';
            $("#password").focus();
        }
        if (password != "" && password.length < 6) {
            error += 'Minimum characters should be six \n';
            $("#password").focus();
        }
        if (password != "" && confirm_password == "") {
            error += 'Please confirm password \n';
            $("#confirmpassword").focus();
        }
        if (confirm_password != "" && password != confirm_password) {
            error += 'Passwords are not the same \n';
            $("#confirm_password").focus();
        }

        if (error == "") {

            $.ajax({
                type: "POST",
                url: "ajax/queries/saveform_user.php",
                beforeSend: function() {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    full_name: full_name,
                    permission: permission,
                    username: username,
                    password: password,
                    user_id: user_id,
                    approval: approval
                },
                success: function(text) {
                    $.ajax({
                        type: "POST",
                        url: "ajax/forms/adduser_form.php",
                        beforeSend: function() {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function(text) {
                            $('#userform_div').html(text);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function() {
                            KTApp.unblockPage();
                        },

                    });


                    $.ajax({
                        type: "POST",
                        url: "ajax/tables/adduser_table.php",
                        beforeSend: function() {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        success: function(text) {
                            $('#usertable_div').html(text);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function() {
                            KTApp.unblockPage();
                        },

                    });
                },

                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                },
                complete: function() {
                    KTApp.unblockPage();
                },

            });


        } else {

            $.notify(error, {
                position: "top center"
            });

        }
        return false;


    });
</script>