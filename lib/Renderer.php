<?php

namespace App;

class Renderer
{
    public static function render(string $type='front', string $path = 'index', array $variables=[])
    {
        // variables initialization
        $pageTitle = 'Page sans titre';
        $alert = '';
        
        extract($variables);

        // Force connection if an admin page is requested (temporary feature while waiting for a real authentication system)
        if ($type=='admin')
        {
            if ( !isset($_SESSION['connection']) OR $_SESSION['connection'] == false )
            {
                $type = 'front';
                $path = 'login';
                $pageTitle = 'Connexion à l\'admin';
            }
            else
            {
                ob_start();
                require('../templates/admin/inc/sidebar.html.php');
                $pageSidebar = ob_get_clean();
            }
        }

        ob_start();
        require('../templates/'.$type.'/inc/header.html.php');
        $pageHeader = ob_get_clean();

        
        ob_start();
        require('../templates/' . $type . '/' . $path . '.html.php');
        $pageContent = ob_get_clean();
    
        require('../templates/'.$type.'/layout.html.php');
    }
}