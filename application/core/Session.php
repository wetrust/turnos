<?php

class Session
{
    public static function init()
    {
        if (session_id() == '') {
            session_start([
                'name' => Config::get("COOKIE_NAME")
            ]);
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];

            return Filter::XSSFilter($value);
        }
    }

    public static function add($key, $value)
    {
        $_SESSION[$key][] = $value;
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function updateSessionId($userId, $sessionId = null)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE users SET session_id = :session_id WHERE user_id = :user_id";

        $query = $database->prepare($sql);
        $query->execute(array(':session_id' => $sessionId, ":user_id" => $userId));
    }

    public static function isConcurrentSessionExists()
    {
        $session_id = session_id();
        $userId     = Session::get('user_id');

        if (isset($userId) && isset($session_id)) {

            $database = DatabaseFactory::getFactory()->getConnection();
            $sql = "SELECT session_id FROM users WHERE user_id = :user_id LIMIT 1";

            $query = $database->prepare($sql);
            $query->execute(array(":user_id" => $userId));

            $result = $query->fetch();
            $userSessionId = !empty($result)? $result->session_id: null;

            return $session_id !== $userSessionId;
        }

        return false;
    }

    public static function userIsLoggedIn()
    {
        return (self::get('user_logged_in') ? true : false);
    }
}
