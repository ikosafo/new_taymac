<?php include('../../../config.php');
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];
$year_search = $_POST['select_year'];
$permanentup_status = $_POST['permanentup_status'];
$admintype = $_POST['admintype'];

?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>

<div class="kt-separator kt-separator--dashed"></div>

<div class="kt-section">

    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="la la-search"></i>
                    </span>
                </div>
                <input type="text" id="permanentup_search" class="form-control" placeholder="Search Full Name or email address" aria-describedby="basic-addon1">
            </div>
        </div>
        <small>Type a minimum of three characters and wait for a few seconds</small>
        <div id="permanentup_table"></div>



        <div class="table-responsive" id="prov_table">
            <table id="prov-table" class="table" style="margin-top: 3% !important;">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>PIN</th>
                        <th>MIS Status</th>
                        <th>Admin Status</th>
                        <th>Payment</th>
                        <th>Period Registered</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<script>
    var admintype = '<?php echo $admintype ?>';
    $("#permanentup_search").focus();
    //alert(admintype);

    if (admintype == 'Super Admin') {
        oTable = $('#prov-table').DataTable({
            stateSave: true,
            "bLengthChange": false,
            dom: "rtiplf",
            "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': 'ajax/paginations/permanent_superup.php?year=<?php echo $year_search ?>&status=<?php echo $permanentup_status ?>'
            },
            'columns': [{
                    data: 'provisionalid'
                },
                {
                    data: 'email_address'
                },
                {
                    data: 'provisional_pin'
                },
                {
                    data: 'usercheck_status'
                },
                {
                    data: 'admincheck_status'
                },
                {
                    data: 'payment'
                },
                {
                    data: 'period'
                },
                {
                    data: 'upgrade_id'
                }
            ]
        });
        $("#search_load_btn").click(function() {
            var id_index = $("#selectapplicant").val();
            var id_year = '<?php echo $year_search ?>';
            //alert(id_index+' '+id_year);

            $('html, body').animate({
                scrollTop: $("#approval_div").offset().top
            }, 2000);
            $.ajax({
                type: "POST",
                url: "approvalsuper_permanentup.php",
                data: {
                    id_index: id_index,
                    id_year: id_year
                },
                beforeSend: function() {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                success: function(text) {
                    $('#approval_div').html(text);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                },
                complete: function() {
                    KTApp.unblockPage();
                },
            });
        });
    } else {
        oTable = $('#prov-table').DataTable({
            stateSave: true,
            "bLengthChange": false,
            dom: "rtiplf",
            "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': 'ajax/paginations/permanent_superup.php?year=<?php echo $year_search ?>&status=<?php echo $permanentup_status ?>'
            },
            'columns': [{
                    data: 'provisionalid'
                },
                {
                    data: 'email_address'
                },
                {
                    data: 'provisional_pin'
                },
                {
                    data: 'usercheck_status'
                },
                {
                    data: 'admincheck_status'
                },
                {
                    data: 'payment'
                },
                {
                    data: 'period'
                },
                {
                    data: 'upgrade_id'
                }
            ]
        });
        $("#search_load_btn").click(function() {
            var id_index = $("#selectapplicant").val();
            var id_year = '<?php echo $year_search ?>';
            //alert(id_index+' '+id_year);

            $('html, body').animate({
                scrollTop: $("#approval_div").offset().top
            }, 2000);
            $.ajax({
                type: "POST",
                url: "approvalsuper_permanentup.php",
                data: {
                    id_index: id_index,
                    id_year: id_year
                },
                beforeSend: function() {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                success: function(text) {
                    $('#approval_div').html(text);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                },
                complete: function() {
                    KTApp.unblockPage();
                },
            });
        });
    }


    //setup before functions
    var typingTimer; //timer identifier
    var doneTypingInterval = 2500; //time in ms, 2.5 second for example
    var $input = $('#permanentup_search');

    //on keyup, start the countdown
    $input.on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    //on keydown, clear the countdown 
    $input.on('keydown', function() {
        clearTimeout(typingTimer);
    });

    //user is "finished typing," do something
    function doneTyping() {
        //('start searching');
        //do something
        var txtlen = $input.val().length;
        var permanentup_search = $("#permanentup_search").val();
        var year_search = '<?php echo $year_search ?>';
        var permanentup_status = '<?php echo $permanentup_status ?>';
        var admintype = '<?php echo $admintype ?>';
        //alert(admintype);
        //oTable.search($(this).val()).draw();

        if (txtlen > 2) {
            $("#prov_table").hide();
            $("#permanentup_table").show();
            $.ajax({
                type: "POST",
                url: "ajax/queries/permanentup_search.php",
                beforeSend: function() {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    permanentup_search: permanentup_search,
                    year_search: year_search,
                    permanentup_status: permanentup_status,
                    admintype: admintype
                },
                success: function(text) {
                    //alert(text);
                    $('#permanentup_table').html(text);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                },
                complete: function() {
                    KTApp.unblockPage();
                },
            });
        } else {
            //$("#prov-table").DataTable().ajax.reload(null, false );
            $("#prov_table").show();
            $("#permanentup_table").hide();
        }

    }
</script>