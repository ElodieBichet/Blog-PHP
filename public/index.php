<?php

// Composer autoloader
require_once('../vendor/autoload.php');

use App\Database;
use App\Session;
use App\Http;
use App\Renderer;

// Init a database connection if it doesn't exist
$pdo = Database::getPdo();

// Call session_start() once
Session::getInstance();

// Destroy current session
if (isset($_GET['logout'])) 
{
    Session::logout();
}

$type = 'front';
$page = 'index';
$variables = [];

if (isset($_GET['admin']))
{
    if (!isset($_SESSION['connection']) OR $_SESSION['connection'] == false) {
        Http::redirect($_SERVER['PHP_SELF'] . '?page=login');
    } else {
        $type = 'admin';
    }
}

if (!empty($_GET['page']))
{
    $page = $_GET['page'];
}

Renderer::render($type, $page, $variables);