<?php

namespace App\Controllers;

use Throwable;

/**
 * CommentController
 * Manage comments
 */
class CommentController extends Controller
{
    protected $modelName = \App\Models\Comment::class;
    protected $modelTrad = array(
        'item' => 'commentaire',
        'article_a' => 'un ',
        'article_the' => 'le ',
        'of' => 'du '
    );
 
    /**
     * showList
     * Display comments list in admin
     *
     * @return void
     */
    public function showList() : void
    {
        $this->checkAccess();
        $pageTitle = 'Gérer les commentaires';
        $condition = '1 = 1';
        $order = 'creation_date DESC';
        $post_id = filter_input(INPUT_GET, 'postid');
        $style = 'warning';
        $message = '';
        $user_posts = $_SESSION['user_posts'];
        
        if(!$this->isAdmin())
        {
            $postslist = (!empty($user_posts)) ? (implode(', ', $user_posts)) : '0'; 
            $condition = 'post_id IN ('.$postslist.')'; // if the user is not admin, he can see comments for his own posts only
        }

        if (!empty($post_id))
        {
            if(!in_array($post_id, $user_posts)) $this->checkAccess(true); // if the user is not author of the requested post, he has to be admin
            $post_id = (int) $post_id;
            $pageTitle = 'Gérer les commentaires du post #'.$post_id;
            $condition = 'post_id = '.$post_id;
        }

        $comments = $this->model->findAll($condition, $order);
        
        if(empty($comments))
        {
            $style = 'warning';
            $message = 'Aucun commentaire trouvé avec ces critères';
        }

        $this->display('admin', 'comments-list', $pageTitle, compact('comments','message','style'));
    }

    /**
     * submit
     * Submit a comment
     * 
     * @return void
     */
    public function submit() : void
    {

        $comment = $this->model;

        $postArray = $comment->collectInput('POST'); // collect global $_POST data
        
        if (!empty($postArray))
        {
            
            if (isset($postArray['submit']))
            {
                $comment->status = self::STATUS_SUBMITTED;
            }
            
            $this->dataTransform($comment, $postArray);
            
            $comment->id = $comment->insert();
            
            if($comment->id == 0) {
                $result = 'error';
            } 
            if($comment->id !== 0)
            {
                $result = 'submitted';

                // Try to notify the author of the post of the new comment submission
                try
                {
                    $serverArray = $this->collectInput('SERVER');
                    $baseUrl = 'http://'.$serverArray['HTTP_HOST'].$serverArray['PHP_SELF'];
                    $body = "Un nouveau commentaire vient d'être soumis sur le post #{$comment->post_id} :\n"
                        ."- modifier ce commentaire -> {$baseUrl}?controller=comment&task=edit&id={$comment->id} \n"
                        ."- gérer tous les commentaires de ce post -> {$baseUrl}?controller=comment&task=showList&postid={$comment->post_id}";
                    $recipient = array();
                    $author = $comment->getPostAuthor();

                    if ($author)
                    {
                        $user_name = $author->public_name;
                        $user_email = $author->email_address;
                        $recipient = array($user_email => $user_name);
                    }
                    if (!$this->sendEmail('My Blog','noreply@myblog.fr','Nouveau commentaire déposé',$body,$recipient))
                    {
                        throw new Throwable();
                    }
                }
                catch (Throwable $e)
                {
                    // Uncomment in dev context :
                    // echo 'Erreur : '. $e->getMessage() .'<br>Fichier : '. $e->getFile() .'<br>Ligne : '. $e->getLine();
                }
            }

        }

        $this->redirect('index.php?controller=post&task=show&id='.$comment->post_id.'&comment='.$result);

    }

    /**
     * dataTransform
     * Check all the $_POST data before adding or updating a comment
     *
     * @param  object $comment The Comment instance with properties to update
     * @param  array $formdata The array with values to assign
     * @return void
     */
    public function dataTransform(object $comment, array $formdata) : void
    {
        $comment->post_id = $formdata['post_id'];
        $comment->author = $formdata['author'];
        $comment->email_address = filter_var($formdata['email_address'], FILTER_SANITIZE_EMAIL);
        $comment->content = $formdata['content'];
    }

}