<?php

class PasswordResetModel
{
    public static function requestPasswordReset($user_name_or_email, $captcha)
    {
        if (!CaptchaModel::checkCaptcha($captcha)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_CAPTCHA_WRONG'));
            return false;
        }

        if (empty($user_name_or_email)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_EMAIL_FIELD_EMPTY'));
            return false;
        }

        $result = UserModel::getUserDataByUserNameOrEmail($user_name_or_email);
        if (!$result) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USER_DOES_NOT_EXIST'));
            return false;
        }

        $temporary_timestamp = time();
        $user_password_reset_hash = sha1(uniqid(mt_rand(), true));

        $token_set = self::setPasswordResetDatabaseToken($result->user_name, $user_password_reset_hash, $temporary_timestamp);
        if (!$token_set) {
            return false;
        }

        $mail_sent = self::sendPasswordResetMail($result->user_name, $user_password_reset_hash, $result->user_email);
        if ($mail_sent) {
            return true;
        }

        return false;
    }

    public static function setPasswordResetDatabaseToken($user_name, $user_password_reset_hash, $temporary_timestamp)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE users
                SET user_password_reset_hash = :user_password_reset_hash, user_password_reset_timestamp = :user_password_reset_timestamp
                WHERE user_name = :user_name AND user_provider_type = :provider_type LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':user_password_reset_hash' => $user_password_reset_hash, ':user_name' => $user_name,
            ':user_password_reset_timestamp' => $temporary_timestamp, ':provider_type' => 'DEFAULT'
        ));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_RESET_TOKEN_FAIL'));
        return false;
    }

    public static function sendPasswordResetMail($user_name, $user_password_reset_hash, $user_email)
    {
        $body = Config::get('EMAIL_PASSWORD_RESET_CONTENT') . ' ' . Config::get('URL') .
                Config::get('EMAIL_PASSWORD_RESET_URL') . '/' . urlencode($user_name) . '/' . urlencode($user_password_reset_hash);

        $mail = new Mail;
        $mail_sent = $mail->sendMail($user_email, Config::get('EMAIL_PASSWORD_RESET_FROM_EMAIL'),
            Config::get('EMAIL_PASSWORD_RESET_FROM_NAME'), Config::get('EMAIL_PASSWORD_RESET_SUBJECT'), $body
        );

        if ($mail_sent) {
            Session::add('feedback_positive', Text::get('FEEDBACK_PASSWORD_RESET_MAIL_SENDING_SUCCESSFUL'));
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_RESET_MAIL_SENDING_ERROR') . $mail->getError() );
        return false;
    }

    public static function verifyPasswordReset($user_name, $verification_code)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, user_password_reset_timestamp
                  FROM users
                 WHERE user_name = :user_name
                       AND user_password_reset_hash = :user_password_reset_hash
                       AND user_provider_type = :user_provider_type
                 LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':user_password_reset_hash' => $verification_code, ':user_name' => $user_name,
            ':user_provider_type' => 'DEFAULT'
        ));

        if ($query->rowCount() != 1) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_RESET_COMBINATION_DOES_NOT_EXIST'));
            return false;
        }

        $result_user_row = $query->fetch();
        $timestamp_one_hour_ago = time() - 3600;

        if ($result_user_row->user_password_reset_timestamp > $timestamp_one_hour_ago) {
            Session::add('feedback_positive', Text::get('FEEDBACK_PASSWORD_RESET_LINK_VALID'));
            return true;
        } else {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_RESET_LINK_EXPIRED'));
            return false;
        }
    }

    public static function saveNewUserPassword($user_name, $user_password_hash, $user_password_reset_hash)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE users SET user_password_hash = :user_password_hash, user_password_reset_hash = NULL,
                       user_password_reset_timestamp = NULL
                 WHERE user_name = :user_name AND user_password_reset_hash = :user_password_reset_hash
                       AND user_provider_type = :user_provider_type LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':user_password_hash' => $user_password_hash, ':user_name' => $user_name,
            ':user_password_reset_hash' => $user_password_reset_hash, ':user_provider_type' => 'DEFAULT'
        ));

        return ($query->rowCount() == 1 ? true : false);
    }

    public static function setNewPassword($user_name, $user_password_reset_hash, $user_password_new, $user_password_repeat)
    {
        if (!self::validateResetPassword($user_name, $user_password_reset_hash, $user_password_new, $user_password_repeat)) {
            return false;
        }

        $user_password_hash = password_hash($user_password_new, PASSWORD_DEFAULT);

        if (self::saveNewUserPassword($user_name, $user_password_hash, $user_password_reset_hash)) {
            Session::add('feedback_positive', Text::get('FEEDBACK_PASSWORD_CHANGE_SUCCESSFUL'));
            return true;
        } else {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_CHANGE_FAILED'));
            return false;
        }
    }

    public static function validateResetPassword($user_name, $user_password_reset_hash, $user_password_new, $user_password_repeat)
    {
        if (empty($user_name)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_FIELD_EMPTY'));
            return false;
        } else if (empty($user_password_reset_hash)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_RESET_TOKEN_MISSING'));
            return false;
        } else if (empty($user_password_new) || empty($user_password_repeat)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_FIELD_EMPTY'));
            return false;
        } else if ($user_password_new !== $user_password_repeat) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_REPEAT_WRONG'));
            return false;
        } else if (strlen($user_password_new) < 6) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_TOO_SHORT'));
            return false;
        }

        return true;
    }


    public static function saveChangedPassword($user_name, $user_password_hash)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE users SET user_password_hash = :user_password_hash
                 WHERE user_name = :user_name
                 AND user_provider_type = :user_provider_type LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':user_password_hash' => $user_password_hash, ':user_name' => $user_name,
            ':user_provider_type' => 'DEFAULT'
        ));

        return ($query->rowCount() == 1 ? true : false);
    }


    public static function changePassword($user_name, $user_password_current, $user_password_new, $user_password_repeat)
    {
        if (!self::validatePasswordChange($user_name, $user_password_current, $user_password_new, $user_password_repeat)) {
            return false;
        }

        $user_password_hash = password_hash($user_password_new, PASSWORD_DEFAULT);

        if (self::saveChangedPassword($user_name, $user_password_hash)) {
            Session::add('feedback_positive', Text::get('FEEDBACK_PASSWORD_CHANGE_SUCCESSFUL'));
            return true;
        } else {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_CHANGE_FAILED'));
            return false;
        }
    }


    public static function validatePasswordChange($user_name, $user_password_current, $user_password_new, $user_password_repeat)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_password_hash, user_failed_logins FROM users WHERE user_name = :user_name LIMIT 1;";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':user_name' => $user_name
        ));

        $user = $query->fetch();

        if ($query->rowCount() == 1) {
            $user_password_hash = $user->user_password_hash;
        } else {
            Session::add('feedback_negative', Text::get('FEEDBACK_USER_DOES_NOT_EXIST'));
            return false;
        }

        if (!password_verify($user_password_current, $user_password_hash)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_CURRENT_INCORRECT'));
            return false;
        } else if (empty($user_password_new) || empty($user_password_repeat)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_FIELD_EMPTY'));
            return false;
        } else if ($user_password_new !== $user_password_repeat) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_REPEAT_WRONG'));
            return false;
        } else if (strlen($user_password_new) < 6) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_TOO_SHORT'));
            return false;
        } else if ($user_password_current == $user_password_new){
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_NEW_SAME_AS_CURRENT'));
            return false;
        }

        return true;
    }
}
