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
    // var_dump($e);
}