<?php

namespace App;

trait Rights
{
  use Http;
  
  /**
   * checkAccess
   * Check if a user is connected and redirect to the login page if not
   *
   * @return void
   */
  public function checkAccess() : void
  {
    $isConnected = self::isConnected();

    if(!$isConnected)
    {
        $this->redirect('index.php?login');      
    }
  }
  
  /**
   * display
   * Call the Renderer class to display the right page
   *
   * @param  string $type 'admin' or 'front' context
   * @param  string $path template name without any extension
   * @param  array  $variables  array with all needed variables used in templates
   * @return void
   */
  public function display(string $type, string $path, array $variables)
  {
    $isConnected = self::isConnected();
    Renderer::render($type, $path, $isConnected, $variables);
  }
  
  /**
   * isConnected
   * Test if a user is connected thanks to the $_SESSION superglobal
   *
   * @return bool
   */
  public static function isConnected() : bool{
    $connection = (array_key_exists('connection', $_SESSION)) ? filter_var($_SESSION['connection'], FILTER_SANITIZE_STRING) : false;

    return $connection;
  }

}