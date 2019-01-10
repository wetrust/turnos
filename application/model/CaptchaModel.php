<?php

class CaptchaModel
{

    public static function generateAndShowCaptcha()
    {

        $captcha = new Gregwar\Captcha\CaptchaBuilder;
        $captcha->build(
            Config::get('CAPTCHA_WIDTH'),
            Config::get('CAPTCHA_HEIGHT')
        );

        Session::set('captcha', $captcha->getPhrase());

        header('Content-type: image/jpeg');
        $captcha->output();
    }

    public static function checkCaptcha($captcha)
    {
        if (Session::get('captcha') && ($captcha == Session::get('captcha'))) {
            return true;
        }

        return false;
    }
}
