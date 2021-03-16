<?php

namespace App;

/**
 * Renderer
 * View
 */
class Renderer
{
    
    /**
     * render
     * Display a web page with right templates and variables
     *
     * @param  string   $type   'admin'or 'front' context
     * @param  string   $path   template name without extensions
     * @param  bool     $isConnected    true if the current session has a connected user
     * @param  array    $variables  array with all needed variables used in templates
     * @return void
     */
    public static function render(string $type='front', string $path = 'index', bool $isConnected = false, bool $isAdmin = false, array $variables=[]) : void
    {
        // variables initialization
        $pageTitle = 'Page sans titre';
        $alert = '';
        $sessionTab = (!empty($_SESSION)) ? $_SESSION : array();
        
        extract($variables);

        if ($type == 'front')
        {

            $navAdminLink = array('href' => 'index.php?register', 'label' => 'Inscription');
            $navConnectLink = array('href' => 'index.php?login', 'label' => 'Connexion');

            if($isConnected) {
                $navAdminLink = array('href' => 'index.php?admin', 'label' => 'Admin');
                $navConnectLink = array('href' => 'index.php?logout', 'label' => 'Déconnexion');
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