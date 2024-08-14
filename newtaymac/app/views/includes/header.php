<?php
$currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="shortcut icon" href="<?php echo URLROOT ?>/assets/images/taymac.png">
    <title>Taymac - REALTORS you can trust</title>
    <link href="<?php echo URLROOT ?>/assets/plugins/aos/aos.min.css" rel="stylesheet">
    <link href="<?php echo URLROOT ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URLROOT ?>/assets/plugins/smartmenus/jquery.smartmenus.bootstrap-4.css" rel="stylesheet">
    <link href="<?php echo URLROOT ?>/assets/plugins/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="<?php echo URLROOT ?>/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo URLROOT ?>/assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="<?php echo URLROOT ?>/assets/plugins/select2-bootstrap-5/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <link href="<?php echo URLROOT ?>/assets/plugins/OwlCarousel2/css/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo URLROOT ?>/assets/plugins/OwlCarousel2/css/owl.theme.default.min.css" rel="stylesheet">
    <link href="<?php echo URLROOT ?>/assets/plugins/magnific-popup/magnific-popup.css" rel="stylesheet">
    <!-- Custom Style For This Template -->
    <link href="<?php echo URLROOT ?>/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Page Loader -->
    <div class="page-loader-wrapper flex-column align-items-center justify-content-center">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p class="fs-12 fw-semibold mb-0 mt-3 text-uppercase">Please wait...</p>
        </div>
    </div>
    <!-- /.Page Loader -->
   <!-- Start Topbar -->
	<div class="topbar d-none d-lg-block bg-light text-dark">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-4 col-lg-3 col-xl-3">
					<a href="<?php echo URLROOT ?>/pages/index" class="headerLogo">
						<img src="<?php echo URLROOT ?>/assets/images/taymac.png" alt="" height="60">
					</a>
				</div>
				<div class="col-md-8 col-lg-9 col-xl-9 d-none d-md-block">
					<div class="d-flex justify-content-end">
						<div class="d-flex align-items-center help-info">
							<div class="flex-shrink-0 icon">
								<i class="fa-clock fa-solid fs-30 text-dark"></i>
							</div>
							<div class="flex-grow-1 ms-3">
								<h6 class="fs-15 fw-semibold help-info__title mb-0 text-dark">MON - FRI: 08:00AM - 17:00PM</h6>
								<p class="sub-text mb-0 fs-14 text-dark">Saturday and Sunday - <span class="fw-semibold text-warning">CLOSED</span></p>
							</div>
						</div>
						<div class="d-flex align-items-center help-info ms-4">
							<div class="flex-shrink-0 icon">
								<i class="fa-solid fa-mobile-button fs-30 text-dark"></i>
							</div>
							<div class="flex-grow-1 ms-3">
								<h6 class="fs-15 fw-semibold help-info__title mb-0 text-dark">233 (0) 245-710-614</h6>
								<p class="sub-text mb-0 fs-14 text-dark">Contact Us For Help</p>
							</div>
						</div>
						<div class="d-flex align-items-center help-info ms-4">
							<div class="flex-shrink-0 icon">
								<i class="fa-solid fa-street-view fs-30 text-dark"></i>
							</div>
							<div class="flex-grow-1 ms-3">
								<h6 class="fs-15 fw-semibold help-info__title mb-0 text-dark">14 Choice Close off Senchi Street</h6>
								<p class="sub-text mb-0 fs-14 text-dark">Airport Residential Area, Accra</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.End Topbar -->






    <!-- Start Navbar -->
    <div class="navbar-wrap sticky-top no-logo">
        <div class="container-lg nav-container position-relative">
            <nav class="custom-navbar navbar navbar-expand-lg">
                <!-- Start Navbar Brand-->
                <a class="border-end navbar-brand pe-3 pe-sm-4 py-0" href="<?php echo URLROOT ?>/pages/index">
                    <img class="logo-dark" src="<?php echo URLROOT ?>/assets/images/taymac.png" alt="">
                    <img class="logo-white" src="<?php echo URLROOT ?>/assets/images/taymac.png" alt="">
                </a>
                <!-- End Navbar Brand-->
                <!-- Start Navbar Collapse -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Start Navbar Collapse Header -->
                    <div class="align-items-center border-bottom d-flex d-lg-none  justify-content-between mb-3 navbar-collapse__header pb-3">
                        <!-- Start Brand Logo For Mobile -->
                        <div class="collapse-brand flex-shrink-0">
                            <a href="<?php echo URLROOT ?>/pages/index"><img src="<?php echo URLROOT ?>/assets/images/taymac.png" alt=""></a>
                        </div>
                        <!-- End Brand Logo For Mobile -->
                        <!-- Start Collapse Close Button -->
                        <div class="flex-grow-1 ms-3 text-end">
                            <button type="button" class="bg-transparent border-0 collapse-close p-0 position-relative"><span></span> <span></span></button>
                        </div>
                        <!-- End Collapse Close Button -->
                    </div>
                    <!-- End Navbar Collapse Header -->
                    <ul class="navbar-nav">
						<li class="nav-item"><a class="nav-link active" href="<?php echo URLROOT ?>/pages/index">Home</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#">
                                About Us
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Who we are</a></li>
                                <li><a class="dropdown-item" href="#">Team</a></li>
                                <li><a class="dropdown-item" href="#">Testimonials</a></li>
                            </ul>
                        </li>
						<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#">
								What We Do
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Property Management</a></li>
                                <li><a class="dropdown-item" href="#">Health and Safety</a></li>
                                <li><a class="dropdown-item" href="#">Taymac Farms</a></li>
                            </ul>
                        </li>
						<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#">
                                Other Services
                            </a>
                            <ul class="dropdown-menu mega-menu">
                                <li>
                                    <span class="row">
                                        <span class="col-6">
                                            <a class="dropdown-item col-6" href="#">Risk Management</a>
                                            <a class="dropdown-item col-6" href="home-2.html">Trainings</a>
                                            <a class="dropdown-item col-6" href="home-3.html">Risk Accessment Courses</a>
                                        </span>
                                        <span class="col-6">
                                            <a class="dropdown-item col-6" href="#">First Aid</a>
                                            <a class="dropdown-item col-6" href="#">Manual Handling</a>
                                            <a class="dropdown-item col-6" href="#">COSHH</a>
                                        </span>
                                    </span>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                    </ul>
                </div>
                <!-- /. End Navbar Collapse -->
                <div class="d-flex gap-1 ms-lg-5">
                    <!-- Start Cart Button -->
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#cartEmpty" class="align-items-center btn cart-button d-none d-xl-flex ms-2 ms-lg-0">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="ms-2">Cart</span>
                        <span class="align-items-center cart-quantity d-flex fw-bold justify-content-center ms-2 rounded-circle">0</span>
                    </a>
                    <!-- For Mobile -->
                    <a href="cart.html" class="btn btn-primary d-none d-sm-inline-block d-xl-none"><i class="fa-solid fa-cart-shopping"></i></a>
                    <!-- /. End Cart Button -->
                    <!-- Start Login & Signup Button -->
                    <a href="signin.html" class="btn btn-primary btn-login hstack gap-2">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <div class="vr d-none d-sm-inline-block"></div>
                        <span class="d-none d-sm-inline-block">Login / Signup</span>
                    </a>
                    <!-- /. End Login & Signup Button -->
                    <!-- Start Navbar Toggler Buton -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- /. End Navbar Toggler Buton -->
                </div>
            </nav>
        </div>
    </div>
    <!-- /.End of navbar -->