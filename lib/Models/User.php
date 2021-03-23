<?php

namespace App\Models;

use App\Http;
use PDO;

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
    public function insert(): int
    {
        $req = 'INSERT INTO '.$this->table.' SET status = :status, role = :role, first_name = :first_name, last_name = :last_name, public_name = :public_name, email_address = :email_address, password = :password, creation_date = NOW(), last_update_date = NOW(), publication_date = NOW()';
        $query = $this->pdo->prepare($req);
        $query->execute(array(
            ':status' => $this->status,
            ':role' => $this->role,
            ':first_name' => $this->first_name,
            ':last_name' => $this->last_name,
            ':public_name' => $this->public_name,
            ':email_address' => $this->email_address,
            ':password' => $this->password
        ));

        return $this->pdo->lastInsertId();
    }

    /**
     * update
     * Update the user in the database
     * 
     * @return bool true if the update succeeds
     */
    public function update(): bool
    {
        $query = $this->pdo->prepare('UPDATE '.$this->table.' SET first_name = :first_name, last_name = :last_name, public_name = :public_name, email_address = :email_address, password = :password, last_update_date = NOW() WHERE id = :id'); 
        $return = $query->execute(array(
            ':first_name' => $this->first_name,
            ':last_name' => $this->last_name,
            ':public_name' => $this->public_name,
            ':email_address' => $this->email_address,
            ':password' => $this->password,
            ':id' => $this->id
        ));

        return $return;
    }

    /**
     * getRoleLabel
     * Get role label of the item in the database
     * 
     * @return string string (or null if not found)
     */
    public function getRoleLabel(): ?string
    {
        $query = $this->pdo->prepare("SELECT * FROM roles WHERE id = :id");
        $query->execute([':id' => (int) $this->role]);
        $row = $query->fetch();
        $label = $row['label'];
        
        return $label;
    }

    /**
     * getUserPosts
     * Get all user's posts
     * 
     * @return mixed array (or null if not found)
     */
    public function getUserPosts()
    {
        $query = $this->pdo->prepare("SELECT id FROM posts WHERE author = :id");
        $query->execute([':id' => (int) $this->id]);
        $return = $query->fetchAll(PDO::FETCH_COLUMN);
        
        return $return;
    }

    /**
     * setConnection
     * Update $_SESSION with the connected user's data
     *
     * @return void
     */
    public function setConnection(): void
    {
        $currentSession = array(
            'connection' => true,
            'user_id' => $this->id,
            'user_email' => $this->email_address,
            'user_name' => $this->public_name,
            'user_role' => $this->role
        );
        $userPosts = $this->getUserPosts(); 
        $currentSession['user_posts'] = ($userPosts) ? $userPosts : array();

        foreach ($currentSession as $key => $value)
        {
            $_SESSION[$key] = $value;
        }
    }

}