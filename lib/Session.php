<?php

namespace App;

/**
 * Session
 * Give a session to the application
 */
class Session 
{
    use Http;
     
    private static $instance;
    
    /**
     * getInstance
     * Use singleton pattern
     *
     * @return object   the current session or a new session
     */
    static function getInstance(): object
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
        session_regenerate_id(true); 
    }

}