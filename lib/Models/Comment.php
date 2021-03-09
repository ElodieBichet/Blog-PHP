<?php

namespace App\Models;

use App\Http;

class Comment extends Model
{
    use Http;

    protected $table = "comments";
    protected $id;
    protected $author;
    protected $email_address;
    protected $content;
    protected $post_id;

    /**
     * Insert the item in the database and return the id of the new line
     * 
     * @return int
     */
    public function insert() : int
    {
        $req = 'INSERT INTO '.$this->table.' SET status = :status, post_id = :post_id , author = :author, email_address = :email_address, content = :content, creation_date = NOW(), last_update_date = NOW(), publication_date = NOW()';
        $query = $this->pdo->prepare($req);
        $query->execute(array(
            ':status' => $this->status,
            ':post_id' => $this->post_id,
            ':author' => $this->author,
            ':email_address' => $this->email_address,
            ':content' => $this->content
        ));

        return $this->pdo->lastInsertId();
    }

    /**
     * Update the item in the database and return true if there is no error
     * 
     * @return bool
     */
    public function update() : bool
    {
        $query = $this->pdo->prepare('UPDATE '.$this->table.' SET author = :author, email_address = :email_address, content = :content, last_update_date = NOW() WHERE id = :id'); 
        $return = $query->execute(array(
            ':author' => $this->author,
            ':email_address' => $this->email_address,
            ':content' => $this->content,
            ':id' => $this->id
        ));

        return $return;
    }
}