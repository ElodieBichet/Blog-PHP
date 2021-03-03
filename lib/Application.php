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
            $controllerName = Controller::filter_string(ucfirst($_GET['controller']));
        }

        if(!empty($_GET['task'])) {
            $task = Controller::filter_string($_GET['task']);
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
