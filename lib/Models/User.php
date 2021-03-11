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
    /**
     * id : id of the user in the database
     * 
     * @var int
     */
    protected $id;    
    /**
     * first_name
     *
     * @var string
     */
    protected $first_name;  
    /**
     * last_name
     *
     * @var string
     */
    protected $last_name;
    /**
     * public_name : choosen by the user to be visible
     *
     * @var string
     */
    protected $public_name;
    /**
     * email_address : user's email address
     *
     * @var string
     */
    protected $email_address;    
    /**
     * password
     *
     * @var string
     */    
    protected $password;   
    /**
     * role : determines rights in the admin
     *
     * @var string
     */    
    protected $role;
    
    /**
     * insert
     * Insert the user in the database 
     * 
     * @return int  id of the new user (= 0 if insertion fails)
     */    
    public function insert() : int
    {
        $req = 'INSERT INTO '.$this->table.' SET status = :status, role = :role, first_name = :first_name, last_name = :last_name, email_address = :email_address, password = :password, creation_date = NOW(), last_update_date = NOW(), publication_date = NOW()';
        $query = $this->pdo->prepare($req);
        $query->execute(array(
            ':status' => $this->status,
            ':role' => $this->role,
            ':first_name' => $this->first_name,
            ':last_name' => $this->last_name,
            ':email_address' => $this->email_address,
            ':password' => $this->password
        ));

        return $this->pdo->lastInsertId();
    }

}