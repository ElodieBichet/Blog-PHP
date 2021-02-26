<?php

namespace App\Controllers;

use Cocur\Slugify\Slugify;
use App\Renderer;


class PostController extends Controller
{
    
    protected $modelName = \App\Models\Post::class;
    
    public function add() : void
    {

        $pageTitle = 'Ajouter un post';
        $message = '';
        $template = 'newPost';
        $post = $this->model;
        
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
            $post->title = htmlspecialchars($_POST['title']);
            // slugify the title
            $slugify = new Slugify();
            $post->slug = $slugify->slugify($post->title);
            $post->intro = htmlspecialchars($_POST['intro']);
            $post->content = htmlspecialchars($_POST['content']);
            if (!empty($_POST['date'])) {
                $post->publication_date = date('Y-m-d h:i:s', strtotime($_POST['date']));
            } else {
                $post->publication_date = date('Y-m-d h:i:s');
            }
            
            $post->id = $post->insert();

            if($post->id == 0) {
                $message = 'Une erreur est survenu, le post n\'a pas pu être inséré dans la base de données.';
            } else {
                $message .= ' sous l\'identifiant #'.$post->id.'.';
                $style = 'success';
                $pageTitle = 'Modifier le post #'.$post->id;
                $template = 'editPost';
            }

        }

        if($message !== '') {
            $alert = sprintf('<div class="alert alert-%2$s">%1$s</div>', $message, $style);
        } else {
            $alert = '';
        }
        
        Renderer::render('admin', $template, compact('pageTitle','alert','post'));

    }

    public function edit() : void
    {
        $pageTitle = 'Modifier un post';
        $template = 'editPost';
        $message = '';
        $post = $this->model;

        if(!isset($_GET['id']) OR empty($_GET['id'])) // if no ID
        {
            $template = 'index';
            $style = 'warning';
            $message = 'Vous devez spécifier l\'identifiant du post que vous souhaitez modifier.';
        }
        else
        {
            $DBpost = $post->find($_GET['id']); // search the post with this id in database and get it if it exists
            if (!$DBpost)
            { // if not found
                $pageTitle = 'Ajouter un post';
                $template = 'newPost';
                $style = 'warning';
                $message = 'Le post que vous souhaitez modifier n\'existe pas ou l\'identifiant est incorrect. Créez un nouveau post en complétant le formulaire ci-dessous.';
            }
            else
            {
                foreach ($DBpost as $k => $v) $post->$k = $v;

                $pageTitle = 'Modifier le post #'.$post->id;

                if (!empty($_POST))
                {
                    
                    if (isset($_POST['delete'])) // click on delete button
                    {
                        $pageTitle = 'Suppression du post #'.$post->id;
                        
                        $post->delete();

                        if (!$post->find($post->id)) {
                            $template = 'index';
                            $style = 'success';
                            $message = 'Le post #' . $post->id . ' a bien été supprimé.';
                        } else {
                            $template = 'editPost';
                            $style = 'warning';
                            $message = 'Le post #' . $post->id . ' n\'a pas pu être supprimé.';
                        }

                    }
                    elseif ( isset($_POST['update']) OR isset($_POST['udateAsDraft']) ) // it's just an update
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
                        
                        $post->title = htmlspecialchars($_POST['title']);
                        // slugify the title
                        $slugify = new Slugify();
                        $post->slug = $slugify->slugify($post->title);
                        $post->intro = htmlspecialchars($_POST['intro']);
                        $post->content = htmlspecialchars($_POST['content']);
                        if (!empty($_POST['date'])) {
                            $post->publication_date = date('Y-m-d h:i:s', strtotime($_POST['date']));
                        } else {
                            $post->publication_date = date('Y-m-d h:i:s');
                        }
                        
                        if ($post->update()) $style = 'success';
                    }                 
        
                }
            }
        }
        
        if($message !== '') {
            $alert = sprintf('<div class="alert alert-%2$s">%1$s</div>', $message, $style);
        } else {
            $alert = '';
        }

        Renderer::render('admin', $template, compact('pageTitle','alert','post'));

    }

}