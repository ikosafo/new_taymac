<?php
/**
 * Created by PhpStorm.
 * User: astro
 * Date: 25-Feb-18
 * Time: 10:24
 */

class FrameworkSession {
	
	public $loginuser;

	public function __construct($postdata){
		$email = trim($postdata['email']);
		$password = trim($postdata['password']);

		if($loginuser = $this->checkpassword($email,$password)){
			if (!$this->checkGlobalGuards($loginuser)){
				throw  new frameworkError("Global guards failed - should not see this message (403 should have occurred)!");
			}
			if(!$this->createUserSession($loginuser)){
				throw  new frameworkError("Error creating user session!");
			}
		} else {
			$redirect = new Pages();
			$redirect->view("pages/login",['message' => "Email or password incorrect",'type' => 'danger']);
			exit();
		}
		// everything should be fine!
		$this->loginuser = $loginuser;

		// Log the new login. Let's also log the user role.
        $uroles = implode (", ",$this->loginuser->listRoles());
        new Logger(
            "User with roles $uroles logged in.",
            null,
            $this->loginuser->recordObject->email);
	}

	private function checkpassword($email,$password){
		if($loginuser = User::getUserByParam('email',$email)) {
			if ($loginuser->recordObject->password == md5($password)) {
				return $loginuser;
			} else {
				return false;
			}
		}
		// shouldn't get here, but if we do, return false!
		return false;
	}

	private function checkGlobalGuards($loginuser){

	    // if the user is a developer, don't even bother with guards
        if($loginuser->hasRole('developer')){
            return true;
        }

		// if the user is 'deleted', redirect to the index as if the account did not exist
		if($loginuser->hasRole('deleted')){
			$redirect = new Pages();
			$redirect->view('pages/index');
		}

		// if the user is locked, 403 and say so
		if($loginuser->hasRole('locked')){
			Core::unauthorized('User account locked');
		}

		// no login at all if maintenance mode is on
		if(MAINTENANCE === true){
			$redirect = new Pages();
			$redirect->view('pages/index',['message' => "Login disabled in maintenance mode"]);
		}
		// adding a control here so that in devmode only super admins can log in
		$adminroles = array( 'Super administrator' );
		if ( DEVMODE === true && ! $loginuser->hasRole( $adminroles ) ) {
			unset( $loginuser );
			$redirect = new Pages();
			$redirect->view('pages/index',['message' => "Login restricted in development mode"]);
			exit();
		}
		return true;
	}

	private function createUserSession($loginuser){
		$userRecordObject = $loginuser->recordObject;

		$_SESSION['uid']        = $userRecordObject->uid;
		$_SESSION['status']        = $userRecordObject->status;
		$_SESSION['name']= $userRecordObject->firstname.' '.$userRecordObject->lastname;

		return true;
	}
}