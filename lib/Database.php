<?php 

namespace App;

use PDO;
use Symfony\Component\Dotenv\Dotenv;

// Use .env files to create $_ENV superglobal var
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env', __DIR__.'/../.env.local');

/**
 * Database
 * Connect to the database
 */
class Database
{
    // Singleton pattern
    private static $instance = null;
  
    /**
     * getPdo
     * Return a connection to database
     *
     * @return PDO
     */
    public static function getPdo(): PDO
    {
        
        if(self::$instance === null)
        {
            $envInput = filter_var_array($_ENV, FILTER_SANITIZE_STRING);
            self::$instance = new PDO("mysql:host=".$envInput['DB_HOST'].";dbname=".$envInput['DB_NAME'].";charset=".$envInput['DB_CHARSET'], $envInput['DB_USERNAME'], $envInput['DB_PASSWORD'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }

        return self::$instance;
    }
}