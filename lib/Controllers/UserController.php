<?php

namespace App\Controllers;

/**
 * UserController
 * Manage users
 */
class UserController extends Controller
{
    const ROLE_DEFAULT = 0;
    const ROLE_ADMIN = 1;
    const ROLE_AUTHOR = 2;

    protected $modelName = \App\Models\User::class;
    protected $modelTrad = array(
        'item' => 'utilisateur',
        'article_a' => 'un ',
        'article_the' => 'l\'',
        'of' => 'de l\''
    );

        /**
     * showList
     * Display users list in admin
     *
     * @return void
     */
    public function showList() : void
    {
        $this->checkAccess(); // redirect to login page if not connected
        
        $pageTitle = 'Gérer les utilisateurs';
        $condition = '1 = 1';
        $order = 'creation_date DESC';
        $alert = '';

        $users = $this->model->findAll($condition, $order);
        
        if(empty($users))
        {
            $style = 'warning';
            $message = 'Aucun utilisateur trouvé.';
            $alert = sprintf('<div class="alert alert-%2$s">%1$s</div>', $message, $style);
        }

        $this->display('admin', 'users-list', compact('pageTitle','users','alert'));
    }

    /**
     * submit
     * Submit a user
     * 
     * @return void
     */
    public function submit() : void
    {

        $user = $this->model;

        $postArray = $user->collectInput('POST'); // collect global $_POST data

        $pageTitle = 'Inscription';
        $alert = '';
        
        if ( !empty($postArray) AND isset($postArray['submit']) )
        {
            
            if (isset($postArray['email_address']))
            {
                $user_exist = $user->find($postArray['email_address'], 'email_address');
                
                if($user_exist)
                {
                    $style = 'warning';
                    $message = 'Cette adresse email existe déjà dans la base des utilisateurs. Connectez-vous à votre compte ou choisissez une autre adresse email.';
                }
                
                if(!$user_exist)
                {
                    $user->status = self::STATUS_SUBMITTED;
                    $user->role = self::ROLE_AUTHOR;
                    $this->dataTransform($user, $postArray);

                    $user->id = $user->insert();

                    if($user->id == 0)
                    {
                        $style = 'danger';
                        $message = 'Une erreur est survenue pendant l\'enregistrement.';
                    } 
                    if($user->id !== 0)
                    {
                        $style = 'success';
                        $message = 'Votre demande d\'inscription a bien été enregistrée pour validation par un administrateur.';
                    }
                }

            }

        }

        if(!empty($message)) {
            $alert = sprintf('<div class="alert alert-%2$s">%1$s</div>', $message, $style);
        }

        $this->display('front', 'register', compact('pageTitle','alert'));

    }

    /**
     * dataTransform
     * Check all the $_POST data before adding or updating a user
     *
     * @param  object $user The User instance with properties to update
     * @param  array $formdata The array with values to assign
     * @return void
     */
    public function dataTransform(object $user, array $formdata) : void {
        $user->first_name = $formdata['first_name'];
        $user->last_name = $formdata['last_name'];
        // if empty, public name = first name + last name
        $user->public_name = (!empty($formdata['public_name'])) ? $formdata['public_name'] : $formdata['first_name'].' '.$formdata['last_name'];
        $user->email_address = $formdata['email_address'];
        if (!empty($formdata['password'])) $user->password = password_hash($formdata['password'], PASSWORD_DEFAULT);
    }

    /**
     * doActionForm
     * Check what action is requested when the form is submitted and do these actions
     *
     * @param  array $postArray Array which contains $_POST entries
     * @param  object $user Concerned User instance
     * @return array with 3 variables values
     */
    public function doActionForm(array $postArray, object $user) : array
    {

        $template = 'editUser';
        $style = '';
        $message = '';
        
        if ( isset($postArray['update']) ) // if submit with update button
        {
            $message = 'Le profil a bien été mis à jour.';
            
            $this->dataTransform($user, $postArray);
            
            if ($user->update()) $style = 'success';
        }
        
        if (isset($postArray['delete'])) // if submit with delete button
        {   
            $deleteSuccess = $user->delete();

            $template = 'index';
            $style = 'success';
            $message = 'L\'utilisateur #' . $user->id . ' a bien été supprimé.';

            if (!$deleteSuccess) { // if delete() has failed
                $template = 'editUser';
                $style = 'danger';
                $message = 'L\'utilisateur #' . $user->id . ' n\'a pas pu être supprimé.';
            }
        }

        if (isset($postArray['valid']))
        {
            $updateSuccess = $user->setStatus(self::STATUS_APPROVED, true);

            $style = 'success';
            $message = 'L\'utilisateur #' . $user->id . ' a bien été approuvé.';
            $user->status = self::STATUS_APPROVED;

            if (!$updateSuccess) { // if setStatus() has failed
                $style = 'danger';
                $message = 'L\'utilisateur #' . $user->id . ' n\'a pas pu être approuvé.';
            }
        }

        if (isset($postArray['reject']))
        {
            $updateSuccess = $user->setStatus(self::STATUS_REJECTED);

            $style = 'success';
            $message = 'L\'utilisateur #' . $user->id . ' a bien été rejeté.';
            $user->status = self::STATUS_REJECTED;

            if (!$updateSuccess) { // if setStatus() has failed
                $style = 'danger';
                $message = 'L\'utilisateur #' . $user->id . ' n\'a pas pu être rejeté.';
            }
        }

        return array($template, $message, $style);

    }

}