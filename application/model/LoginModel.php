<?php

class LoginModel
{

    public static function login($user_name, $user_password, $set_remember_me_cookie = null)
    {

        if (empty($user_name) OR empty($user_password)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_OR_PASSWORD_FIELD_EMPTY'));
            return false;
        }

        $result = self::validateAndGetUser($user_name, $user_password);

        if (!$result) {
            return false;
        }

        if ($result->user_deleted == 1) {
            Session::add('feedback_negative', Text::get('FEEDBACK_DELETED'));
            return false;
        }

        if ($result->user_suspension_timestamp != null && $result->user_suspension_timestamp - time() > 0) {
            $suspensionTimer = Text::get('FEEDBACK_ACCOUNT_SUSPENDED') . round(abs($result->user_suspension_timestamp - time())/60/60, 2) . " hours left";
            Session::add('feedback_negative', $suspensionTimer);
            return false;
        }

        if ($result->user_last_failed_login > 0) {
            self::resetFailedLoginCounterOfUser($result->user_name);
        }

        self::saveTimestampOfLoginOfUser($result->user_name);

        if ($set_remember_me_cookie) {
            self::setRememberMeInDatabaseAndCookie($result->user_id);
        }

        self::setSuccessfulLoginIntoSession(
            $result->user_id, $result->user_name, $result->user_email, $result->user_account_type
        );

        return true;
    }

    private static function validateAndGetUser($user_name, $user_password)
    {
        if (Session::get('failed-login-count') >= 3 AND (Session::get('last-failed-login') > (time() - 30))) {
            Session::add('feedback_negative', Text::get('FEEDBACK_LOGIN_FAILED_3_TIMES'));
            return false;
        }

        $result = UserModel::getUserDataByUsername($user_name);

        if (!$result) {

            self::incrementUserNotFoundCounter();

            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_OR_PASSWORD_WRONG'));
            return false;
        }

        if (($result->user_failed_logins >= 3) AND ($result->user_last_failed_login > (time() - 30))) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_WRONG_3_TIMES'));
            return false;
        }

        if (!password_verify($user_password, $result->user_password_hash)) {
            self::incrementFailedLoginCounterOfUser($result->user_name);
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_OR_PASSWORD_WRONG'));
            return false;
        }

        if ($result->user_active != 1) {
            Session::add('feedback_negative', Text::get('FEEDBACK_ACCOUNT_NOT_ACTIVATED_YET'));
            return false;
        }

        self::resetUserNotFoundCounter();

        return $result;
    }

    private static function resetUserNotFoundCounter()
    {
        Session::set('failed-login-count', 0);
        Session::set('last-failed-login', '');
    }

    private static function incrementUserNotFoundCounter()
    {
        Session::set('failed-login-count', Session::get('failed-login-count') + 1);
        Session::set('last-failed-login', time());
    }

    public static function loginWithCookie($cookie)
    {
        if (!$cookie) {
            Session::add('feedback_negative', Text::get('FEEDBACK_COOKIE_INVALID'));
            return false;
        }

        if (count (explode(':', $cookie)) !== 3) {
            Session::add('feedback_negative', Text::get('FEEDBACK_COOKIE_INVALID'));
            return false;
        }

        list ($user_id, $token, $hash) = explode(':', $cookie);

        $user_id = Encryption::decrypt($user_id);

        if ($hash !== hash('sha256', $user_id . ':' . $token) OR empty($token) OR empty($user_id)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_COOKIE_INVALID'));
            return false;
        }

        $result = UserModel::getUserDataByUserIdAndToken($user_id, $token);

        if ($result) {

            self::setSuccessfulLoginIntoSession($result->user_id, $result->user_name, $result->user_email, $result->user_account_type);

            self::saveTimestampOfLoginOfUser($result->user_name);

            Session::add('feedback_positive', Text::get('FEEDBACK_COOKIE_LOGIN_SUCCESSFUL'));
            return true;
        } else {
            Session::add('feedback_negative', Text::get('FEEDBACK_COOKIE_INVALID'));
            return false;
        }
    }

    public static function logout()
    {
        $user_id = Session::get('user_id');

        self::deleteCookie($user_id);

        Session::destroy();
        Session::updateSessionId($user_id);
    }

    public static function setSuccessfulLoginIntoSession($user_id, $user_name, $user_email, $user_account_type)
    {
        Session::init();

        session_regenerate_id(true);
        $_SESSION = array();

        Session::set('user_id', $user_id);
        Session::set('user_name', $user_name);
        Session::set('user_email', $user_email);
        Session::set('user_account_type', $user_account_type);
        Session::set('user_provider_type', 'DEFAULT');

        Session::set('user_avatar_file', AvatarModel::getPublicUserAvatarFilePathByUserId($user_id));
        Session::set('user_gravatar_image_url', AvatarModel::getGravatarLinkByEmail($user_email));

        Session::set('user_logged_in', true);

        Session::updateSessionId($user_id, session_id());

        setcookie(session_name(), session_id(), time() + Config::get('SESSION_RUNTIME'), Config::get('COOKIE_PATH'),
            Config::get('COOKIE_DOMAIN'), Config::get('COOKIE_SECURE'), Config::get('COOKIE_HTTP'));

    }

    public static function incrementFailedLoginCounterOfUser($user_name)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE users
                   SET user_failed_logins = user_failed_logins+1, user_last_failed_login = :user_last_failed_login
                 WHERE user_name = :user_name OR user_email = :user_name
                 LIMIT 1";
        $sth = $database->prepare($sql);
        $sth->execute(array(':user_name' => $user_name, ':user_last_failed_login' => time() ));
    }

    public static function resetFailedLoginCounterOfUser($user_name)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE users
                   SET user_failed_logins = 0, user_last_failed_login = NULL
                 WHERE user_name = :user_name AND user_failed_logins != 0
                 LIMIT 1";
        $sth = $database->prepare($sql);
        $sth->execute(array(':user_name' => $user_name));
    }

    public static function saveTimestampOfLoginOfUser($user_name)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE users SET user_last_login_timestamp = :user_last_login_timestamp
                WHERE user_name = :user_name LIMIT 1";
        $sth = $database->prepare($sql);
        $sth->execute(array(':user_name' => $user_name, ':user_last_login_timestamp' => time()));
    }

    public static function setRememberMeInDatabaseAndCookie($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $random_token_string = hash('sha256', mt_rand());

        $sql = "UPDATE users SET user_remember_me_token = :user_remember_me_token WHERE user_id = :user_id LIMIT 1";
        $sth = $database->prepare($sql);
        $sth->execute(array(':user_remember_me_token' => $random_token_string, ':user_id' => $user_id));

        $cookie_string_first_part = Encryption::encrypt($user_id) . ':' . $random_token_string;
        $cookie_string_hash       = hash('sha256', $user_id . ':' . $random_token_string);
        $cookie_string            = $cookie_string_first_part . ':' . $cookie_string_hash;

        setcookie('remember_me', $cookie_string, time() + Config::get('COOKIE_RUNTIME'), Config::get('COOKIE_PATH'),
            Config::get('COOKIE_DOMAIN'), Config::get('COOKIE_SECURE'), Config::get('COOKIE_HTTP'));
    }

    public static function deleteCookie($user_id = null)
    {

        if (isset($user_id)) {

            $database = DatabaseFactory::getFactory()->getConnection();

            $sql = "UPDATE users SET user_remember_me_token = :user_remember_me_token WHERE user_id = :user_id LIMIT 1";
            $sth = $database->prepare($sql);
            $sth->execute(array(':user_remember_me_token' => NULL, ':user_id' => $user_id));
        }

        setcookie('remember_me', false, time() - (3600 * 24 * 3650), Config::get('COOKIE_PATH'),
            Config::get('COOKIE_DOMAIN'), Config::get('COOKIE_SECURE'), Config::get('COOKIE_HTTP'));
    }

    public static function isUserLoggedIn()
    {
        return Session::userIsLoggedIn();
    }
}
