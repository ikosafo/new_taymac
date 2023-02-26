<?php include('../../../config.php');
$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];
//$year_search = $_POST['year_search'];

?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>


<div class="kt-section">
                    <span class="kt-section__info">
                     Applicant's Summary Info
                    </span>
    `
    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">
                                <i class="la la-search"></i>
                            </span></div>
                <input type="text" id="account_search" class="form-control"
                       placeholder="Search Full Name or email address" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="acc-table" class="table" style="margin-top: 3% !important">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Previous Name</th>
                    <th>Email Address</th>
                    <th>Telephone</th>
                    <th>Date/Place of Birth</th>
                    <th>Nationality/<br/>Hometown</th>
                    <th>Region</th>
                    <th>District</th>
                    <th>House Number</th>
                    <th>Street Name</th>
                    <th>Locality</th>
                    <th>Gender</th>
                    <th>Marital Status</th>
                    <th>Profession</th>
                    <th>PIN</th>
                    <th>Provisional Reg</th>
                    <th>Provisional Payment</th>
                    <th>Provisional Date</th>
                    <th>Provisional MIS St.</th>
                    <th>Provisional Super St.</th>
                    <th>Permanent Reg</th>
                    <th>Permanent Payment</th>
                    <th>Permanent Date</th>
                    <th>Permanent MIS St.</th>
                    <th>Permanent Super St.</th>
                    <th>Examination Reg</th>
                    <th>Examination Index No.</th>
                    <th>Temporal Reg</th>
                    <th>Temporal Payment</th>
                    <th>Temporal Date</th>
                    <th>Temporal MIS St.</th>
                    <th>Temporal Super St.</th>
                    <th>Renewal Reg</th>
                    <th>App Id</th>
                    <th>Action</th>

                </tr>
                </thead>
            </table>
        </div>

    </div>
</div>


<script>
    oTable = $('#acc-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/appinfo.php'
        },
        'columns': [
            {data: 'fullname'},
            {data: 'previousname'},
            {data: 'emailaddress'},
            {data: 'telephone'},
            {data: 'birthdate'},
            {data: 'nationality'},
            {data: 'region'},
            {data: 'district'},
            {data: 'housenumber'},
            {data: 'streetname'},
            {data: 'locality'},
            {data: 'gender'},
            {data: 'maritalstatus'},
            {data: 'profession'},
            {data: 'pin'},
            {data: 'provreg'},
            {data: 'provpmt'},
            {data: 'provdate'},
            {data: 'provmis'},
            {data: 'provsuper'},
            {data: 'permreg'},
            {data: 'permpmt'},
            {data: 'permdate'},
            {data: 'permmis'},
            {data: 'permsuper'},
            {data: 'examreg'},
            {data: 'examind'},
            {data: 'temreg'},
            {data: 'tempmt'},
            {data: 'temdate'},
            {data: 'temmis'},
            {data: 'temsuper'},
            {data: 'renewal'},
            {data: 'applicantid'},
            {data: 'action'}
        ]
    });
    $('#account_search').keyup(function () {
        oTable.search($(this).val()).draw();
    })


</script>