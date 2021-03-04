<?php

namespace App\Models;

use App\Input;
use App\Rights;

class Page extends Model
{
    use Input, Rights;

    protected $table = "pages";
    protected $type;
}