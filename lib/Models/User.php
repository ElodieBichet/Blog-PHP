<?php

namespace App\Models;

use App\Http;

/**
 * User
 */
class User extends Model
{
    use Http;
    
     /**
     * table : name of the database table which contains the users
     *
     * @var string 
     */
    protected $table = "users";
}