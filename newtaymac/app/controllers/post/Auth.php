<?php

class Auth extends PostController
{
    public function login()
    {
        /* foreach ($_POST as $name => $value) {
            $$name = $value;
        } */
       $username = $_POST['username'];
       $password = $_POST['password'];

        users::login($username,$password);
    }

    public function updateuser()
    {
       $id = $_POST['id'];
       $jobtitle = $_POST['jobtitle'];
       $department = $_POST['department'];
       $emailaddress = $_POST['emailaddress'];
       $telephone = $_POST['telephone'];

        users::updateuser($id,$jobtitle,$department,$emailaddress,$telephone);
    }

    public function verifycode()
    {
       $id = $_POST['id'];
       $verification_code = $_POST['verification_code'];
    
        users::verifycode($id,$verification_code);
    }
}
