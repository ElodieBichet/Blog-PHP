<?php

namespace App\Models;

use App\Http;

class Page extends Model
{
    use Http;

    protected $table = "pages";
    protected $type;
}