<?php

namespace App\Models;

class Post extends Model
{
    protected $table = "posts";
    protected $id;
    protected $author;
    protected $title;
    protected $slug;
    protected $intro;
    protected $content;

    public function insert() : int
    {
        $query = $this->pdo->prepare('INSERT INTO '.$this->table.' SET status = :status, author = :author, title = :title, slug = :slug, intro = :intro, content = :content, publication_date = :publication_date, creation_date = NOW(), last_update_date = NOW()'); 
        $query->execute(array(
            ':status' => $this->status,
            ':author' => $this->author,
            ':title' => $this->title,
            ':slug' => $this->slug,
            ':intro' => $this->intro,
            ':content' => $this->content,
            ':publication_date' => $this->publicationDate
        ));

        return $this->pdo->lastInsertId();
    }
}