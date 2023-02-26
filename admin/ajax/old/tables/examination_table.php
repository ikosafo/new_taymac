<?php include('../../../config.php');
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$examination_status = $_POST['examination_status'];
$examination_type = $_POST['examination_type'];
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
                <input type="text" id="examination_search" class="form-control"
                    placeholder="Search Full Name or email address" 
                    aria-describedby="basic-addon1">
            </div>
        </div>
        <small>Type a minimum of three characters and wait for a few seconds</small>
        <div id="exam_table"></div>
        <div class="table-responsive" id="prov_table">
            <table id="prov-table" class="table" style="margin-top: 3% !important;">
                <thead>
                    <tr>
                        <th width="15%">Full Name</th>
                        <th>Email Address</th>
                        <th>Provisional PIN</th>
                        <th>Officer Status</th>
                        <th>Admin Status</th>
                        <th>Index Number</th>
                        <th>Period<br/>Regsitered</th>
                        <!-- <th width="20%">Examination Details</th>-->
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<script>

    var admintype = '<?php echo $admintype ?>';
    $("#examination_search").focus();
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
                'url': 'ajax/paginations/examination_super.php?type=<?php echo $examination_type ?>&startdate=<?php echo $start_date ?>&enddate=<?php echo $end_date ?>&status=<?php echo $examination_status ?>'
            },
            'columns': [
                {data: 'provisionalid'},
                {data: 'email_address'},
                {data: 'provisional_pin'},
                {data: 'examination_usercheck_status'},
                {data: 'examination_admincheck_status'},
                {data: 'index_number'},
                {data: 'examination_period'},
               /* {data: 'examination_details'},*/
                {data: 'examination_id'}
            ]
        });
    }

    else {
        oTable = $('#prov-table').DataTable({
            stateSave: true,
            "bLengthChange": false,
            dom: "rtiplf",
            "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': 'ajax/paginations/examination_mis.php?type=<?php echo $examination_type ?>&startdate=<?php echo $start_date ?>&enddate=<?php echo $end_date ?>&status=<?php echo $examination_status ?>'
            },
            'columns': [
                {data: 'provisionalid'},
                {data: 'email_address'},
                {data: 'provisional_pin'},
                {data: 'examination_usercheck_status'},
                {data: 'examination_admincheck_status'},
                {data: 'index_number'},
                {data: 'examination_period'},
                /*{data: 'examination_details'},*/
                {data: 'examination_id'}
            ]
        });
    }


    //setup before functions
        var typingTimer;                //timer identifier
        var doneTypingInterval = 2500;  //time in ms, 2.5 second for example
        var $input = $('#examination_search');

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
        var examination_search = $("#examination_search").val();
        var examtype = '<?php echo $examination_type ?>';
        var startdate = '<?php echo $start_date ?>';
        var enddate = '<?php echo $end_date ?>';
        var status = '<?php echo $examination_status ?>';
        var admintype = '<?php echo $admintype ?>';
        //alert(admintype);
        //oTable.search($(this).val()).draw();

            if (txtlen > 2) {
                $("#prov_table").hide();
                $("#exam_table").show();
                $.ajax({
                type: "POST",
                url: "ajax/queries/exam_search.php",
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: "#000000",
                        type: "v2",
                        state: "success",
                        message: "Please wait..."
                    })
                },
                data: {
                    examination_search: examination_search,
                    examtype: examtype,
                    startdate: startdate,
                    enddate:enddate,
                    status:status,
                    admintype:admintype
                },
                success: function (text) {
                    //alert(text);
                    $('#exam_table').html(text);
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
                $("#exam_table").hide();
            }
    
        }

</script>