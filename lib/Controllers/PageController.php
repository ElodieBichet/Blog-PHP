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
    public function show(): void
    {

        $page = $this->model;
        $page->template = 'index';
        $page->type = 'front';
        $page->title = 'Page d\'accueil';
        $getArray = $page->collectInput('GET');

        // Destroy current session in case of deconnection
        if (isset($getArray['logout'])) 
        {
            $page->logout();
        }
        
        if (!empty($getArray['page']))
        {
            $pageName = strtolower(filter_var($getArray['page'], FILTER_SANITIZE_STRING));
            $this->showPage($page, $pageName);
        }
        
        if (isset($getArray['admin']))
        {
            $page->type = 'admin';
            $page->title = 'Tableau de bord';
        }

        // Force login page if an admin page is requested
        if ($page->type=='admin')
        {
            $this->checkAccess();
        }

        $this->display($page->type, $page->template, $page->title);
    }
   
    /**
     * showPage
     * Display the requested page
     *
     * @param  string $page The current page object
     * @param  string $pageName The name of the requested page
     * @return void
     */
    public function showPage(object $page, string $pageName): void
    {
        switch ($pageName)
        {
            case '404-error' :
                $pageTitle = 'Erreur 404';
                break;
            case 'access-denied' :
                $pageTitle = 'Accès refusé';
                break;
            case 'login' :
                $pageTitle = 'Connexion à l\'admin';
                break;
            case 'register' :
                $pageTitle = 'Inscription';
                break;
            case 'contactme' :
                $pageTitle = 'Contactez-moi';
                break;
            default :
                $pageName = '404-error';
                $pageTitle = 'Erreur 404';
        }
        $page->type = 'front';
        $page->template = $pageName;
        $page->title = $pageTitle;
    }
    
    function dataTransform(object $item, array $formdata): void
    {
        // do nothing for the moment as pages are not managed like other items
    }

}