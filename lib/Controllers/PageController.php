<?php

namespace App\Controllers;

/**
 * PageController
 * Manage pages
 */
class PageController extends Controller
{

    protected $modelName = \App\Models\Page::class;
    protected $modelTrad = array(
        'item' => 'page',
        'article_a' => 'une ',
        'article_the' => 'la ',
        'of' => 'de la '
    );
    
    /**
     * show
     * Display the requested page
     *
     * @return void
     */
    public function show() : void
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

        if (isset($getArray['register']))
        {
            $template = 'register';
            $pageTitle = 'Inscription';
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

        $this->display($page->type, $template, $pageTitle);
    }
    
    /**
     * show404
     * Display an error page
     *
     * @return void
     */
    public function show404() : void
    {
        $this->display('front', '404-error', 'Erreur 404');   
    }

    /**
     * showAccessDenied
     * Display an error page if user has not the right access
     *
     * @return void
     */
    public function showAccessDenied() : void
    {
        $this->display('front', 'access-denied', 'Accès refusé');   
    }
    
    function dataTransform(object $item, array $formdata) : void
    {
        // do nothing for the moment as pages are not managed like other items
    }

}