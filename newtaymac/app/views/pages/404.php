<!DOCTYPE html>
<html lang="en">
    
<head>
        <meta charset="utf-8" />
        <title>AHPC ADMIN</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="AHPC ADMIN" name="description" />
        <meta content="AHPC ADMIN" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= URLROOT ?>/images/ahpc_logo.png">

        <!-- App css -->
        <link href="<?= URLROOT ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= URLROOT ?>/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= URLROOT ?>/css/app.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg">

        <div class="account-pages my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-8">
                        <div class="text-center">
                            
                            <div>
                                <img src="<?= URLROOT ?>/images/not-found.png" alt="" class="img-fluid" />
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="mt-3">We couldn’t connect the dots</h3>
                        <p class="text-muted mb-5">This page was not found. <br/> You may have mistyped the address or the page may have moved.</p>

                        <a onclick="window.history.go(-1)"  style="color:white" class="btn btn-lg btn-primary mt-4">Take me back </a>
                    </div>
                </div>
            </div>
            <!-- end container -->
        </div>
        <!-- end account-pages -->

        <!-- Vendor js -->
        <script src="<?= URLROOT ?>/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="<?= URLROOT ?>/js/app.min.js"></script>
        
    </body>

</html>