<?php 

namespace App\Controllers;

use App\Rights;

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
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new $this->modelName();
    }

}