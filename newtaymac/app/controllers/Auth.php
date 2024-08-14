<?php

class Auth extends Controller
{
    public function login()
    {
        /* unset($_SESSION['uid']);
        unset($_SESSION['username']); */
        session_destroy();
        $this->view('auth/login');
    }

    public function updateuser()
    {
        new Guard();
        $this->view('auth/updateuser');
    }

    public function verifycode()
    {
        new Guard();
        $this->view('auth/verifycode');
    }


    public function logout()
    {
        $username = $_SESSION['username'];
        Tools::logAction("$username Logged out successfully","Successful"); 
        unset($_SESSION['uid']);
        unset($_SESSION['username']);
        session_destroy();

        Redirecting::location('auth/login');
    }
}
