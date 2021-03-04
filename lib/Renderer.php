<?php

namespace App;

class Renderer
{
    public static function render(string $type='front', string $path = 'index', array $variables=[])
    {
        // variables initialization
        $pageTitle = 'Page sans titre';
        $alert = '';
        $isConnected = Session::isConnected();
        
        extract($variables);

        if ($type == 'front')
        {
            ob_start();  
            echo '<li class="nav-item">
                <a class="nav-link" href="index.php?login">Connexion</a>
            </li>';
            $navbarItems = ob_get_clean();

            if($isConnected) {
                ob_start();
                echo '<li class="nav-item">
                    <a class="btn btn-primary" href="index.php?admin">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?logout">Déconnexion</a>
                </li>';
                $navbarItems = ob_get_clean();
            }

        }

        // Get the admin sidebar template
        if ($type=='admin')
        {
            ob_start();
            require('../templates/admin/inc/sidebar.html.php');
            $pageSidebar = ob_get_clean();
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