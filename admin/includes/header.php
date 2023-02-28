<?php require('../config.php');
$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['username'])) {
    header("location:login");
}

//set timeout period in seconds
$inactive = 600; //after 600 seconds the user gets logged out
//check to see if $_SESSION['timeout'] is set
if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        session_destroy();
        header("location:login");
    }
}
$_SESSION['timeout'] = time();
$username = $_SESSION['username'];


?>

<!DOCTYPE html>

<html lang="en">
<!-- begin::Head -->

<head>
    <meta charset="utf-8" />

    <title>Taymac | MIS</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <!--end::Fonts -->

    <!--begin::Page Vendors Styles(used by this page) -->
    <link href="newassets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="newassets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="newassets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="newassets/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="newassets/css/pages/login/login-5.css" rel="stylesheet" type="text/css" />
    <link href="newassets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="newassets/jquery-confirm/css/jquery-confirm.css" rel="stylesheet" type="text/css" />
    <link href="assets/vendor/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles -->

    <link rel="shortcut icon" href="taymac.jpg" />
    <script src="newassets/js/jquery.min.js"></script>

    <script type="text/javascript">
        $(window).load(function() {
            $(".loader").fadeOut("slow");
        });

        function printContent(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
            location.reload();
        }
    </script>

</head>


<!-- end::Head -->

<!-- begin::Body -->

<body style="background-image: url(newassets/media/demos/demo4/header.jpg); background-position: center top;
background-size: 100% 350px;" class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right
      kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled
      kt-subheader--transparent kt-page--loading">

    <!-- begin::Page loader -->
    <div class="loader"></div>
    <!-- end::Page Loader -->
    <!-- begin:: Page -->
    <!-- begin:: Header Mobile -->
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="/">
                <img alt="Logo" src="newassets/img/ahpc_logo.png" style="width: 30%" />
            </a>
        </div>
        <div class="kt-header-mobile__toolbar">
            <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more-1"></i></button>
        </div>
    </div>
    <!-- end:: Header Mobile -->
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                <!-- begin:: Header -->
                <div id="kt_header" class="kt-header  kt-header--fixed " data-ktheader-minimize="on">
                    <div class="kt-container ">
                        <!-- begin:: Brand -->
                        <div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
                            <a class="kt-header__brand-logo" href="/">
                                <img alt="Logo" src="taymac.jpg" class="kt-header__brand-logo-default" style="width:60%;background-color: #ffffff" />
                                <img alt="Logo" src="taymac.jpg" style="width:50%" class="kt-header__brand-logo-sticky" />
                            </a>
                        </div>
                        <!-- end:: Brand -->
                        <!-- begin: Header Menu -->
                        <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                        <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
                            <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
                                <ul class="kt-menu__nav ">


                                    <li class="kt-menu__item kt-menu__item--rel <?php echo ($_SERVER['PHP_SELF'] == "/admin/index.php"
                                                                                    ? "kt-menu__item--here" : ""); ?>">
                                        <a href="/admin/" class="kt-menu__link"><span class="kt-menu__link-text">Dashboard</span>
                                        </a>
                                    </li>


                                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?php echo ($_SERVER['PHP_SELF'] == "/admin/website_blogcontent.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/website_blogcomments.php"

                                                                                                            ? "kt-menu__item--here" : ""); ?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Blog <i class="fa fa-caret-down ml-2"></i> </span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>

                                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                                            <ul class="kt-menu__subnav">

                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/website_blogcontent.php"
                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="website_blogcontent" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Add Content</span></a>
                                                </li>

                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/website_blogcomments.php"
                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="website_blogcomments" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">View Comments</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>


                                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_property.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/admin_tenant.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/admin_billing.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/admin_billingpay.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/admin_sm.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/search_property.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/search_tenant.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/search_billtype.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/search_billsent.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/search_billdaterange.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/search_servicedaterange.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/search_servicetype.php"

                                                                                                            ? "kt-menu__item--here" : ""); ?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                            <span class="kt-menu__link-text">Property Mgt.
                                                <i class="fa fa-caret-down ml-2"></i> </span>
                                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                        </a>

                                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                            <ul class="kt-menu__subnav">

                                                <?php
                                                //Property
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_property' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_property.php"
                                                                                    ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="admin_property" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                <span></span></i><span class="kt-menu__link-text">Property</span></a>
                                                    </li>

                                                <?php }
                                                ?>


                                                <?php
                                                //Tenants
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_tenants' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item   <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_tenant.php"
                                                                                    ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="admin_tenant" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Tenant</span></a>
                                                    </li>

                                                <?php }
                                                ?>


                                                <?php
                                                //Billing
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_billing' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item   <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_billing.php"
                                                                                    ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="admin_billing" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Billing</span></a>
                                                    </li>

                                                <?php }
                                                ?>


                                                <?php
                                                //Service and Maintenance
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_service' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item   <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_sm.php"
                                                                                    ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="admin_sm" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Service & Maintenance</span></a>
                                                    </li>

                                                <?php }
                                                ?>

                                                <li class="kt-menu__item  kt-menu__item--submenu   <?php echo ($_SERVER['PHP_SELF'] == "/admin/search_property.php" ||
                                                                                                        $_SERVER['PHP_SELF'] == "/admin/search_tenant.php" ||
                                                                                                        $_SERVER['PHP_SELF'] == "/admin/search_billtype.php" ||
                                                                                                        $_SERVER['PHP_SELF'] == "/admin/search_servicetype.php" ||
                                                                                                        $_SERVER['PHP_SELF'] == "/admin/search_billsent.php" ||
                                                                                                        $_SERVER['PHP_SELF'] == "/admin/search_billdaterange.php" ||
                                                                                                        $_SERVER['PHP_SELF'] == "/admin/search_servicedaterange.php" ||
                                                                                                        $_SERVER['PHP_SELF'] == "/admin/search_servicetype.php"

                                                                                                        ? "kt-menu__item--here" : ""); ?>" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                                        <span class="kt-menu__link-text">Search</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>

                                                    <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                                        <ul class="kt-menu__subnav">

                                                            <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/search_property.php"
                                                                                            ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="search_property" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                        <span></span></i><span class="kt-menu__link-text">Property</span></a>
                                                            </li>
                                                            <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/search_tenant.php"
                                                                                            ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="search_tenant" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                        <span></span></i><span class="kt-menu__link-text">Tenant</span></a>
                                                            </li>
                                                            <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/search_billtype.php"
                                                                                            ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="search_billtype" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                        <span></span></i><span class="kt-menu__link-text">Bill Type</span></a>
                                                            </li>
                                                            <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/search_billsent.php"
                                                                                            ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="search_billsent" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                        <span></span></i><span class="kt-menu__link-text">Bills Delivered</span></a>
                                                            </li>
                                                            <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/search_billdaterange.php"
                                                                                            ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="search_billdaterange" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                        <span></span></i><span class="kt-menu__link-text">Bill By Date Range</span></a>
                                                            </li>
                                                            <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/search_servicetype.php"
                                                                                            ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="search_servicetype" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                        <span></span></i><span class="kt-menu__link-text">Service & Maintenance Type</span></a>
                                                            </li>
                                                            <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/search_servicedaterange.php"
                                                                                            ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="search_servicedaterange" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                        <span></span></i><span class="kt-menu__link-text">Service By Date Range</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_inputs.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_products.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_purchases.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_sales.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_harvest.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_tunnel.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_activity.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_report.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_fertilizer.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_pesticide.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_watering.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_otheractivity.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/search_tunnelactivity.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/search_farmaccounts.php"

                                                                                                            ? "kt-menu__item--here" : ""); ?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                            <span class="kt-menu__link-text">Farm Mgt.
                                                <i class="fa fa-caret-down ml-2"></i> </span>
                                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                        </a>

                                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                            <ul class="kt-menu__subnav">

                                                <?php
                                                //Farm Categories
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_categories' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item  kt-menu__item--submenu   <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_inputs.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_products.php"

                                                                                                            ? "kt-menu__item--here" : ""); ?>" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                                            <span class="kt-menu__link-text">Categories</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>

                                                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                                            <ul class="kt-menu__subnav">

                                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_inputs.php"
                                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="farm_inputs" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                            <span></span></i><span class="kt-menu__link-text">Farm Inputs</span></a>
                                                                </li>
                                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_products.php"
                                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="farm_products" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                            <span></span></i><span class="kt-menu__link-text">Farm Products</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>

                                                <?php }
                                                ?>


                                                <?php
                                                //Farm Finance
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_finance' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item  kt-menu__item--submenu   <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_purchases.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_sales.php"

                                                                                                            ? "kt-menu__item--here" : ""); ?>" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                                            <span class="kt-menu__link-text">Finance</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>

                                                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                                            <ul class="kt-menu__subnav">

                                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_purchases.php"
                                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="farm_purchases" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                            <span></span></i><span class="kt-menu__link-text">Purchase</span></a>
                                                                </li>
                                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_sales.php"
                                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="farm_sales" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                            <span></span></i><span class="kt-menu__link-text">Sales</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>

                                                <?php }
                                                ?>


                                                <?php
                                                //Farm Harvest
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_harvesting' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_harvest.php"
                                                                                    ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="farm_harvest" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                <span></span></i><span class="kt-menu__link-text">Harvest</span></a>
                                                    </li>

                                                <?php }
                                                ?>


                                                <?php
                                                //Farm Tunnels
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_tunnels' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_tunnel.php"
                                                                                    ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="farm_tunnel" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                <span></span></i><span class="kt-menu__link-text">Tunnels</span></a>
                                                    </li>

                                                <?php }
                                                ?>


                                                <?php
                                                //Farm Activities
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_factivities' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item  kt-menu__item--submenu   <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_fertilizer.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_pesticide.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_watering.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/farm_otheractivity.php"

                                                                                                            ? "kt-menu__item--here" : ""); ?>" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                                            <span class="kt-menu__link-text">Farm Activities</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>

                                                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                                            <ul class="kt-menu__subnav">

                                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_fertilizer.php"
                                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="farm_fertilizer" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                            <span></span></i><span class="kt-menu__link-text">Fertilizer Application</span></a>
                                                                </li>
                                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_pesticide.php"
                                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="farm_pesticide" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                            <span></span></i><span class="kt-menu__link-text">Insecticide/Pesticide Application</span></a>
                                                                </li>
                                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_watering.php"
                                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="farm_watering" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                            <span></span></i><span class="kt-menu__link-text">Watering</span></a>
                                                                </li>
                                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_otheractivity.php"
                                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="farm_otheractivity" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                            <span></span></i><span class="kt-menu__link-text">Other Activities</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>

                                                <?php }
                                                ?>


                                                <?php
                                                //Farm Report
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_freport' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/farm_report.php"
                                                                                    ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="farm_report" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                <span></span></i><span class="kt-menu__link-text">Report</span></a>
                                                    </li>


                                                <?php }
                                                ?>


                                                <li class="kt-menu__item  kt-menu__item--submenu   <?php echo ($_SERVER['PHP_SELF'] == "/admin/search_tunnelactivity.php" ||
                                                                                                        $_SERVER['PHP_SELF'] == "/admin/search_farmaccounts.php"

                                                                                                        ? "kt-menu__item--here" : ""); ?>" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                                        <span class="kt-menu__link-text">Search</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>

                                                    <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                                        <ul class="kt-menu__subnav">

                                                            <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/search_tunnelactivity.php"
                                                                                            ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="search_tunnelactivity" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                        <span></span></i><span class="kt-menu__link-text">Tunnel Activity</span></a>
                                                            </li>
                                                            <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/search_farmaccounts.php"
                                                                                            ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="search_farmaccounts" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                        <span></span></i><span class="kt-menu__link-text">Farm Accounts</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                    </li>


                                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_staff.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/admin_staffpaydetails.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/admin_staffpaysearch.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/admin_staffpay.php"

                                                                                                            ? "kt-menu__item--here" : ""); ?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                            <span class="kt-menu__link-text">Staff Mgt.
                                                <i class="fa fa-caret-down ml-2"></i> </span>
                                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                        </a>

                                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                            <ul class="kt-menu__subnav">

                                                <?php
                                                //Staff
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_staff' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_staff.php"
                                                                                    ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="admin_staff" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                <span></span></i><span class="kt-menu__link-text">Staff</span></a>
                                                    </li>


                                                <?php }
                                                ?>


                                                <?php
                                                //Staff Payroll
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_payroll' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item  kt-menu__item--submenu   <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_staffpaydetails.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/admin_staffpaysearch.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/admin_staffpay.php"

                                                                                                            ? "kt-menu__item--here" : ""); ?>" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                                            <span class="kt-menu__link-text">Payroll</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>

                                                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                                            <ul class="kt-menu__subnav">


                                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_staffpay.php"
                                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="admin_staffpay" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                            <span></span></i><span class="kt-menu__link-text">Make Payment</span></a>
                                                                </li>
                                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_staffpaydetails.php"
                                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="admin_staffpaydetails" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                            <span></span></i><span class="kt-menu__link-text">Details/Pay Slip</span></a>
                                                                </li>
                                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_staffpaysearch.php"
                                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="admin_staffpaysearch" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                            <span></span></i><span class="kt-menu__link-text">Search</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>


                                                <?php }
                                                ?>


                                            </ul>
                                        </div>
                                    </li>


                                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_payments.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/admin_accentry.php" ||
                                                                                                            $_SERVER['PHP_SELF'] == "/admin/admin_cashbook.php"

                                                                                                            ? "kt-menu__item--here" : ""); ?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                            <span class="kt-menu__link-text">Accounts Mgt.
                                                <i class="fa fa-caret-down ml-2"></i> </span>
                                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                        </a>

                                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                            <ul class="kt-menu__subnav">

                                                <?php
                                                //Payments
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_apayments' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_payments.php"
                                                                                    ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="admin_payments" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                <span></span></i><span class="kt-menu__link-text">Payments</span></a>
                                                    </li>

                                                <?php }
                                                ?>


                                                <?php
                                                //Accounts Entry
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_aentry' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_accentry.php"
                                                                                    ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="admin_accentry" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                <span></span></i><span class="kt-menu__link-text">Account Entry</span></a>
                                                    </li>

                                                <?php }
                                                ?>


                                                <?php
                                                //Cash Book
                                                $query = $mysqli->query("select * from permission where username = '$username'
                                                AND (permission = 'permission_acashbook' OR permission = 'All Permissions')");
                                                $count = mysqli_num_rows($query);
                                                if ($count == '1') { ?>
                                                    <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_cashbook.php"
                                                                                    ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="admin_cashbook" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                <span></span></i><span class="kt-menu__link-text">Cash Book</span></a>
                                                    </li>

                                                <?php }
                                                ?>


                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_accsearch.php"
                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="admin_accsearch" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span></i><span class="kt-menu__link-text">Search</span></a>
                                                </li>
                                                <li class="kt-menu__item  <?php echo ($_SERVER['PHP_SELF'] == "/admin/admin_accstatement.php"
                                                                                ? "kt-menu__item--active" : ""); ?>" aria-haspopup="true"><a href="admin_accstatement" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span></i><span class="kt-menu__link-text">Account Statement</span></a>
                                                </li>

                                            </ul>
                                        </div>
                                    </li>


                                </ul>
                            </div>
                        </div>


                        <!-- end: Header Menu -->
                        <!-- begin:: Header Topbar -->
                        <div class="kt-header__topbar kt-grid__item">

                            <!--begin: Search -->
                            <div class="kt-header__topbar-item">
                                <div class="kt-header__topbar-wrapper mt-2" data-offset="10px,0px">
                                    <span class="kt-header__topbar-icon" style="background-color: <?php echo ($_SERVER['PHP_SELF'] == "/admin/logs.php"
                                                                                                        ? "rgba(255,255,255,0.2)" : "transparent"); ?>">
                                        <a href="logs">
                                            <i class="fa fa-server"></i>
                                        </a> <!--<i class="flaticon2-search-1"></i>-->
                                    </span>
                                </div>
                            </div>
                            <!--end: Search -->

                            <!--begin: Search -->
                            <div class="kt-header__topbar-item kt-header__topbar-item--search dropdown" id="kt_quick_search_toggle">
                                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                    <span class="kt-header__topbar-icon">
                                        <i class="flaticon2-search-1
					"></i>
                                        <!--<i class="flaticon2-search-1"></i>-->
                                    </span>
                                </div>
                                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
                                    <div class="kt-quick-search kt-quick-search--dropdown kt-quick-search--result-compact" id="kt_quick_search_dropdown">
                                        <form method="get" class="kt-quick-search__form">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span></div>
                                                <input type="text" class="form-control kt-quick-search__input" placeholder="Search...">

                                                <div class="input-group-append"><span class="input-group-text"><i class="la la-close kt-quick-search__close"></i></span></div>
                                            </div>
                                        </form>
                                        <div class="kt-quick-search__wrapper kt-scroll" data-scroll="true" data-height="325" data-mobile-height="200">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Search -->


                            <!--begin: Quick actions -->
                            <div class="kt-header__topbar-item dropdown">
                                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                    <span class="kt-header__topbar-icon">
                                        <i class="flaticon2-user-1"></i>
                                    </span>
                                </div>
                                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
                                    <form>

                                        <!--begin: Grid Nav -->
                                        <div class="kt-grid-nav kt-grid-nav--skin-light">
                                            <div class="kt-grid-nav__row">
                                                <a href="adduser" class="kt-grid-nav__item">
                                                    <span class="kt-grid-nav__icon">
                                                        <i class="flaticon2-user"></i>
                                                    </span>
                                                    <span class="kt-grid-nav__title">Add User</span>
                                                    <!-- <span class="kt-grid-nav__desc">User</span>-->
                                                </a>
                                                <a href="changepassword" class="kt-grid-nav__item">
                                                    <span class="kt-grid-nav__icon">
                                                        <i class="flaticon2-lock"></i>
                                                    </span>
                                                    <span class="kt-grid-nav__title">Change Password</span>
                                                    <!--<span class="kt-grid-nav__desc">Password</span>-->
                                                </a>
                                            </div>
                                        </div>
                                        <!--end: Grid Nav -->
                                    </form>
                                </div>
                            </div>
                            <!--end: Quick actions -->


                            <!--begin: User bar -->
                            <div class="kt-header__topbar-item kt-header__topbar-item--user">
                                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                    <span class="kt-header__topbar-welcome">Hi,</span>
                                    <span class="kt-header__topbar-username"><?php echo $_SESSION['username']; ?></span>
                                </div>
                                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
                                    <!--begin: Navigation -->
                                    <div class="kt-notification">
                                        <a href="userprofile" class="kt-notification__item">
                                            <div class="kt-notification__item-icon">
                                                <i class="flaticon2-calendar-3 kt-font-success"></i>
                                            </div>
                                            <div class="kt-notification__item-details">
                                                <div class="kt-notification__item-title kt-font-bold">
                                                    My Profile
                                                </div>
                                                <div class="kt-notification__item-time">
                                                    User Profile and Details
                                                </div>
                                            </div>
                                        </a>


                                        <div class="kt-notification__custom kt-space-between">
                                            <a href="login" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>

                                        </div>
                                    </div>
                                    <!--end: Navigation -->
                                </div>
                            </div>
                            <!--end: User bar -->
                        </div>
                        <!-- end:: Header Topbar -->
                    </div>
                </div>
                <!-- end:: Header -->
                <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
                    <div class="kt-content kt-content--fit-top  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">