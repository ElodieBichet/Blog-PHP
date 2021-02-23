<?php

namespace App\Controllers;

use Cocur\Slugify\Slugify;
use App\Renderer;


class PostController extends Controller
{
    
    protected $modelName = \App\Models\Post::class;
    
    public function add() : void
    {
        $pageTitle = 'Ajouter un post';
        $alert = '';
        $post = $this->model;
        
        
        // $this->insert($this->table, compact($this->param1, $this->param2));
        
        
        if (!empty($_POST)) {
            
            
            if (isset($_POST['save']))
            {
                $message = 'Le post a bien été enregistré en base sous l\'identifiant ';
                $post->status = self::STATUS_APPROVED;
            }
            if (isset($_POST['saveAsDraft']))
            {
                $message = 'Le brouillon a bien été enregistré en base sous l\'identifiant ';
                $post->status = self::STATUS_DRAFT;
            }
            
            $post->author = 1; // default author
            $post->title = htmlspecialchars($_POST['title']);
            // slugify the title
            $slugify = new Slugify();
            $post->slug = $slugify->slugify($post->title);
            $post->intro = htmlspecialchars($_POST['intro']);
            $post->content = htmlspecialchars($_POST['content']);
            if (isset($_POST['date'])) {
                $post->publicationDate = date('Y-m-d h:i:s', strtotime($_POST['date']));
            } else {
                $post->publicationDate = date('Y-m-d h:i:s');
            }
            
            $post->id = $post->insert();
            $style = 'success';

            $alert = sprintf('<div class="alert alert-%2$s">%1$s %3$d</div>', $message, $style, $post->id);
        }

        Renderer::render('admin', 'postForm', compact('pageTitle','alert','post'));

    }

}