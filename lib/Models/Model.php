<?php

namespace Models;

use App\Database;

abstract class Model
{
    protected $pdo;

    function __construct()
    {
        $this->pdo = Database::getPdo();
    }
    
}