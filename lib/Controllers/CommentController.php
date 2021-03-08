<?php

namespace App\Controllers;

class CommentController extends Controller
{

    protected $modelName = \App\Models\Comment::class;

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