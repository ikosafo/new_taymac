<?php include ('includes/authheader.php'); 
?>
			
	<div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
		<div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
			<div class="login-form login-signin">
				<div class="text-center mb-10 mb-lg-20">
					<h3 class="font-size-h1">Sign In</h3>
					<p class="text-muted font-weight-bold">Enter your username and password</p>
				</div>
				<form action="#" class="form" novalidate="novalidate" id="kt_login_signin_form">
					<div class="form-group">
						<input class="form-control form-control-solid h-auto py-5 px-6"
							type="text" placeholder="Username" 
							name="username"
							id="username"
							autocomplete="off" />
					</div>
					<div class="form-group">
						<input class="form-control form-control-solid h-auto py-5 px-6" type="password" 
						placeholder="Password" 
						id="password"
						name="password" autocomplete="off" />
					</div>
					<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
						<a href="javascript:;" class="text-dark-50 text-hover-primary my-3 mr-2" id="kt_login_forgot">Forgot Password ?</a>
						<button type="button" id="loginBtn" class="btn btn-primary font-weight-bold px-9 py-4 my-3">Sign In</button>
					</div>
				</form>
				
			</div>
			
			<form class="form" novalidate="novalidate" id="kt_login_signup_form"></form>
			
			<div class="login-form login-forgot">
				<div class="text-center mb-10 mb-lg-20">
					<h3 class="font-size-h1">Forgotten Password ?</h3>
					<p class="text-muted font-weight-bold">Enter your email to reset your password</p>
				</div>
				<form class="form" novalidate="novalidate" id="kt_login_forgot_form">
					<div class="form-group">
						<input class="form-control form-control-solid h-auto py-5 px-6" 
						id="emailaddress"
						type="email" placeholder="Email" name="email" autocomplete="off" />
					</div>
					<div class="form-group d-flex flex-wrap flex-center">
						<button type="button" id="forgotpasswordBtn" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Submit</button>
						<button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	
<?php include ('includes/authfooter.php'); ?>