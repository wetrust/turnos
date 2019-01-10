<?php

class Auth
{
    public static function checkAuthentication()
    {
        Session::init();
        if (!Session::userIsLoggedIn()) {
            Session::destroy();
            header('location: ' . Config::get('URL') . 'login?redirect=' . urlencode($_SERVER['REQUEST_URI']));
            exit();
        }
    }

    public static function checkAdminAuthentication()
    {
        Session::init();

        if (!Session::userIsLoggedIn() || Session::get("user_account_type") != 7) {
            Session::destroy();
            header('location: ' . Config::get('URL') . 'login');
            exit();
        }
    }

    public static function checkSessionConcurrency(){
        if(Session::userIsLoggedIn()){
            if(Session::isConcurrentSessionExists()){
                LoginModel::logout();
                Redirect::home();
                exit();
            }
        }
    }
}
