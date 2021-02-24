<?php

namespace App;

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

        $controller = new $controllerName();
        $controller->$task();
    }
}
