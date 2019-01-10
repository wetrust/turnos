<?php

class Csrf
{
    public static function makeToken()
    {
        $max_time    = 60 * 60 * 24;
        $stored_time = Session::get('csrf_token_time');
        $csrf_token  = Session::get('csrf_token');

        if ($max_time + $stored_time <= time() || empty($csrf_token)) {
            Session::set('csrf_token', md5(uniqid(rand(), true)));
            Session::set('csrf_token_time', time());
        }

        return Session::get('csrf_token');
    }

    public static function isTokenValid()
    {
        $token = Request::post('csrf_token');
        return $token === Session::get('csrf_token') && !empty($token);
    }
}
