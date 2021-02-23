<?php

namespace App;

class Renderer
{
    public static function render(string $type='front', string $path, array $variables=[])
    {
        
        extract($variables);
        
        // Force connection if an admin page is requested (temporary feature while waiting for a real authentication system)
        if (($type=='admin') AND (!isset($_SESSION['connection']) OR $_SESSION['connection'] == false)) {
            $type = 'front';
            $path = 'login';
            $pageTitle = 'Connexion à l\'admin';
        }

        $bodyClass = 'container';
        $mainClass = '';

        ob_start();
        require('../templates/'.$type.'/inc/header.html.php');
        $pageHeader = ob_get_clean();

        $pageSidebar = '';

        if ($type=='admin') {
            $bodyClass = 'container-fluid p-0';
            $mainClass = 'col-md-9 ms-sm-auto col-lg-10 px-md-4';
            ob_start();
            require('../templates/'.$type.'/inc/sidebar.html.php');
            $pageSidebar = ob_get_clean();
        }
        
        ob_start();
        require('../templates/' . $type . '/' . $path . '.html.php');
        $pageContent = ob_get_clean();
    
        require('../templates/layout.html.php');
    }
}