<?php

class DatabaseFactory
{
    private static $factory;
    private $database;

    public static function getFactory()
    {
        if (!self::$factory) {
            self::$factory = new DatabaseFactory();
        }
        return self::$factory;
    }

    public function getConnection() {
        if (!$this->database) {

            try {
                $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
                $this->database = new PDO(
                   Config::get('DB_TYPE') . ':host=' . Config::get('DB_HOST') . ';dbname=' .
                   Config::get('DB_NAME') . ';port=' . Config::get('DB_PORT') . ';charset=' . Config::get('DB_CHARSET'),
                   Config::get('DB_USER'), Config::get('DB_PASS'), $options
                   );
            } catch (PDOException $e) {

                echo 'Database connection can not be estabilished. Please try again later.' . '<br>';
                echo 'Error code: ' . $e->getCode();

                exit;
            }
        }
        return $this->database;
    }
}
