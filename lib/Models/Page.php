<?php

namespace App\Models;

use App\Http;

class Page extends Model
{
    use Http;

     /**
     * table : name of the database table which contains the pages (not available now)
     *
     * @var string 
     */
    protected $table = "pages";    
    /**
     * type : context of the page => 'admin' or 'front'
     *
     * @var string
     */
    protected $type;
    /**
     * template : name of the template file without .html.php
     *
     * @var string
     */
    protected $template;
    /**
     * title : title of the page
     *
     * @var string
     */
    protected $title;

    public function insert(): int
    {
        // do nothing for the moment as pages are not managed in database like other items
        return 0;
    }

    public function update(): bool
    {
        // do nothing for the moment as pages are not managed in database like other items
        return false;
    }
}