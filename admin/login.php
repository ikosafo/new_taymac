<?php include ('../config.php');
session_destroy();

?>
<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>

    <title>Login | Taymac MIS</title>
    <meta name="description" content="Login page example">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <!--end::Fonts -->


    <!--begin::Page Custom Styles(used by this page) -->
    <link href="newassets/css/pages/login/login-6.css" rel="stylesheet" type="text/css"/>
    <!--end::Page Custom Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="newassets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="newassets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles -->

    <link rel="shortcut icon" href="taymac.jpg"/>

</head>
<!-- end::Head -->

<!-- begin::Body -->
<body style="background-image: url(newassets/media/demos/demo4/header.jpg); background-position: center top;
background-size: 100% 350px;" class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right
kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed
kt-subheader--enabled kt-subheader--transparent kt-page--loading">

<!-- begin::Page loader -->

<!-- end::Page Loader -->
<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v6 kt-login--signin" id="kt_login">
        <div
            class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
            <div class="kt-grid__item  kt-grid__item--order-tablet-and-mobile-2  kt-grid kt-grid--hor kt-login__aside">
                <div class="kt-login__wrapper">
                    <div class="kt-login__container">
                        <div class="kt-login__body">
                            <div class="kt-login__logo">
                                <a href="#">
                                    <img src="taymac.jpg" style="width:20%;">
                                </a>
                            </div>

                            <div class="kt-login__signin">
                                <div class="kt-login__head">
                                    <h3 class="kt-login__title">Sign In To Taymac MIS Portal</h3>
                                </div>
                                <div class="kt-login__form">
                                    <form class="kt-form" action="">
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Username"
                                                   name="username"
                                                   id="username" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control form-control-last" id="password"
                                                   type="password" placeholder="Password" name="password">
                                        </div>

                                        <div class="kt-login__actions">
                                            <button id="login_btn" type="button"
                                                    class="btn btn-brand btn-pill btn-elevate">Sign In
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                   
                </div>
            </div>

            <div class="kt-grid__item kt-grid__item--fluid kt-grid__item--center kt-grid kt-grid--ver kt-login__content"
                 style="background-image: url(newassets/media/bg/bg-4.jpg);">
                <div class="kt-login__section">
                    <div class="kt-login__block">
                        <h3 class="kt-login__title">Administrative panel<br/> for Taymac</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end:: Page -->


<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#366cf3",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>
<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="newassets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<script src="newassets/js/scripts.bundle.js" type="text/javascript"></script>
<!--end::Global Theme Bundle -->


</body>
<!-- end::Body -->
</html>


<script>
    "use strict";
    var KTLoginGeneral = function () {
        var i = $("#kt_login"), t = function (i, t, e) {
            var n = $('<div class="alert alert-' + t + ' alert-dismissible" role="alert">\t\t\t<div class="alert-text">' + e + '</div>\t\t\t<div class="alert-close">                <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>            </div>\t\t</div>');
            i.find(".alert").remove(), n.prependTo(i), KTUtil.animateClass(n[0], "fadeIn animated"), n.find("span").html(e)
        }, e = function () {}, n = function () {};
        return {
            init: function () {
                n(),

                    $("#login_btn").click(function (i) {
                    var username = $('#username').val();
                    var password = $('#password').val();
                    i.preventDefault();
                    var e = $(this), n = $(this).closest("form");
                    n.validate({
                        rules: {
                            username: {required: !0},
                            password: {required: !0}
                        }
                    }), n.valid() && (e.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0),
                        n.ajaxSubmit({
                            type: "POST",
                            url: "ajax/loginscripts/loginaction.php",
                            data: {
                                username: username,
                                password: password
                            },
                        success: function (text) {
                            //alert(text)
                            if (text == 1) {
                                window.location.href = "/admin/";
                            }
                            else {
                                setTimeout(function () {
                                    e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1),
                                        t(n, "danger", "Incorrect username or password. Please try again.")
                                }, 2e3)
                            }
                        }
                    }))
                })
            }
        }
    }();
    jQuery(document).ready(function () {
        KTLoginGeneral.init()
    });
</script>
