<?php
namespace App\Core;

class Database
{
    private static $instance;

    private function __construct(){}

    private function __clone(){}

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;
            self::$instance = new \PDO($dsn, DB_USER, DB_PASSWORD);
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}
