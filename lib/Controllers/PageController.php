<?php

namespace App\Controllers;

use App\Renderer;
use App\Session;

class PageController extends Controller
{

    protected $modelName = \App\Models\Page::class;

    public function show()
    {

        $type = 'front';
        $page = 'index';
        $pageTitle = 'Page d\'accueil';

        // Destroy current session in case of deconnection
        if (isset($_GET['logout'])) 
        {
            Session::logout();
        }
        
        // Force connection if an admin page is requested
        if (isset($_GET['admin']))
        {
            if (!isset($_SESSION['connection']) OR $_SESSION['connection'] == false)
            {
                $page = 'login';
                $pageTitle = 'Connexion à l\'admin';
            } 
            else
            {
                $type = 'admin';
                $pageTitle = 'Tableau de bord';
            }
        }

        if (!empty($_GET['page']))
        {
            $page = $_GET['page'];
        }

        Renderer::render($type, $page, compact('pageTitle'));
    }

}