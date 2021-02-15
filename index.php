<?php 

require_once('lib/autoload.php');
$pdo = \Database::getPdo();

// Test for database connection
// $query = $pdo->prepare("SELECT * FROM roles WHERE id = :id");
// $query->execute(['id' => 1]);
// $item = $query->fetch();
//
// var_dump($item);

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