<?php 

namespace App;

use PDO;

class Database
{

    const DB_HOST = 'localhost';
    const DB_NAME = 'my_blog';
    const DB_CHARSET = 'utf8';
    const DB_USERNAME = 'root';
    const DB_PASSWORD = '';

    // Singleton pattern
    private static $instance = null;

    /**
     * Return a connection to database
     * 
     * @return PDO
     */
    public static function getPdo(): PDO
    {
        if(self::$instance === null)
        {
            self::$instance = new PDO("mysql:host=".self::DB_HOST.";dbname=".self::DB_NAME.";charset=".self::DB_CHARSET, self::DB_USERNAME, self::DB_PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }

        return self::$instance;
    }
}