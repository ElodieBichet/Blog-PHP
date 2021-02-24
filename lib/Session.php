<?php

namespace App;

class Session {

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

    static function logout(){
        session_destroy();
        Http::redirect($_SERVER['PHP_SELF']);
    }

}