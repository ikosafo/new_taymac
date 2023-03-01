<?php require('includes/header.php') ?>

<!-- begin:: Subheader -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader"></div>
<!-- end:: Subheader -->


<!-- begin:: Content -->
<div class="kt-container  kt-grid__item kt-grid__item--fluid">
    <!--Begin::Dashboard 3-->

    <div class="row">
        <div class="col-md-6">
            <!--begin:: Widgets/Applications/User/Profile3-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__body">
                    <div class="kt-widget kt-widget--user-profile-3">
                        <div class="kt-widget__top">

                            <div class="kt-widget__content">
                                <div class="kt-widget__head">
                                    <a href="#" class="kt-widget__username">
                                        <?php echo $_SESSION['full_name']; ?>
                                        <i class="flaticon2-user"></i>
                                    </a>
                                </div>

                                <div class="kt-widget__subhead">
                                    <a href="#"><i class="flaticon2-user-1"></i><?php echo $_SESSION['username']; ?></a>
                                    <a href="#"><i class="flaticon2-calendar-3"></i><?php echo $_SESSION['user_type']; ?></a>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget__bottom">

                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">Property</span>
                                    <span class="kt-widget__value"><span><i class="la la-home"></i> </span>
                                        <?php
                                        $getperm = $mysqli->query("select * from `admin_taymac_property`");
                                        echo mysqli_num_rows($getperm);
                                        ?>
                                    </span>
                                </div>
                            </div>

                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">Tenant</span>
                                    <span class="kt-widget__value"><span><i class="la la-users"></i> </span>
                                        <?php
                                        $getperm = $mysqli->query("select * from `admin_taymac_tenant`");
                                        echo mysqli_num_rows($getperm);
                                        ?>
                                    </span>
                                </div>
                            </div>

                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">Staff</span>
                                    <span class="kt-widget__value"><span><i class="la la-users"></i> </span>
                                        <?php
                                        $getperm = $mysqli->query("select * from `admin_staff`");
                                        echo mysqli_num_rows($getperm);
                                        ?>
                                    </span>
                                </div>
                            </div>

                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">Billing</span>
                                    <span class="kt-widget__value"><span><i class="la la-users"></i> </span>
                                        <?php
                                        $getperm = $mysqli->query("select * from `admin_taymac_billing`");
                                        echo mysqli_num_rows($getperm);
                                        ?>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--end:: Widgets/Applications/User/Profile3-->
        </div>
        <div class="col-md-6">
            <div class="card">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>


    <!--End::Row-->
    <!--End::Dashboard 3-->
</div>
<!-- end:: Content -->

<?php require('includes/footer.php') ?>

<script>
    //alert("SITE WILL SHUTDOWN ON WEDNESDAY DUE TO NON-PAYMENT OF FEES");
    "use strict";
    var KTDatatableHtmlTableDemo = {
        init: function() {
            var t;
            t = $(".kt-datatable").KTDatatable({
                data: {
                    saveState: {
                        cookie: !1
                    }
                },
                search: {
                    input: $("#generalSearch")
                },
                columns: [{
                        field: "DepositPaid",
                        type: "number"
                    }, {
                        field: "OrderDate",
                        type: "date",
                        format: "YYYY-MM-DD"
                    },
                    {
                        field: "Status",
                        title: "Status",
                        autoHide: !1,
                        template: function(t) {
                            var e = {
                                1: {
                                    title: "Pending",
                                    class: "kt-badge--brand"
                                },
                                2: {
                                    title: "Approved",
                                    class: " kt-badge--success"
                                },
                                3: {
                                    title: "Rejected",
                                    class: " kt-badge--danger"
                                },
                                4: {
                                    title: "Success",
                                    class: " kt-badge--success"
                                },
                                5: {
                                    title: "Info",
                                    class: " kt-badge--info"
                                },
                                6: {
                                    title: "Danger",
                                    class: " kt-badge--danger"
                                },
                                7: {
                                    title: "Warning",
                                    class: " kt-badge--warning"
                                }
                            };
                            return '<span class="kt-badge ' + e[t.Status].class + ' kt-badge--inline kt-badge--pill">' + e[t.Status].title + "</span>"
                        }
                    },
                    {
                        field: "Type",
                        title: "Type",
                        autoHide: !1,
                        template: function(t) {
                            var e = {
                                1: {
                                    title: "Permanent",
                                    state: "danger"
                                },
                                2: {
                                    title: "Provisional",
                                    state: "primary"
                                },
                                3: {
                                    title: "Temporal",
                                    state: "success"
                                },
                                4: {
                                    title: "Examination",
                                    state: "info"
                                },
                                5: {
                                    title: "Renewal",
                                    state: "warning"
                                },
                                6: {
                                    title: "Indexing",
                                    state: "success"
                                },
                                7: {
                                    title: "None",
                                    state: "warning"
                                }
                            };
                            return '<span class="kt-badge kt-badge--' + e[t.Type].state + ' kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-' + e[t.Type].state + '">' + e[t.Type].title + "</span>"
                        }
                    }
                ]
            }), $("#kt_form_status").on("change", function() {
                t.search($(this).val().toLowerCase(), "Status")
            }), $("#kt_form_type").on("change", function() {
                t.search($(this).val().toLowerCase(), "Type")
            }), $("#kt_form_status,#kt_form_type").selectpicker()
        }
    };
    jQuery(document).ready(function() {
        KTDatatableHtmlTableDemo.init()
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'April', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Bill Paid (2023)',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>