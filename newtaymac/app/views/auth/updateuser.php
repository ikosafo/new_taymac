<?php include ('includes/authheader.php'); ?>

    <div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
        <div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
            <div class="login-form login-signin">
                <span class="label label-light-danger label-inline font-weight-bold">
                        <?= ucwords($_SESSION['username']) ?>
                </span>
                <div class="separator separator-dashed mt-3 mb-3"></div>
                <div class="text-center mb-5 mb-lg-5">
                    <h3 class="font-size-h1">Update User Information</h3>
                     <p class="text-muted font-weight-bold">All fields are required</p>
                </div>
               
                <form action="#" class="form" novalidate="novalidate" id="kt_login_signin_form">
                    <div class="form-group">
                        <input class="form-control form-control-solid h-auto py-5 px-6"
                            type="text" placeholder="Job Title" 
                            name="jobtitle"
                            id="jobtitle"
                            autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-solid h-auto py-5 px-6"
                            type="text" placeholder="Department" 
                            name="department"
                            id="department"
                            autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-solid h-auto py-5 px-6"
                            type="text" placeholder="Email Address" 
                            name="emailaddress"
                            id="emailaddress"
                            autocomplete="off" />
                            <span class="form-text text-muted">This is essential for password reset and two-factor authentication</span>
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-solid h-auto py-5 px-6"
                            type="text" placeholder="Telephone" 
                            name="telephone"
                            id="telephone"
                            autocomplete="off" />
                    </div>
                    <input type="hidden" id="uid" value="<?php echo $_SESSION['uid'] ?>">
                    
                    <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                        <a href="login" class="text-dark-50 text-hover-primary my-3 mr-2">Back to Login</a>
                        <button type="button" id="updateUserBtn" class="btn btn-primary font-weight-bold px-9 py-4 my-3">Update</button>
                    </div>
                </form>
                
            </div>
            
           
        </div>      

<?php include ('includes/authfooter.php'); ?>			