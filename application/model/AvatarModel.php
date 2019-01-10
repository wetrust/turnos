<?php

class AvatarModel
{

    public static function getGravatarLinkByEmail($email)
    {
        return 'http://www.gravatar.com/avatar/' .
        md5(strtolower(trim($email))) .
        '?s=' . Config::get('AVATAR_SIZE') . '&d=' . Config::get('GRAVATAR_DEFAULT_IMAGESET') . '&r=' . Config::get('GRAVATAR_RATING');
    }

    public static function getPublicAvatarFilePathOfUser($user_has_avatar, $user_id)
    {
        if ($user_has_avatar) {
            return Config::get('URL') . Config::get('PATH_AVATARS_PUBLIC') . $user_id . '.jpg';
        }

        return Config::get('URL') . Config::get('PATH_AVATARS_PUBLIC') . Config::get('AVATAR_DEFAULT_IMAGE');
    }

    public static function getPublicUserAvatarFilePathByUserId($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("SELECT user_has_avatar FROM users WHERE user_id = :user_id LIMIT 1");
        $query->execute(array(':user_id' => $user_id));

        if ($query->fetch()->user_has_avatar) {
            return Config::get('URL') . Config::get('PATH_AVATARS_PUBLIC') . $user_id . '.jpg';
        }

        return Config::get('URL') . Config::get('PATH_AVATARS_PUBLIC') . Config::get('AVATAR_DEFAULT_IMAGE');
    }

    public static function createAvatar()
    {
        if (self::isAvatarFolderWritable() AND self::validateImageFile()) {

            $target_file_path = Config::get('PATH_AVATARS') . Session::get('user_id');
            self::resizeAvatarImage($_FILES['avatar_file']['tmp_name'], $target_file_path, Config::get('AVATAR_SIZE'), Config::get('AVATAR_SIZE'));
            self::writeAvatarToDatabase(Session::get('user_id'));
            Session::set('user_avatar_file', self::getPublicUserAvatarFilePathByUserId(Session::get('user_id')));
            Session::add('feedback_positive', Text::get('FEEDBACK_AVATAR_UPLOAD_SUCCESSFUL'));
        }
    }

    public static function isAvatarFolderWritable()
    {
        if (is_dir(Config::get('PATH_AVATARS')) AND is_writable(Config::get('PATH_AVATARS'))) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_AVATAR_FOLDER_DOES_NOT_EXIST_OR_NOT_WRITABLE'));
        return false;
    }

    public static function validateImageFile()
    {
        if (!isset($_FILES['avatar_file'])) {
            Session::add('feedback_negative', Text::get('FEEDBACK_AVATAR_IMAGE_UPLOAD_FAILED'));
            return false;
        }

        if ($_FILES['avatar_file']['size'] > 5000000) {
            Session::add('feedback_negative', Text::get('FEEDBACK_AVATAR_UPLOAD_TOO_BIG'));
            return false;
        }

        $image_proportions = getimagesize($_FILES['avatar_file']['tmp_name']);

        if ($image_proportions[0] < Config::get('AVATAR_SIZE') OR $image_proportions[1] < Config::get('AVATAR_SIZE')) {
            Session::add('feedback_negative', Text::get('FEEDBACK_AVATAR_UPLOAD_TOO_SMALL'));
            return false;
        }

        if (!in_array($image_proportions['mime'], array('image/jpeg', 'image/gif', 'image/png'))) {
            Session::add('feedback_negative', Text::get('FEEDBACK_AVATAR_UPLOAD_WRONG_TYPE'));
            return false;
        }

        return true;
    }

    public static function writeAvatarToDatabase($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("UPDATE users SET user_has_avatar = TRUE WHERE user_id = :user_id LIMIT 1");
        $query->execute(array(':user_id' => $user_id));
    }

    public static function resizeAvatarImage($source_image, $destination, $final_width = 44, $final_height = 44)
    {
        $imageData = getimagesize($source_image);
        $width = $imageData[0];
        $height = $imageData[1];
        $mimeType = $imageData['mime'];

        if (!$width || !$height) {
            return false;
        }

        switch ($mimeType) {
            case 'image/jpeg': $myImage = imagecreatefromjpeg($source_image); break;
            case 'image/png': $myImage = imagecreatefrompng($source_image); break;
            case 'image/gif': $myImage = imagecreatefromgif($source_image); break;
            default: return false;
        }

        if ($width > $height) {
            $verticalCoordinateOfSource = 0;
            $horizontalCoordinateOfSource = ($width - $height) / 2;
            $smallestSide = $height;
        } else {
            $horizontalCoordinateOfSource = 0;
            $verticalCoordinateOfSource = ($height - $width) / 2;
            $smallestSide = $width;
        }

        $thumb = imagecreatetruecolor($final_width, $final_height);
        imagecopyresampled($thumb, $myImage, 0, 0, $horizontalCoordinateOfSource, $verticalCoordinateOfSource, $final_width, $final_height, $smallestSide, $smallestSide);

        imagejpeg($thumb, $destination . '.jpg', Config::get('AVATAR_JPEG_QUALITY'));
        imagedestroy($thumb);

        if (file_exists($destination)) {
            return true;
        }
        return false;
    }

    public static function deleteAvatar($userId)
    {
        if (!ctype_digit($userId)) {
            Session::add("feedback_negative", Text::get("FEEDBACK_AVATAR_IMAGE_DELETE_FAILED"));
            return false;
        }

        self::deleteAvatarImageFile($userId);

        $database = DatabaseFactory::getFactory()->getConnection();

        $sth = $database->prepare("UPDATE users SET user_has_avatar = 0 WHERE user_id = :user_id LIMIT 1");
        $sth->bindValue(":user_id", (int)$userId, PDO::PARAM_INT);
        $sth->execute();

        if ($sth->rowCount() == 1) {
            Session::set('user_avatar_file', self::getPublicUserAvatarFilePathByUserId($userId));
            Session::add("feedback_positive", Text::get("FEEDBACK_AVATAR_IMAGE_DELETE_SUCCESSFUL"));
            return true;
        } else {
            Session::add("feedback_negative", Text::get("FEEDBACK_AVATAR_IMAGE_DELETE_FAILED"));
            return false;
        }
    }

    public static function deleteAvatarImageFile($userId)
    {
        if (!file_exists(Config::get('PATH_AVATARS') . $userId . ".jpg")) {
            Session::add("feedback_negative", Text::get("FEEDBACK_AVATAR_IMAGE_DELETE_NO_FILE"));
            return false;
        }

        if (!unlink(Config::get('PATH_AVATARS') . $userId . ".jpg")) {
            Session::add("feedback_negative", Text::get("FEEDBACK_AVATAR_IMAGE_DELETE_FAILED"));
            return false;
        }

        return true;
    }
}
