<?php
include ('../../../config.php');
$id = $_POST['id_index'];
$year_search = $_POST['year_search'];
$get_mes = $mysqli->query("select * from messages where id = '$id'");
$res_mes = $get_mes->fetch_assoc();

?>


<div class="form-group">
    <label for="inputAddressName">Message</label>
            <textarea readonly rows="6" id="message" class="form-control"><?php echo $res_mes['message']; ?>
            </textarea>
</div>


<div class="form-group">
    <label for="inputAddress1">Reply</label>
    <textarea id="reply" rows="6" class="form-control" placeholder="Enter a reply here"><?php echo $res_mes['reply']; ?></textarea>
</div>

<button type="button" id="reply_message_btn" class="btn btn-primary">Reply message</button>


<script>

    $("#reply_message_btn").click(function () {
        //alert('hi');
        var message_id = '<?php echo $id; ?>';
        var year_search = '<?php echo $year_search; ?>';
        var reply = $("#reply").val();

        var error = '';
        if (reply == "") {
            error += 'Please reply message \n';
            $("#reply").focus();
        }

        if (error == "") {

            $.ajax({
                type: "POST",
                url: "ajax/queries/reply_message.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    message_id:message_id,
                    reply: reply
                },
                success: function (text) {
                    //alert(text);
                    $.notify("Message Replied", "success", {position: "top center"});
                    $.ajax({
                        type: "POST",
                        url: "ajax/tables/messages_table.php",
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: "#000000",
                                type: "v2",
                                state: "success",
                                message: "Please wait..."
                            })
                        },
                        data: {
                            year_search: year_search
                        },
                        success: function (text) {
                            $('#messages_table_div').html(text);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function () {
                            KTApp.unblockPage();
                        },

                    });
                    $('html, body').animate({
                        scrollTop: $("#messages_table_div").offset().top
                    }, 2000);
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
