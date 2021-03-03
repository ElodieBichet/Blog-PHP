<?php

namespace App\Controllers;

use Cocur\Slugify\Slugify;
use App\Renderer;

use function PHPSTORM_META\type;

class PostController extends Controller
{
    
    protected $modelName = \App\Models\Post::class;
    
    /**
     * Display post lists
     * 
     */
    public function showList() : void
    {
        $type = (isset($_GET['admin'])) ? 'admin' : 'front';
        $path = 'posts-list';

        switch($type)
        {
            case 'front':
                $pageTitle = 'News';
                $condition = 'status = 2 AND publication_date <= NOW()'; // only approved and published posts
                $order = 'publication_date DESC';
                break;
            case 'admin':
                $pageTitle = 'Gérer les posts';
                $condition = '1 = 1';
                $order = 'last_update_date DESC';
                break;
        }

        $posts = $this->model->findAll($condition, $order);

        Renderer::render($type, $path, compact('pageTitle','posts'));
    }


    /**
     * Display post creation form
     * 
     */
    public function add() : void
    {

        $pageTitle = 'Ajouter un post';
        $alert = '';
        $template = 'newPost';
        $post = $this->model;
        $post->publication_date = date('Y-m-d H:i:s');
        
        if (!empty($_POST)) {
            
            if (isset($_POST['save']))
            {
                $message = 'Le post a bien été enregistré en base';
                $post->status = self::STATUS_APPROVED;
            }
            if (isset($_POST['saveAsDraft']))
            {
                $message = 'Le brouillon a bien été enregistré en base';
                $post->status = self::STATUS_DRAFT;
            }

            $post->author = 1; // default author
            $this->dataTransform($post, $_POST);
            
            $post->id = $post->insert();

            if($post->id == 0) {
                $message = 'Une erreur est survenu, le post n\'a pas pu être inséré dans la base de données.';
            } 
            if($post->id !== 0) {
                $message .= ' sous l\'identifiant #'.$post->id.'.';
                $style = 'success';
                $pageTitle = 'Modifier le post #'.$post->id;
                $template = 'editPost';
            }

        }

        if(!empty($message)) {
            $alert = sprintf('<div class="alert alert-%2$s">%1$s</div>', $message, $style);
        }
        
        Renderer::render('admin', $template, compact('pageTitle','alert','post'));

    }

    /**
     * Display post edition form
     * 
     */
    public function edit() : void
    {
        $pageTitle = 'Modifier un post';
        $template = 'editPost';
        $alert = '';
        $post = $this->model;

        if(empty($_GET['id'])) // if no ID
        {
            $template = 'index';
            $style = 'warning';
            $message = 'Vous devez spécifier l\'identifiant du post que vous souhaitez modifier.';
        }

        if(!empty($_GET['id']))
        {
            $getId = (int) $_GET['id'];
            $DBpost = $post->find($getId); // search the post with this id in database and get it if it exists

            if (!$DBpost) // if post not found in database
            {
                $pageTitle = 'Ajouter un post';
                $template = 'newPost';
                $style = 'warning';
                $message = 'Le post que vous souhaitez modifier n\'existe pas ou l\'identifiant est incorrect. Créez un nouveau post en complétant le formulaire ci-dessous.';
            }

            if (!empty($DBpost)) // if post exists in database
            {
                foreach ($DBpost as $k => $v) $post->$k = $v;

                $pageTitle = 'Modifier le post #'.$post->id;

                if (!empty($_POST)) // if the form is submitted
                {

                    if ( isset($_POST['update']) OR isset($_POST['updateAsDraft']) ) // if submit with update button
                    {

                        if (isset($_POST['update']))
                        {
                            $message = 'Le post a bien été mis à jour.';
                            $post->status = self::STATUS_APPROVED;
                        }
                        if (isset($_POST['updateAsDraft']))
                        {
                            $message = 'Le brouillon a bien mis à jour.';
                            $post->status = self::STATUS_DRAFT;
                        }
                        
                        $this->dataTransform($post, $_POST);
                        
                        if ($post->update()) $style = 'success';
                    }
                    
                    if (isset($_POST['delete'])) // if submit with delete button
                    {
                        $pageTitle = 'Suppression du post #'.$post->id;
                        
                        $post->delete();

                        $template = 'index';
                        $style = 'success';
                        $message = 'Le post #' . $post->id . ' a bien été supprimé.';

                        if (!empty($post->find($post->id))) { // if post still exists => delete() has failed
                            $template = 'editPost';
                            $style = 'warning';
                            $message = 'Le post #' . $post->id . ' n\'a pas pu être supprimé.';
                        }
                    }
        
                }
            }
        }
        
        if(!empty($message)) {
            $alert = sprintf('<div class="alert alert-%2$s">%1$s</div>', $message, $style);
        }

        Renderer::render('admin', $template, compact('pageTitle','alert','post'));

    }

    /**
     * Check all the $_POST data from an add or update form
     * 
     */
    public function dataTransform(object $post, array $formdata) : void {
        $post->title = self::filter_string($formdata['title']);
        // slugify the title
        $slugify = new Slugify();
        $post->slug = $slugify->slugify($post->title);
        $post->intro = self::filter_string($formdata['intro']);
        $post->content = self::filter_string($formdata['content']);
        $date = (!empty($formdata['date'])) ? self::filter_string($formdata['date']) : date('Y-m-d');
        $time = (!empty($formdata['time'])) ? self::filter_string($formdata['time']) : date('H:i:s');
        $post->publication_date = $date.' '.$time;
    }

}