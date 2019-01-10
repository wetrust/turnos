<?php

class Text
{
    private static $texts;

    public static function get($key, $data = null)
    {

        if (!$key) {
            return null;
        }

        if ($data) {
            foreach ($data as $var => $value) {
                ${$var} = $value;
            }
        }


        if (!self::$texts) {
            self::$texts = require('../application/config/texts.php');
        }

        if (!array_key_exists($key, self::$texts)) {
            return null;
        }

        return self::$texts[$key];
    }
}
