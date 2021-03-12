<?php

namespace App\Controllers;

use App\Models\Comment;
use Cocur\Slugify\Slugify;

/**
 * PostController
 * Manage posts
 */
class PostController extends Controller
{
    
    protected $modelName = \App\Models\Post::class;
    protected $modelTrad = array(
        'item' => 'post',
        'article_a' => 'un ',
        'article_the' => 'le ',
        'of' => 'du '
    );
       
    /**
     * showList
     * Display post lists by context
     *
     * @return void
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
                // If user is not admin, he can only see his own posts
                if(!($this->isAdmin())) $condition = 'author = '.$_SESSION['user_id'];
                $order = 'last_update_date DESC';
                break;
        }

        $posts = $this->model->findAll($condition, $order);

        $this->display($type, $path, compact('pageTitle','posts'));
    }
  
    /**
     * show
     * Display one post page
     *
     * @return void
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

                $condition = 'post_id = '.$post->id.' AND status = '.self::STATUS_APPROVED; // All approved comments for the current post
                $comments = $comment->findAll($condition, 'creation_date DESC');
                $post->nb_comments = count($comments);

                $pageTitle = $post->title;
            }
        }

        $this->display('front', 'post', compact('pageTitle','post','comments','alert'));
    }
   
    /**
     * add
     * Display post creation form and analyse form submission
     *
     * @return void
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

            $post->author = filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT); // author = connected user
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
     * dataTransform
     * Check all the $_POST data before adding or updating a post
     *
     * @param  mixed $post
     * @param  mixed $formdata
     * @return void
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
    
    /**
     * doActionForm
     * Check what action is requested when the form is submitted and do these actions
     *
     * @param  array $postArray Array which contains $_POST entries
     * @param  object $post Concerned Post instance
     * @return array with 3 variables values
     */
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