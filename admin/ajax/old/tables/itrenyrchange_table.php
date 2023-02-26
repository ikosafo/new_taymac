<?php include('../../../config.php');
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];
$year_search = $_POST['select_year'];
$renewal_status = $_POST['renewal_status'];

?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>


<div class="kt-section">
    <div class="kt-section__content responsive">

    <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                            <i class="la la-search"></i>
                    </span>
                </div>
                <input type="text" id="renewal_search" class="form-control"
                    placeholder="Search Full Name or email address" 
                    aria-describedby="basic-addon1">
            </div>
        </div>
        <small>Type a minimum of three characters and wait for a few seconds</small>
        <div id="renewal_table"></div>

        <div class="table-responsive" id="prov_table">
            <table id="prov-table" class="table" style="margin-top: 3% !important;">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>PIN</th>
                        <th>Renewal Year</th>
                        <th>Period Registered</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
    //alert('test');
    $("#renewal_search").focus();

    oTable = $('#prov-table').DataTable({
            stateSave: true,
            "bLengthChange": false,
            dom: "rtiplf",
            "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': 'ajax/paginations/itrenyrchange.php?year=<?php echo $year_search ?>&status=<?php echo $renewal_status ?>'
            },
            'columns': [
                {data: 'provisionalid'},
                {data: 'email_address'},
                {data: 'renewal_pin'},
                {data: 'renewal_year'},
                {data: 'renewal_period'},
                {data: 'applicant_id'}
            ]
        });

         //setup before functions
     var typingTimer;                //timer identifier
        var doneTypingInterval = 2500;  //time in ms, 2.5 second for example
        var $input = $('#renewal_search');

        //on keyup, start the countdown
        $input.on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown 
        $input.on('keydown', function () {
        clearTimeout(typingTimer);
        });

        //user is "finished typing," do something
        function doneTyping () {
            //('start searching');
        //do something
        var txtlen = $input.val().length;
        var renewal_search = $("#renewal_search").val();
        var year_search = '<?php echo $year_search ?>';
        var renewal_status = '<?php echo $renewal_status ?>';


            if (txtlen > 2) {
                $("#prov_table").hide();
                $("#renewal_table").show();
                $.ajax({
                type: "POST",
                url: "ajax/queries/renewalyrchange_search.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    renewal_search: renewal_search,
                    year_search:year_search,
                    renewal_status:renewal_status
                },
                success: function (text) {
                    //alert(text);
                    $('#renewal_table').html(text);
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
                //$("#prov-table").DataTable().ajax.reload(null, false );
                $("#prov_table").show();
                $("#renewal_table").hide();
            }
    
        }


</script>

