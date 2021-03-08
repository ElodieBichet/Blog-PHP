<?php

namespace App\Controllers;

use App\Models\Comment;
use Cocur\Slugify\Slugify;

class PostController extends Controller
{
    
    protected $modelName = \App\Models\Post::class;
    
    /**
     * Display post lists
     * 
     */
    public function showList() : void
    {
        
        $admin = filter_input(INPUT_GET, 'admin');
        $type = (isset($admin)) ? 'admin' : 'front';
        
        $path = 'posts-list';
        
        switch($type)
        {
            case 'front':
                $pageTitle = 'News';
                $condition = 'status = '.self::STATUS_APPROVED.' AND publication_date <= NOW()'; // only approved and published posts
                $order = 'publication_date DESC';
                break;
            case 'admin':
                $this->checkAccess(); // redirect to login page if not connected
                $pageTitle = 'Gérer les posts';
                $condition = '1 = 1';
                $order = 'last_update_date DESC';
                break;
        }

        $posts = $this->model->findAll($condition, $order);

        $this->display($type, $path, compact('pageTitle','posts'));
    }

    /**
     * Display one post page
     * 
     */
    public function show() : void
    {
        $post = $this->model;
        $comment = new Comment();
        $getArray = $post->collectInput('GET'); // collect global $_GET data
        $pageTitle = '';
        $alert = '';

        if(empty($getArray['id'])) // if no ID
        {
            $post->redirect('index.php?controller=page&task=show404');
        }

        if(!empty($getArray['id']))
        {
            $getId = (int) $getArray['id'];
            $DBpost = $post->find($getId); // search the post with this id in database and get it if it exists

            if (!$DBpost)
            {
                $post->redirect('index.php?controller=page&task=show404');
            }

            if (!empty($DBpost)) // if post exists in database
            {
                foreach ($DBpost as $k => $v) $post->$k = $v;

                if ( ($post->status != self::STATUS_APPROVED) OR (strtotime($post->publication_date) > time()) )
                {
                    $post->redirect('index.php?controller=page&task=show404');
                }

                if (isset($getArray['comment']))
                {
                    $message = 'Votre commentaire a été envoyé. Il sera publié après modération par un administrateur.';
                    $style = 'success';
                    
                    if ($getArray['comment'] != 'submitted')
                    {
                        $message = 'Une erreur est survenue, le commentaire n\'a pas pu être envoyé.';
                        $style = 'danger';
                    }

                    $alert = sprintf('<div class="alert alert-%2$s">%1$s</div>', $message, $style);
            
                }

                $condition = 'post_id = '.$post->id.' AND status = '.self::STATUS_SUBMITTED; // pass status to STATUS_APPROVED when validation feature ready
                $comments = $comment->findAll($condition, 'creation_date DESC');
                $post->nb_comments = count($comments);

                $pageTitle = $post->title;
            }
        }

        $this->display('front', 'post', compact('pageTitle','post','comments','alert'));
    }

    /**
     * Display post creation form
     * 
     */
    public function add() : void
    {

        $this->checkAccess(); // redirect to login page if not connected

        $pageTitle = 'Ajouter un post';
        $alert = '';
        $template = 'newPost';
        $post = $this->model;

        $postArray = $post->collectInput('POST'); // collect global $_POST data
        
        if (!empty($postArray)) {
            
            if (isset($postArray['save']))
            {
                $message = 'Le post a bien été enregistré en base';
                $post->status = self::STATUS_APPROVED;
            }
            if (isset($postArray['saveAsDraft']))
            {
                $message = 'Le brouillon a bien été enregistré en base';
                $post->status = self::STATUS_DRAFT;
            }

            $post->author = 1; // default author
            $this->dataTransform($post, $postArray);
            
            $post->id = $post->insert();

            if($post->id == 0) {
                $message = 'Une erreur est survenue, le post n\'a pas pu être inséré dans la base de données.';
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
        
        $this->display('admin', $template, compact('pageTitle','alert','post'));

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
        $this->checkAccess(); // redirect to login page if not connected
        $getArray = $post->collectInput('GET'); // collect global $_GET data
        $postArray = $post->collectInput('POST'); // collect global $_POST data

        if(empty($getArray['id'])) // if no ID
        {
            $template = 'index';
            $style = 'warning';
            $message = 'Vous devez spécifier l\'identifiant du post que vous souhaitez modifier.';
        }

        if(!empty($getArray['id']))
        {
            $getId = (int) $getArray['id'];
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

                if (!empty($postArray))
                {
                    $pageTitle = (isset($postArray['delete'])) ? 'Suppression du post #'.$post->id : $pageTitle;
                    list($template, $message, $style) = $this->doActionForm($postArray, $post);
                }
            }

        }

        if(!empty($message)) {
            $alert = sprintf('<div class="alert alert-%2$s">%1$s</div>', $message, $style);
        }

        $this->display('admin', $template, compact('pageTitle','alert','post'));

    }

    /**
     * Check all the $_POST data before adding or updating a post
     * 
     */
    public function dataTransform(object $post, array $formdata) : void {
        $post->title = $formdata['title'];
        $post->intro = $formdata['intro'];
        $post->content = $formdata['content'];
        // slugify the title
        $slugify = new Slugify();
        $post->slug = $slugify->slugify($post->title);
        // publication date format
        $date = (!empty($formdata['date'])) ? $formdata['date'] : date('Y-m-d');
        $time = (!empty($formdata['time'])) ? $formdata['time'] : date('H:i:s');
        $post->publication_date = $date.' '.$time;
    }

    public function doActionForm(array $postArray, object $post) : array
    {

        $template = 'editPost';
        $style = '';
        $message = '';

        if ( isset($postArray['update']) OR isset($postArray['updateAsDraft']) ) // if submit with update button
        {

            if (isset($postArray['update']))
            {
                $message = 'Le post a bien été mis à jour.';
                $post->status = self::STATUS_APPROVED;
            }
            if (isset($postArray['updateAsDraft']))
            {
                $message = 'Le brouillon a bien mis à jour.';
                $post->status = self::STATUS_DRAFT;
            }
            
            $this->dataTransform($post, $postArray);
            
            if ($post->update()) $style = 'success';
        }
        
        if (isset($postArray['delete'])) // if submit with delete button
        {
            $pageTitle = 'Suppression du post #'.$post->id;
            
            $deleteSuccess = $post->delete();

            $template = 'index';
            $style = 'success';
            $message = 'Le post #' . $post->id . ' a bien été supprimé.';

            if (!$deleteSuccess) { // if delete() has failed
                $template = 'editPost';
                $style = 'danger';
                $message = 'Le post #' . $post->id . ' n\'a pas pu être supprimé.';
            }
        }

        return array($template, $message, $style);

    }

}