<?php

namespace App\Controllers;

class CommentController extends Controller
{

    protected $modelName = \App\Models\Comment::class;

    /**
     * Display comments list in admin
     * 
     */
    public function showList() : void
    {
        $this->checkAccess(); // redirect to login page if not connected
        
        $pageTitle = 'Gérer les commentaires';
        $condition = '1 = 1';
        $order = 'creation_date DESC';
        $post_id = filter_input(INPUT_GET, 'postid');
        $alert = '';

        if (!empty($post_id))
        {
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
     * Submit a comment
     * 
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
     * Check all the $_POST data before adding or updating a comment
     * 
     */
    public function dataTransform(object $comment, array $formdata) : void {
        $comment->post_id = $formdata['post_id'];
        $comment->author = $formdata['author'];
        $comment->email_address = $formdata['email_address'];
        $comment->content = $formdata['content'];
    }

}