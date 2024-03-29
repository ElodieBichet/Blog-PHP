<?php

namespace App\Models;

use App\Database;
use PDO;

abstract class Model
{        
    /**
     * pdo : database connection
     *
     * @var object PDO
     */
    protected $pdo;    
    /**
     * table : name of the database table which contains the comments
     *
     * @var string 
     */
    protected $table;    
    /**
     * status
     *
     * @var int
     */
    protected $status;    
    /**
     * creation_date
     *
     * @var string
     */
    protected $creation_date;    
    /**
     * last_update_date
     *
     * @var string
     */
    protected $last_update_date;    
    /**
     * publication_date
     *
     * @var string
     */
    protected $publication_date;
    
    /**
     * __construct
     *
     * @return void
     */
    function __construct()
    {
        $this->pdo = Database::getPdo();
    }
 
    /**
     * __set
     *
     * @param  mixed $attr
     * @param  mixed $value
     * @return void
     */
    public function __set($attr, $value): void
    {
        $this->$attr = $value;
    }
       
    /**
     * __get
     *
     * @param  mixed $attr
     * @return mixed
     */
    public function __get($attr)
    {
        return $this->$attr;
    }
       
    /**
     * insert
     * Insert new item in the database
     *
     * @return int  id of the inserted item in the database
     */
    public abstract function insert(): int;

    /**
     * update
     * Update the item in the databse
     *
     * @return bool true in case of success, false else
     */
    public abstract function update(): bool;

    /**
     * delete
     * Delete the item in the database
     *
     * @return bool
     */
    public function delete(): bool
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $result = $query->execute(['id' => $this->id]);
        
        return $result;
    }
  
    /**
     * setStatus
     * Update status of the item in the database
     *
     * @param  int $status
     * @param  bool $updatePubDate
     * @return bool true if the update succeeds
     */
    public function setStatus(int $status = 1, bool $updatePubDate = false): bool
    {
        $partQuery = ($updatePubDate) ? ', publication_date = NOW()' : '';
        $query = $this->pdo->prepare("UPDATE {$this->table} SET status = :status, last_update_date = NOW(){$partQuery} WHERE id = :id");
        $result = $query->execute(array(
            'status' => $status,
            'id' => $this->id
        ));
        
        return $result;
    }

    /**
     * getStatusLabel
     * Get status label of the item in the database
     * 
     * @return string string (or null if not found)
     */    
    public function getStatusLabel(): ?string
    {
        $query = $this->pdo->prepare("SELECT * FROM status WHERE id = :id");
        $query->execute([':id' => (int) $this->status]);
        $row = $query->fetch();
        $label = $row['label'];
        
        return $label;
    }

    /**
     * find
     * Find the item in the database thanks to a value of any column, and return it (return the first one if several rows found)
     * 
     * @param mixed $value  searched value in the database
     * @param string $name  name of the column in the table
     * @return mixed item as an object if found
     */    
    public function find($value, string $name='id')
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$name} = :{$name}");
        $query->execute([':'.$name => $value]);
        $item = $query->fetchObject();

        return $item;
    }
 
    /**
     * findAll
     * Find all the item in the database with conditions return it (return the first one if several rows found)
     *
     * @param  string   $condition    condition of the SLQ query
     * @param  string   $order        order of the SQL query
     * @return array    array of objects (or =null if no result)
     */
    public function findAll(string $condition = '1 = 1', string $order = 'last_update_date DESC'): ?array
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE " . $condition . " ORDER BY " . $order);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, get_class($this));

        return $result;
    }
}