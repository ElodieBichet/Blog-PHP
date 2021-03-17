<?php

namespace App\Controllers;

use Throwable;

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
    public function showPage(object $page, string $pageName) : void
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
            case 'contact' :
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

    public function send()
    {
        try
        {
            if (!mail('e_bichet@yahoo.fr', 'sujet', 'message'))
            {
                throw new Throwable();
            }
        }
        catch (Throwable $e)
        {
            $message = 'Une erreur est survenue, le message n\'a pas pu être envoyé.';
            $style = 'danger';
            $this->display('front','contact','Contactez-moi',compact('message','style'));
            // Uncomment in dev context :
            // echo 'Erreur : '. $e->getMessage() .'<br>Fichier : '. $e->getFile() .'<br>Ligne : '. $e->getLine();
        }
    }
    
    function dataTransform(object $item, array $formdata) : void
    {
        // do nothing for the moment as pages are not managed like other items
    }

}