<?php

namespace App;

use App\Controllers\PageController;
use App\Session;

class Application
{
    public static function process()
    {
        // Call session_start() once
        Session::getInstance();

        $controllerName = "Page";
        $task = "show";

        if(!empty($_GET['controller'])) {
            $controllerName = ucfirst($_GET['controller']);
        }

        if(!empty($_GET['task'])) {
            $task = $_GET['task'];
        }

        $controllerName = "\App\Controllers\\" . $controllerName . "Controller";
        
        if (method_exists ( $controllerName, $task )) {
            $controller = new $controllerName();
            $controller->$task();
        } else {
            $controller = new PageController();
            $controller->show404();
        }
    }
}
