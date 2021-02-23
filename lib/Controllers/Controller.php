<?php 

namespace App\Controllers;

abstract class Controller
{
    const STATUS_DRAFT = 0;
    const STATUS_SUBMITTED = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;
    
    protected $model;
    protected $modelName;

    public function __construct()
    {
        $this->model = new $this->modelName();
    }

}