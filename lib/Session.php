<?php

namespace App;

/**
 * Session
 * Give a session to the application
 */
class Session 
{
    use Http;
     
    static $instance;
    
    /**
     * getInstance
     * Use singleton pattern
     *
     * @return object   the current session or a new session
     */
    static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new Session();
        }
        return self::$instance;
    }
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        session_start();
    }

}