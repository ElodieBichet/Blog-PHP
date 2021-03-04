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
        session_destroy();
        $url = (!empty($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : 'index.php';
        Http::redirect($url);
    }

    static function isConnected() : bool{
        if(empty($_SESSION)) {
            $_SESSION['connection'] = false;
        }

        return $_SESSION['connection'];
    }

}