<?php

namespace App\Models;

use App\Database;
use PDO;

abstract class Model
{    
    protected $pdo;
    protected $table;
    protected $status;
    protected $creation_date;
    protected $last_update_date;
    protected $publication_date;

    function __construct()
    {
        $this->pdo = Database::getPdo();
    }

    // Setter
    public function __set($attr, $value) : void {
        $this->$attr = $value;
    }
    
    // Getter
    public function __get($attr) {
        return $this->$attr;
    }

    /**
     * Delete the item in the database
     * 
     * @return object
     */
    public function delete() : bool
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $result = $query->execute(['id' => $this->id]);
        
        return $result;
    }

    /**
     * Find the item in the database thanks to a value of any column, and return it (return the first one if several rows found)
     * 
     * @param          $value  searched value in the database
     * @param   string $name   name of the column in the table
     * 
     * @return object
     */
    public function find($value, string $name='id')
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$name} = :{$name}");
        $query->execute([':'.$name => $value]);
        $item = $query->fetchObject();

        return $item;
    }

    /**
     * Find the item in the database thanks to a value of any column, and return it (return the first one if several rows found)
     * 
     * @return 
     */
    public function findAll(string $condition = '1 = 1', string $order = 'last_update_date DESC')
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE " . $condition . " ORDER BY " . $order);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, get_class($this));

        return $result;
    }
}