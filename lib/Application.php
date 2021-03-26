<?php

namespace App;

use App\Controllers\PageController;
use App\Session;

/**
 * Application
 * Allow site processing
 */
class Application
{   
    /**
     * process
     * Launch the website
     *
     * @return void
     */
    public static function process(): void
    {
        // Fix default timezone (defined in config.php)
        date_default_timezone_set(TIMEZONE);

        // Call session_start() once
        $session = Session::getInstance();
        
        $controllerName = "Page";
        $task = "show";
        $getArray = $session->collectInput('GET');
        
        if(!empty($getArray['controller'])) $controllerName = ucfirst($getArray['controller']);
        
        if(!empty($getArray['task'])) $task = ucfirst($getArray['task']);
        
        $controllerName = "\App\Controllers\\" . $controllerName . "Controller";

        if (method_exists($controllerName, $task))
        {
            $controller = new $controllerName();
            $controller->$task();
        }
        // else
        if (!method_exists($controllerName, $task))
        {
            $controller = new PageController();
            $controller->redirect('index.php?page=404-error');
        }
    }
}
