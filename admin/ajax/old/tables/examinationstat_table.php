<?php include('../../../config.php');

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$profession = $_POST['profession'];


?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>
PAGE UNDER CONSTRUCTION
<div class="kt-separator kt-separator--dashed"></div>

<!--<div class="kt-section">

    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                                <i class="la la-search"></i>
                    </span>
                </div>
                <input type="text" id="examination_search" class="form-control"
                       placeholder="Search Full Name or email address" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="col-md-4">
            <!--begin:: Portlet-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <!--begin::Widget -->
                    <!--<div class="kt-widget kt-widget--project-1">
                        <div class="kt-widget__head d-flex">
                            <div class="kt-widget__label">

                                <div class="kt-widget__info kt-padding-0 kt-margin-l-15">
                                    <a href="#" class="kt-widget__title">
                                        Nexa - Next generation SAAS
                                    </a>
                                <span class="kt-widget__desc">
                                    Creates Limitless possibilities
                                </span>
                                </div>
                            </div>
                            <div class="kt-widget__toolbar">
                                <a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown">
                                    <i class="flaticon-more-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right">
                                    <ul class="kt-nav">
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-line-chart"></i>
                                                <span class="kt-nav__link-text">Reports</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-send"></i>
                                                <span class="kt-nav__link-text">Messages</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-pie-chart-1"></i>
                                                <span class="kt-nav__link-text">Charts</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-avatar"></i>
                                                <span class="kt-nav__link-text">Members</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-settings"></i>
                                                <span class="kt-nav__link-text">Settings</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="kt-widget__body">
                        <span class="kt-widget__text kt-margin-t-0 kt-padding-t-5">
                            I distinguish three main text objecttives.First
                            your objective could be merely
                        </span>

                            <div class="kt-widget__stats kt-margin-t-20">
                                <div class="kt-widget__item d-flex align-items-center kt-margin-r-30">
                                <span class="kt-widget__date kt-padding-0 kt-margin-r-10">
                                    Start
                                </span>
                                    <div class="kt-widget__label">
                                        <span class="btn btn-label-brand btn-sm btn-bold btn-upper">07 may, 18</span>
                                    </div>
                                </div>
                                <div class="kt-widget__item d-flex align-items-center kt-padding-l-0">
                                <span class="kt-widget__date kt-padding-0 kt-margin-r-10 ">
                                    Due
                                </span>
                                    <div class="kt-widget__label">
                                        <span class="btn btn-label-danger btn-sm btn-bold btn-upper">07 0ct, 18</span>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-widget__container">
                                <span class="kt-widget__subtitel">Progress</span>
                                <div class="kt-widget__progress d-flex align-items-center flex-fill">
                                    <div class="progress" style="height: 5px;width: 100%;">
                                        <div class="progress-bar kt-bg-success" role="progressbar" style="width: 78%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                <span class="kt-widget__stat">
                                    78%
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="kt-widget__footer">
                            <div class="kt-widget__wrapper">
                                <div class="kt-widget__section">
                                    <div class="kt-widget__blog">
                                        <i class="flaticon2-list-1"></i>
                                        <a href="#" class="kt-widget__value kt-font-brand">64 Tasks</a>
                                    </div>
                                    <div class="kt-widget__blog">
                                        <i class="flaticon2-talk"></i>
                                        <a href="#" class="kt-widget__value kt-font-brand">654 Comments</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <!--end::Widget -->
                </div>
            </div>
            <!--end:: Portlet-->
        </div>


        <div class="table-responsive">
           <!-- <table id="general-table" class="table" style="margin-top: 3% !important;">
                <thead>
                <tr>
                    <th width="15%">Full Name</th>
                    <th>Email Address</th>
                    <th>Provisional Pin</th>
                    <th>Officer Status</th>
                    <th>Admin Status</th>
                    <th>Index Number</th>
                    <th>Period<br/>Regsitered</th>

                    <th>Action</th>
                </tr>
                </thead>
            </table>-->
        </div>
    </div>
</div>


<script>

    oTable = $('#general-table').DataTable({
        stateSave: true,
        "bLengthChange": false,
        dom: "rtiplf",
        "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/paginations/examinationreg.php'
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

    $('#examination_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

</script>