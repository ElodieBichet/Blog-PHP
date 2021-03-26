<?php 

namespace App\Controllers;

use App\Rights;
use ReflectionClass;
use Throwable;
use App\Mailing;

/**
 * Controller
 * Manage Model
 */
abstract class Controller
{
    use Rights;
    use Mailing;
    
    public const STATUS_DRAFT = 0;
    public const STATUS_SUBMITTED = 1;
    public const STATUS_APPROVED = 2;
    public const STATUS_REJECTED = 3;
    
    protected $model;
    protected $modelName;
    protected $modelTrad;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new $this->modelName();
    }
    
    /**
     * dataTransform
     * Data transformation before database insertion or update
     *
     * @param  object $item
     * @param  array $formdata
     * @return void
     */
    protected abstract function dataTransform(object $item, array $formdata): void;
    
    /**
     * contact
     * Send an email to the superadmin thanks to the contact form
     *
     * @return void
     */
    public function contact(): void
    {
        $postArray = $this->collectInput('POST');

        if(isset($postArray['sendEmail']))
        {
            // Get the values of the form fields
            $name = (isset($postArray['sender_name'])) ? filter_var($postArray['sender_name'], FILTER_SANITIZE_STRING) : 'anonyme';
            $email = (isset($postArray['sender_email_address'])) ? filter_var($postArray['sender_email_address'], FILTER_SANITIZE_EMAIL) : 'indéterminée';
            $subject = (isset($postArray['sender_subject'])) ? filter_var($postArray['sender_subject'], FILTER_SANITIZE_STRING) : 'contactez-moi';
            $body = (isset($postArray['sender_message'])) ? filter_var($postArray['sender_message'], FILTER_SANITIZE_STRING) : '';
            $body = 'Message de '. $name .' ('.$email.') envoyé le '.date("d/m/Y à H\hi").' : '."\n\n".$body;

            try
            {
                // Send the email
                $result = $this->sendEmail($name, $email, $subject, $body);
                
                if (!($result))
                {
                    throw new Throwable();
                }
                $message = 'Le message a bien été envoyé.';
                $style = 'success';
            }
            catch (Throwable $e)
            {
                $message = 'Une erreur est survenue, le message n\'a pas pu être envoyé.';
                $style = 'danger';
                // Uncomment in dev context:
                $error = sprintf('Erreur : %1$s<br>Fichier : %2$s<br>Ligne : %3$d', $e->getMessage(), $e->getFile(), $e->getLine());
                echo filter_var($error, FILTER_SANITIZE_STRING);
            }
    
            $this->display('front','contactme','Contactez-moi',compact('message','style'));
        }

    }

    /**
     * edit
     * Display comment edition form
     * 
     * @return void
     */
    public function edit(): void
    {
        $modelTrad = $this->modelTrad;
        $pageTitle = 'Modifier '.$modelTrad['article_the'].$modelTrad['item'];
        $style = 'warning';
        $message = '';
        $item = $this->model;
        $itemClass = new ReflectionClass($item); // to get the class name of the item
        $itemClassName = strtolower($itemClass->getShortName());
        $template = 'edit-'.$itemClassName;
        $this->checkAccess(); // redirect to login page if not connected
        $getArray = $item->collectInput('GET'); // collect global $_GET data
        $postArray = $item->collectInput('POST'); // collect global $_POST data

        if(empty($getArray['id'])) // if no ID
        {
            $template = 'index';
            $message = 'Vous devez spécifier l\'identifiant '.$modelTrad['of'].$modelTrad['item'].' que vous souhaitez modifier.';
        }

        if(!empty($getArray['id']))
        {
            $getId = (int) $getArray['id'];
            $DBitem = $item->find($getId); // search the item with this id in database and get it if it exists

            if (!$DBitem) // if item not found in database
            {
                $pageTitle = 'Gérer les '.$modelTrad['item'].'s';
                $template = 'index';
                $message = ucfirst($modelTrad['article_the']).$modelTrad['item'].' que vous souhaitez modifier n\'existe pas ou l\'identifiant est incorrect.';
            }

            if (!empty($DBitem)) // if item exists in database
            {
                foreach ($DBitem as $k => $v) $item->$k = $v;

                $this->checkAccess(false, $item);
                $pageTitle = 'Modifier '.$modelTrad['article_the'].$modelTrad['item'].' #'.$item->id;

                if (!empty($postArray))
                {
                    $pageTitle = (isset($postArray['delete'])) ? 'Suppression '.$modelTrad['of'].$modelTrad['item'].' #'.$item->id : $pageTitle;
                    list($template, $message, $style) = $this->doActionForm($item, $postArray);
                }
            }

        }

        $variables = array(
            'style' => $style,
            'message' => $message,
            $itemClassName => $item
        );

        $this->display('admin', $template, $pageTitle, $variables);

    }

    /**
     * doActionForm
     * Check what action is requested when the form is submitted and do these actions
     *
     * @param  object   $item Concerned item instance
     * @param  array    $postArray Array which contains $_POST entries
     * @return array with 3 variables values
     */
    protected function doActionForm(object $item, array $postArray): array
    {
        $this->checkAccess(false, $item);
        $modelTrad = $this->modelTrad;
        $itemClass = new ReflectionClass($item); // to get the class name of the item
        $itemClassName = strtolower($itemClass->getShortName());
        $template = 'edit-'.$itemClassName;
        $style = '';
        $message = '';

        if (isset($postArray['update']) OR isset($postArray['updateAsDraft'])) // if submit with update button
        {

            $message = ucfirst($modelTrad['article_the']).$modelTrad['item'].' a bien été mis à jour.';
            if ($item->status == self::STATUS_DRAFT) $item->status = self::STATUS_SUBMITTED;

            if (isset($postArray['updateAsDraft']))
            {
                $message = 'Le brouillon a bien mis à jour.';
                $item->status = self::STATUS_DRAFT;
            }
            
            $this->dataTransform($item, $postArray);
            
            if ($item->update()) $style = 'success';
        }
        
        if (isset($postArray['delete'])) // if submit with delete button
        {            
            $deleteSuccess = $item->delete();

            $template = 'index';
            $style = 'success';
            $message = ucfirst($modelTrad['article_the']).$modelTrad['item'].' #' . $item->id . ' a bien été supprimé.';

            if (!$deleteSuccess) // if delete() has failed
            { 
                $template = 'edit-'.$itemClassName;
                $style = 'danger';
                $message = ucfirst($modelTrad['article_the']).$modelTrad['item'].' #' . $item->id . ' n\'a pas pu être supprimé.';
            }
        }

        if (isset($postArray['valid']))
        {
            $updateSuccess = $item->setStatus(self::STATUS_APPROVED);

            $style = 'success';
            $message = ucfirst($modelTrad['article_the']).$modelTrad['item'].' #' . $item->id . ' a bien été approuvé.';
            $item->status = self::STATUS_APPROVED;

            if (!$updateSuccess) // if setStatus() has failed
            {
                $style = 'danger';
                $message = ucfirst($modelTrad['article_the']).$modelTrad['item'].' #' . $item->id . ' n\'a pas pu être approuvé.';
            }
        }

        if (isset($postArray['reject']))
        {
            $updateSuccess = $item->setStatus(self::STATUS_REJECTED);

            $style = 'success';
            $message = ucfirst($modelTrad['article_the']).$modelTrad['item'].' #' . $item->id . ' a bien été rejeté.';
            $item->status = self::STATUS_REJECTED;

            if (!$updateSuccess) // if setStatus() has failed
            {
                $style = 'danger';
                $message = ucfirst($modelTrad['article_the']).$modelTrad['item'].' #' . $item->id . ' n\'a pas pu être rejeté.';
            }
        }

        return array($template, $message, $style);

    }

}