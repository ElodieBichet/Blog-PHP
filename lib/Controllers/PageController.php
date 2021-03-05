<?php

namespace App\Controllers;

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
            $page->logout();
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
        
        if (isset($getArray['admin']))
        {
            $page->type = 'admin';
            $pageTitle = 'Tableau de bord';
        }

        // Force login page if an admin page is requested
        if ($page->type=='admin')
        {
            $this->checkAccess();
        }

        $this->display($page->type, $template, compact('pageTitle'));
    }

    public function show404()
    {
        $pageTitle = 'Erreur 404';
        $this->display('front', '404-error', compact('pageTitle'));   
    }

}