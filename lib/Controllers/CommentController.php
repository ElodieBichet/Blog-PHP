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
     * Display post edition form
     * 
     */
    public function edit() : void
    {
        $pageTitle = 'Modifier un comment';
        $template = 'editComment';
        $alert = '';
        $comment = $this->model;
        $this->checkAccess(); // redirect to login page if not connected
        $getArray = $comment->collectInput('GET'); // collect global $_GET data
        $postArray = $comment->collectInput('POST'); // collect global $_POST data

        if(empty($getArray['id'])) // if no ID
        {
            $template = 'index';
            $style = 'warning';
            $message = 'Vous devez spécifier l\'identifiant du commentaire que vous souhaitez modifier.';
        }

        if(!empty($getArray['id']))
        {
            $getId = (int) $getArray['id'];
            $DBcomment = $comment->find($getId); // search the comment with this id in database and get it if it exists

            if (!$DBcomment) // if comment not found in database
            {
                $pageTitle = 'Gérer les commentaires';
                $template = 'comments-list';
                $style = 'warning';
                $message = 'Le commentaire que vous souhaitez modifier n\'existe pas ou l\'identifiant est incorrect.';
            }

            if (!empty($DBcomment)) // if post exists in database
            {
                foreach ($DBcomment as $k => $v) $comment->$k = $v;

                $pageTitle = 'Modifier le commentaire #'.$comment->id;

                if (!empty($postArray))
                {
                    $pageTitle = (isset($postArray['delete'])) ? 'Suppression du commentaire #'.$comment->id : $pageTitle;
                    list($template, $message, $style) = $this->doActionForm($postArray, $comment);
                }
            }

        }

        if(!empty($message)) {
            $alert = sprintf('<div class="alert alert-%2$s">%1$s</div>', $message, $style);
        }

        $this->display('admin', $template, compact('pageTitle','alert','comment'));

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