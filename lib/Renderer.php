<?php

namespace App;

class Renderer
{

    public static function render(string $type='front', string $path = 'index', bool $isConnected = false, array $variables=[])
    {
        // variables initialization
        $pageTitle = 'Page sans titre';
        $alert = '';
        
        extract($variables);

        if ($type == 'front')
        {

            $navConnectLink = array('href' => 'index.php?login', 'label' => 'Connexion');
            $navAdminDisplay = ' d-none';

            if($isConnected) {
                $navConnectLink = array('href' => 'index.php?logout', 'label' => 'Déconnexion');
                $navAdminDisplay = '';
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