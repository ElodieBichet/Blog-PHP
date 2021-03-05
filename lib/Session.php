<?php

namespace App;

class Session 
{
    use Http;
    
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

}