<?php

namespace App\Controllers;

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
        $alert = '';
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
            $alert = sprintf('<div class="alert alert-%2$s">%1$s</div>', $message, $style);
        }

        $this->display('admin', 'comments-list', compact('pageTitle','comments','alert'));
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
        
        if (!empty($postArray)) {
            
            if (isset($postArray['submit']))
            {
                $comment->status = self::STATUS_SUBMITTED;
            }
            
            $this->dataTransform($comment, $postArray);
            
            $comment->id = $comment->insert();
            
            if($comment->id == 0) {
                $result = 'error';
            } 
            if($comment->id !== 0) {
                $result = 'submitted';
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
    public function dataTransform(object $comment, array $formdata) : void {
        $comment->post_id = $formdata['post_id'];
        $comment->author = $formdata['author'];
        $comment->email_address = filter_var($formdata['email_address'], FILTER_SANITIZE_EMAIL);
        $comment->content = $formdata['content'];
    }

}