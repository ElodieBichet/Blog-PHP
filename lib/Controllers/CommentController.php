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
    
    /**
     * doActionForm
     * Check what action is requested when the form is submitted and do these actions
     *
     * @param  array $postArray Array which contains $_POST entries
     * @param  object $comment Concerned Comment instance
     * @return array with 3 variables values
     */
    public function doActionForm(array $postArray, object $comment) : array
    {

        $template = 'editComment';
        $style = '';
        $message = '';
        
        if ( isset($postArray['update']) ) // if submit with update button
        {
            $message = 'Le commentaire a bien été mis à jour.';
            
            $this->dataTransform($comment, $postArray);
            
            if ($comment->update()) $style = 'success';
        }
        
        if (isset($postArray['delete'])) // if submit with delete button
        {   
            $deleteSuccess = $comment->delete();

            $template = 'index';
            $style = 'success';
            $message = 'Le commentaire #' . $comment->id . ' a bien été supprimé.';

            if (!$deleteSuccess) { // if delete() has failed
                $template = 'editComment';
                $style = 'danger';
                $message = 'Le commentaire #' . $comment->id . ' n\'a pas pu être supprimé.';
            }
        }

        if (isset($postArray['valid']))
        {
            $updateSuccess = $comment->setStatus(self::STATUS_APPROVED, true);

            $style = 'success';
            $message = 'Le commentaire #' . $comment->id . ' a bien été approuvé.';
            $comment->status = self::STATUS_APPROVED;

            if (!$updateSuccess) { // if setStatus() has failed
                $style = 'danger';
                $message = 'Le commentaire #' . $comment->id . ' n\'a pas pu être approuvé.';
            }
        }

        if (isset($postArray['reject']))
        {
            $updateSuccess = $comment->setStatus(self::STATUS_REJECTED);

            $style = 'success';
            $message = 'Le commentaire #' . $comment->id . ' a bien été rejeté.';
            $comment->status = self::STATUS_REJECTED;

            if (!$updateSuccess) { // if setStatus() has failed
                $style = 'danger';
                $message = 'Le commentaire #' . $comment->id . ' n\'a pas pu être rejeté.';
            }
        }

        return array($template, $message, $style);

    }

}