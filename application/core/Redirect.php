<?php

class Redirect
{
    public static function toPreviousViewedPageAfterLogin($path)
    {
        header('location: http://' . $_SERVER['HTTP_HOST'] . '/' . $path);
    }

    public static function home()
    {
        header("location: " . Config::get('URL'));
    }

    public static function to($path)
    {
        header("location: " . Config::get('URL') . $path);
    }
}
