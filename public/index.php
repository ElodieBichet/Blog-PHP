<?php

// Composer autoloader
require_once '../vendor/autoload.php';

require_once '../config.php';

try
{
    App\Application::process();
}
catch (Throwable $e)
{
    echo '<p style="text-align:center;font-size:1.4em;font-weight:bold;margin-top:2em;">Désolé, un erreur est survenue :-(</p>';
    // Uncomment in dev context :
    $error = sprintf('Erreur : %1$s<br>Fichier : %2$s<br>Ligne : %3$d', $e->getMessage(), $e->getFile(), $e->getLine());
    echo filter_var($error, FILTER_SANITIZE_STRING);
}