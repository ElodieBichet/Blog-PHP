<?php

namespace App;

class Session 
{

    use Input;
    // Singleton pattern
    static $instance;

    static function getInstance(){
        if(!self::$instance){
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function __construct(){
        session_start();
    }

    static function logout() : void{
        $serverArray = self::getInstance()->collectInput('SERVER');
        session_destroy();
        $url = (!empty($serverArray['PHP_SELF'])) ? $serverArray['PHP_SELF'] : 'index.php';
        Http::redirect($url);
    }

    static function isConnected() : bool{
        $connection = (array_key_exists('connection', $_SESSION)) ? filter_var($_SESSION['connection'], FILTER_SANITIZE_STRING) : false;

        return $connection;
    }

}