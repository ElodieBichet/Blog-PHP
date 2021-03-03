<?php

namespace App;

use App\Controllers\Controller;
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
            $controllerName = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_STRING);
            $controllerName = ucfirst($controllerName);
        }

        if(!empty($_GET['task'])) {
            $task = filter_input(INPUT_GET, 'task', FILTER_SANITIZE_STRING);
            $task = Controller::filter_string($task);
        }

        $controllerName = "\App\Controllers\\" . $controllerName . "Controller";

        if (method_exists ( $controllerName, $task )) {
            $controller = new $controllerName();
            $controller->$task();
        }
        // else
        if (!method_exists( $controllerName, $task )) {
            $controller = new PageController();
            $controller->show404();
        }
    }
}
