<?php 

namespace App\Controllers;

use App\Rights;
use ReflectionClass;

/**
 * Controller
 * Manage Model
 */
abstract class Controller
{
    use Rights;
    
    const STATUS_DRAFT = 0;
    const STATUS_SUBMITTED = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;
    
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

    abstract function doActionForm(array $postArray, object $item) : array;

    /**
     * edit
     * Display comment edition form
     * 
     * @return void
     */
    public function edit() : void
    {
        $modelTrad = $this->modelTrad;
        $pageTitle = 'Modifier '.$modelTrad['article_the'].$modelTrad['item'];
        $alert = '';
        $item = $this->model;
        $itemClass = new ReflectionClass($item); // to get the class name pf the item
        $template = 'edit'.$itemClass->getShortName();
        $this->checkAccess(); // redirect to login page if not connected
        $getArray = $item->collectInput('GET'); // collect global $_GET data
        $postArray = $item->collectInput('POST'); // collect global $_POST data

        if(empty($getArray['id'])) // if no ID
        {
            $template = 'index';
            $style = 'warning';
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
                $style = 'warning';
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
                    list($template, $message, $style) = $this->doActionForm($postArray, $item);
                }
            }

        }

        if(!empty($message)) {
            $alert = sprintf('<div class="alert alert-%2$s">%1$s</div>', $message, $style);
        }

        $variables = array(
            'pageTitle' => $pageTitle,
            'alert' => $alert,
            strtolower($itemClass->getShortName()) => $item
        );

        $this->display('admin', $template, $variables);

    }


}