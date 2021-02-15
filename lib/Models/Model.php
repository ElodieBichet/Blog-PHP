<?php

namespace Models;

abstract class Model
{
    protected $pdo;

    function __construct()
    {
        $this->pdo = \Database::getPdo();
    }
    
}