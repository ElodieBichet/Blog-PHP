<?php

namespace App\Controllers;

use Throwable;

/**
 * UserController
 * Manage users
 */
class UserController extends Controller
{
    public const ROLE_DEFAULT = 0;
    public const ROLE_ADMIN = 1;
    public const ROLE_AUTHOR = 2;

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
    public function showList(): void
    {
        $this->checkAccess(true); // redirect to login page if not connected or not admin
        
        $condition = '1 = 1';
        $order = 'creation_date DESC';
        $style = 'warning';
        $message = '';

        $users = $this->model->findAll($condition, $order);
        
        if(empty($users))
        {
            $message = 'Aucun utilisateur trouvé.';
        }

        $this->display('admin', 'users-list', 'Gérer les utilisateurs', compact('users','message','style'));
    }

    /**
     * submit
     * Submit a user
     * 
     * @return void
     */
    public function submit(): void
    {

        $user = $this->model;

        $postArray = $user->collectInput('POST'); // collect global $_POST data

        $style = 'success';
        $message = '';
        
        if (!empty($postArray) AND isset($postArray['submit']) AND isset($postArray['email_address']))
        {
            $user_exist = $user->find($postArray['email_address'], 'email_address'); // search if a user with this email address already exists
            
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
                    $message = 'Votre demande d\'inscription a bien été enregistrée pour validation par un administrateur.';

                    if(NOTIFY['new_user'] == 1) // if new user notification is enabled
                    {
                        // Try to notify the site owner of the new registration
                        try
                        {
                            $serverArray = $this->collectInput('SERVER');
                            $baseUrl = 'http://'.$serverArray['HTTP_HOST'].$serverArray['PHP_SELF'];
                            $body = "Un nouvel utilisateur vient d'être enregistré : {$baseUrl}?controller=user&task=edit&id={$user->id}";
                            if (!$this->sendEmail(SITE_NAME,'noreply@myblog.fr','Nouvel utilisateur enregistré',$body))
                            {
                                throw new Throwable();
                            }
                        }
                        catch (Throwable $e)
                        {
                            // Uncomment in dev context:
                            $error = sprintf('Erreur : %1$s<br>Fichier : %2$s<br>Ligne : %3$d', $e->getMessage(), $e->getFile(), $e->getLine());
                            echo filter_var($error, FILTER_SANITIZE_STRING);
                        }
                    }
                }
            }

        }

        $this->display('front', 'register', 'Inscription', compact('message','style'));

    }

    /**
     * dataTransform
     * Check all the $_POST data before adding or updating a user
     *
     * @param  object $user The User instance with properties to update
     * @param  array $formdata The array with values to assign
     * @return void
     */
    protected function dataTransform(object $user, array $formdata): void
    {
        $user->first_name = $formdata['first_name'];
        $user->last_name = $formdata['last_name'];
        // if empty, public name = first name + last name
        $user->public_name = (!empty($formdata['public_name'])) ? $formdata['public_name'] : $formdata['first_name'].' '.$formdata['last_name'];
        $user->email_address = filter_var($formdata['email_address'], FILTER_SANITIZE_EMAIL);
        if (!empty($formdata['password'])) $user->password = password_hash($formdata['password'], PASSWORD_BCRYPT);
    }
    
    /**
     * connect
     *
     * @return void
     */
    public function connect(): void
    {
        $user = $this->model;
        $postArray = $user->collectInput('POST'); // collect global $_POST data
        $type = 'front';
        $template = 'login';
        $pageTitle = 'Connexion à l\'admin';
        $style = 'danger';
        $message = 'Echec de la connexion : identifiant ou mot de passe incorrect !';

        if (!empty($postArray['email_address']))
        {
            $DBuser = $user->find($postArray['email_address'], 'email_address');
            
            if ($DBuser)
            {
                foreach ($DBuser as $k => $v) $user->$k = $v;
                
                if (password_verify($postArray['password'], $user->password))
                {
                    switch ($user->status)
                    {
                        case self::STATUS_SUBMITTED :
                            $style = 'warning';
                            $message = 'Votre demande d\'inscription n\'a pas encore été approuvée ou rejetée par un administrateur. Réessayez plus tard.';
                            break;
                        case self::STATUS_REJECTED :
                            $message = 'Votre demande d\'inscription a été rejetée par un administrateur. Vous ne pouvez pas vous connecter à l\'admin.';
                            break;
                        case self::STATUS_APPROVED :
                            $user->setConnection(); // update $_SESSION
                            $type = 'admin';
                            $template = 'index';
                            $pageTitle = 'Tableau de bord';
                            $style = 'success';
                            $role = (string) $user->getRoleLabel();
                            $message = 'Vous êtes maintenant connecté en tant qu\''.$role.'.';
                            break;
                    }
                
                }

            }
        }

        $this->display($type, $template, $pageTitle, compact('message','style'));
    }

}