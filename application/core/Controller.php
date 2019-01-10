<?php

class Controller
{
    public $View;

    public function __construct()
    {
        Session::init();

        Auth::checkSessionConcurrency();

        if (!Session::userIsLoggedIn() AND Request::cookie('remember_me')) {
            header('location: ' . Config::get('URL') . 'login/loginWithCookie');
        }

        $this->View = new View();
    }
}
