<?php

namespace App\Controllers;

use App\Renderer;
use App\Session;

class PageController extends Controller
{

    protected $modelName = \App\Models\Page::class;

    public function show()
    {

        $page = $this->model;
        $template = 'index';
        $page->type = 'front';
        $pageTitle = 'Page d\'accueil';
        $getArray = $page->collectInput('GET');

        // Destroy current session in case of deconnection
        if (isset($getArray['logout'])) 
        {
            Session::logout();
        }

        if (isset($getArray['login']))
        {
            $template = 'login';
            $pageTitle = 'Connexion à l\'admin';
        }
        
        if (!empty($getArray['page']))
        {
            $template = $getArray['page'];
        }
        
        // Connection test currently in the render function (temporary)
        if (isset($getArray['admin']))
        {
            $page->type = 'admin';
            $pageTitle = 'Tableau de bord';
        }

        // Force login page if an admin page is requested
        if ($page->type=='admin')
        {
            $page->checkAccess();
        }

        Renderer::render($page->type, $template, compact('pageTitle'));
    }

    public function show404()
    {
        $pageTitle = 'Erreur 404';
        Renderer::render('front', '404-error', compact('pageTitle'));   
    }

}