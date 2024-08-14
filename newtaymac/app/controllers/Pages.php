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

}
