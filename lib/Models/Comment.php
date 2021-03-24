<?php

namespace App\Models;

use App\Http;

/**
 * Comment
 */
class Comment extends Model
{
    use Http;
    
    /**
     * table : name of the database table which contains the comments
     * 
     * @var string
     */    
    protected $table = "comments";    
    /**
     * id : id of the comment in the database
     * 
     * @var int
     */
    protected $id;    
    /**
     * author : username of the comment author
     *
     * @var string
     */
    protected $author;    
    /**
     * email_address : author's email address
     *
     * @var string
     */
    protected $email_address;    
    /**
     * content : comment
     *
     * @var string
     */    
    protected $content;    
    /**
     * post_id : id of the commented post
     *
     * @var int
     */
    protected $post_id;

    /**
     * insert
     * Insert the comment in the database 
     * 
     * @return int  id of the new comment (= 0 if insertion fails)
     */    
    public function insert(): int
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
     * update
     * Update the comment in the database
     * 
     * @return bool true if the update succeeds
     */
    public function update(): bool
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
    
    /**
     * getPostAuthor
     * Get Id, email address and public name of the concerned post's author
     *
     * @return object    object, or null if nothing found
     */
    public function getPostAuthor(): ?object
    {
        $query = $this->pdo->prepare("SELECT users.id, email_address, public_name FROM users INNER JOIN posts ON posts.author = users.id WHERE posts.id = :id");
        $query->execute([':id' => $this->post_id]);
        $item = $query->fetchObject();

        return $item;
    }

    /**
     * getPostTitle
     * Get title of the concerned post
     *
     * @return string    string or null if nothing found
     */
    public function getPostTitle(): ?string
    {
        $query = $this->pdo->prepare("SELECT id, title FROM posts WHERE posts.id = :id");
        $query->execute([':id' => $this->post_id]);
        $row = $query->fetch();
        $title = $row['title'];
        
        return $title;
    }

}