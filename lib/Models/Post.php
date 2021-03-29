<?php

namespace App\Models;

use App\Http;
use PDO;
use App\Models\Comment;

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
    public function insert(): int
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
    public function update(): bool
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

    /**
     * getAuthor
     * Get public_name or any column of the post author in the database
     * 
     * @param  string $column Name of the column id users table in database
     * @return mixed type depends on the column (or null if not found)
     */
    public function getAuthor(string $column = 'public_name')
    {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $query->execute([':id' => (int) $this->author]);
        $row = $query->fetch();
        $label = ($row) ? $row[$column] : 'utilisateur supprimé';
        
        return $label;
    }
    
    /**
     * getComments
     * Get comments (or number of comments) of the current post 
     *
     * @param  bool $approved   if true, get only approved comments
     * @param  bool $num        if true, get number of comments instead of comments as objects
     * @return mixed    
     */
    public function getComments(bool $approved = true, bool $num = false)
    {    
        $condition = "post_id = :id";
        if ($approved) $condition .= " AND status = 2";
        $query = $this->pdo->prepare("SELECT * FROM comments WHERE ".$condition);
        $query->execute([':id' => $this->id]);
        if (!$num) $result = $query->fetchAll(PDO::FETCH_CLASS, get_class(new Comment()));
        if ($num) $result = $query->rowCount();
        
        return $result;
    }

}