<?php 

namespace App;

use PDO;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env', __DIR__.'/../.env.local');

class Database
{

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
            self::$instance = new PDO("mysql:host=".$_ENV['DB_HOST'].";dbname=".$_ENV['DB_NAME'].";charset=".$_ENV['DB_CHARSET'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }

        return self::$instance;
    }
}