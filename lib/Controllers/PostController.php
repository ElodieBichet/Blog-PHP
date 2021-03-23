<?php

namespace App\Controllers;

use App\Models\Comment;
use Cocur\Slugify\Slugify;
use Throwable;

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

        $this->display($type, $path, $pageTitle, compact('posts'));
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
        $style = 'success';
        $message = '';

        if(empty($getArray['id'])) // if no ID
        {
            $post->redirect('index.php?page=404-error');
        }

        if(!empty($getArray['id']))
        {
            $getId = (int) $getArray['id'];
            $DBpost = $post->find($getId); // search the post with this id in database and get it if it exists

            if (!$DBpost)
            {
                $post->redirect('index.php?page=404-error');
            }

            if (!empty($DBpost)) // if post exists in database
            {
                foreach ($DBpost as $k => $v) $post->$k = $v;

                if ( ($post->status != self::STATUS_APPROVED) OR (strtotime($post->publication_date) > time()) )
                {
                    $post->redirect('index.php?page=404-error');
                }

                if (isset($getArray['comment']))
                {
                    $message = 'Votre commentaire a été envoyé. Il sera publié après modération par un administrateur.';
                    
                    if ($getArray['comment'] != 'submitted')
                    {
                        $message = 'Une erreur est survenue, le commentaire n\'a pas pu être envoyé.';
                        $style = 'danger';
                    }
            
                }

                $condition = 'post_id = '.$post->id.' AND status = '.self::STATUS_APPROVED; // All approved comments for the current post
                $comments = $comment->findAll($condition, 'creation_date DESC');
                $post->nb_comments = count($comments);

                $pageTitle = $post->title;
            }
        }

        $this->display('front', 'post', $pageTitle, compact('post','comments','message','style'));
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
        $message = '';
        $style = 'success';
        $template = 'new-post';
        $post = $this->model;

        $postArray = $post->collectInput('POST'); // collect global $_POST data
        
        if (!empty($postArray))
        {
            if (isset($postArray['save']))
            {
                $message = 'Le post a bien été enregistré en base';
                $post->status = self::STATUS_SUBMITTED;
            }
            if (isset($postArray['saveAsDraft']))
            {
                $message = 'Le brouillon a bien été enregistré en base';
                $post->status = self::STATUS_DRAFT;
            }

            $post->author = filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT); // author = connected user
            $this->dataTransform($post, $postArray);
            
            $post->id = $post->insert();

            if($post->id == 0)
            {
                $message = 'Une erreur est survenue, le post n\'a pas pu être inséré dans la base de données.';
                $style = 'danger';
            } 
            if($post->id !== 0)
            {
                array_push($_SESSION['user_posts'], $post->id);
                $message .= ' sous l\'identifiant #'.$post->id.'.';
                $pageTitle = 'Modifier le post #'.$post->id;
                $template = 'edit-post';

                if(!$this->isAdmin())
                {
                    // Try to notify the site owner of the new post submission
                    try
                    {
                        $serverArray = $this->collectInput('SERVER');
                        $baseUrl = 'http://'.$serverArray['HTTP_HOST'].$serverArray['PHP_SELF'];
                        $body = "Un nouveau post vient d'être soumis par {$post->getAuthor()} : {$baseUrl}?controller=post&task=edit&id={$post->id}";
                        if (!$this->sendEmail('My Blog','noreply@myblog.fr','Nouveau post soumis',$body))
                        {
                            throw new Throwable();
                        }
                    }
                    catch (Throwable $e)
                    {
                        // Uncomment in dev context :
                        echo 'Erreur : '. $e->getMessage() .'<br>Fichier : '. $e->getFile() .'<br>Ligne : '. $e->getLine();
                    }
                }
            }

        }
        
        $this->display('admin', $template, $pageTitle, compact('message','style','post'));

    }
  
    /**
     * dataTransform
     * Check all the $_POST data before adding or updating a post
     *
     * @param  object $post
     * @param  array $formdata
     * @return void
     */
    public function dataTransform(object $post, array $formdata) : void
    {
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

}