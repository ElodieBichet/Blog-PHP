<?php

namespace App\Models;

use App\Database;

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
    public function delete() : void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $this->id]);
    }

    /**
     * Find the item in the database thanks to its id and return it
     * 
     * @return object
     */
    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $id]);
        $item = $query->fetchObject();

        return $item;
    }
}