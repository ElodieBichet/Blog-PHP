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
        
        if (!empty($_GET['page']))
        {
            $page = $_GET['page'];
        }
        
        // Connection test currently in the render function (temporary)
        if (isset($_GET['admin']))
        {
            $type = 'admin';
            $pageTitle = 'Tableau de bord';
        }
        
        Renderer::render($type, $page, compact('pageTitle'));
    }

}