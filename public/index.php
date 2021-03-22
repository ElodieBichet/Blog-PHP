<?php

// Composer autoloader
require_once '../vendor/autoload.php';

try
{
    App\Application::process();
}
catch (Throwable $e)
{
    echo '<p style="text-align:center;font-size:1.4em;font-weight:bold;margin-top:2em;">Désolé, un erreur est survenue :-(</p>';
    // Uncomment in dev context :
    // echo 'Erreur : '. $e->getMessage() .'<br>Fichier : '. $e->getFile() .'<br>Ligne : '. $e->getLine();
}