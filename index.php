<?php 

// Autoload needed classes
require_once('lib/autoload.php');

// Init a database connection if it doesn't exist
$pdo = \Database::getPdo();

// Call session_start() once
\Session::getInstance();

// Destroy current session
if (isset($_GET['logout'])) 
{
    session_destroy();
    Http::redirect($_SERVER['PHP_SELF']);
}

// var_dump($_SESSION);

$type = 'front';
$page = 'index';
$variables = [];

if (isset($_GET['admin']))
{
    $type = 'admin';
    // A faire : si pas connecté, renvoyer vers la page de connexion ($page=login)
}

if (!empty($_GET['page']))
{
    $page = $_GET['page'];
}

\Renderer::render($type, $page, $variables);