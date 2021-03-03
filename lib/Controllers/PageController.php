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
        $getArray = filter_input_array(INPUT_GET);

        // Destroy current session in case of deconnection
        if (isset($getArray['logout'])) 
        {
            Session::logout();
        }
        
        if (!empty($getArray['page']))
        {
            $page = $getArray['page'];
        }
        
        // Connection test currently in the render function (temporary)
        if (isset($getArray['admin']))
        {
            $type = 'admin';
            $pageTitle = 'Tableau de bord';
        }

        Renderer::render($type, $page, compact('pageTitle'));
    }

    public function show404()
    {
        $pageTitle = 'Erreur 404';
        Renderer::render('front', '404-error', compact('pageTitle'));   
    }

}