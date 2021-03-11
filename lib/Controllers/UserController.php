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

        $template = 'register';
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
     * Check all the $_POST data before adding or updating a comment
     *
     * @param  object $user The User instance with properties to update
     * @param  array $formdata The array with values to assign
     * @return void
     */
    public function dataTransform(object $user, array $formdata) : void {
        $user->first_name = $formdata['first_name'];
        $user->last_name = $formdata['last_name'];
        $user->public_name = $formdata['public_name'];
        $user->email_address = $formdata['email_address'];
        $user->password = password_hash($formdata['password'], PASSWORD_DEFAULT);
    }

}