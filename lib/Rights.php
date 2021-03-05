<?php

namespace App;

trait Rights
{
  use Http;

  public function checkAccess()
  {
    $isConnected = self::isConnected();

    if(!$isConnected)
    {
        $this->redirect('index.php?login');      
    }
  }

  public function display(string $type, string $path, array $variables)
  {
    $isConnected = self::isConnected();
    Renderer::render($type, $path, $isConnected, $variables);
  }

  public static function isConnected() : bool{
    $connection = (array_key_exists('connection', $_SESSION)) ? filter_var($_SESSION['connection'], FILTER_SANITIZE_STRING) : false;

    return $connection;
  }

}