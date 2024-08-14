<?php

class Pages extends Controller
{
    
    public function index()
    {
        $this->view("pages/index");
    }

    public function notfound()
    {
        $this->view("pages/404");
    }

    public function login()
    {
        $this->view('pages/login');
    }

   /*  public function mail()
    {
        print_r(SendEmail::compose('yawshadi23@gmail.com', 'hello', 'how are you doing today'));
    } */

}
