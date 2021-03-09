<?php

namespace App\Models;

use App\Http;

class Post extends Model
{
    use Http;

    protected $table = "posts";
    protected $id;
    protected $author;
    protected $title;
    protected $slug;
    protected $intro;
    protected $content;
    protected $nb_comments;

    /**
     * Insert the item in the database and return the id of the new line
     * 
     * @return int
     */
    public function insert() : int
    {
        $req = 'INSERT INTO '.$this->table.' SET status = :status, author = :author, title = :title, slug = :slug, intro = :intro, content = :content, creation_date = NOW(), last_update_date = NOW(), publication_date = :publication_date';
        $query = $this->pdo->prepare($req);
        $query->execute(array(
            ':status' => $this->status,
            ':author' => $this->author,
            ':title' => $this->title,
            ':slug' => $this->slug,
            ':intro' => $this->intro,
            ':content' => $this->content,
            ':publication_date' => $this->publication_date
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
        $query = $this->pdo->prepare('UPDATE '.$this->table.' SET status = :status, author = :author, title = :title, slug = :slug, intro = :intro, content = :content, publication_date = :publication_date, last_update_date = NOW() WHERE id = :id'); 
        $return = $query->execute(array(
            ':status' => $this->status,
            ':author' => $this->author,
            ':title' => $this->title,
            ':slug' => $this->slug,
            ':intro' => $this->intro,
            ':content' => $this->content,
            ':publication_date' => $this->publication_date,
            ':id' => $this->id
        ));

        return $return;
    }

}