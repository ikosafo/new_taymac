<?php require('../config.php');
/* $user_id = $_SESSION['user_id'];

 if (!isset($_SESSION['username'])) {
    header("location:login");
}
 */
//set timeout period in seconds
$inactive = 600; //after 600 seconds the user gets logged out
//check to see if $_SESSION['timeout'] is set

/* if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        session_destroy();
        header("location:login");
    }
}
$_SESSION['timeout'] = time();
 */

?>

<!DOCTYPE html>

<html lang="en">
<!-- begin::Head -->

<head>
    <meta charset="utf-8" />

    <title>Allied Health Professions Council | Good Standing Status</title>
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

    <link rel="shortcut icon" href="newassets/img/ahpc_logo.png" />
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

<body style="background-image: url(newassets/media/bg/bg-4.jpg);
 background-position: center bottom;
background-size: 100% 750px;" class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right
      kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled
      kt-subheader--transparent kt-page--loading">

    <!-- begin::Page loader -->
    <div class="loader"></div>
    <!-- end::Page Loader -->
    <!-- begin:: Page -->
    <!-- begin:: Header Mobile -->

    <!-- end:: Header Mobile -->
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                <!-- begin:: Header -->

                <!-- end:: Header -->
                <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
                    <div class="kt-content kt-content--fit-top  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">