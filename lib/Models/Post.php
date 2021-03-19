<?php

namespace App\Models;

use App\Http;

class Post extends Model
{
    use Http;
    
    /**
     * table : name of the database table which contains the posts
     *
     * @var string 
     */
    protected $table = "posts";
    /**
     * id : id of the post in the database
     * 
     * @var int
     */
    protected $id;
    /**
     * author : id of the author user in the database
     * 
     * @var int
     */
    protected $author;
    /**
     * title
     *
     * @var string
     */ 
    protected $title;    
    /**
     * slug : "slugified" title of the post
     *
     * @var string
     */
    protected $slug;    
    /**
     * intro : extract of the post
     *
     * @var string
     */
    protected $intro;    
    /**
     * content
     *
     * @var string
     */
    protected $content;    
    /**
     * nb_comments : number of comments on the post
     *
     * @var int
     */
    protected $nb_comments;

    /**
     * insert
     * Insert the post in the database
     * 
     * @return int  id of the new post (= 0 if insertion fails)
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
     * update
     * Update the post in the database
     * 
     * @return bool true if the update succeeds
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