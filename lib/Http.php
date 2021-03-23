<?php

namespace App;

trait Http
{  
  /**
   * collectInput
   * Pick up $_POST, $_GET or $_SERVER superglobals in a secured way
   *
   * @param  string $type
   * @return array
   */
  public function collectInput(string $type = 'GET')
  {
    $constant = 'INPUT_';
    $type = constant($constant.$type);
    $inputArray = filter_input_array($type, FILTER_SANITIZE_STRING);

    return $inputArray;
  }
  
  /**
   * logout
   *
   * @return void
   */
  public function logout() : void
  {
    $serverArray = $this->collectInput('SERVER');
    $_SESSION = array();
    session_destroy();
    $url = (!empty($serverArray['HTTP_REFERER'])) ? $serverArray['HTTP_REFERER'] : 'index.php';
    $this->redirect($url);
  }
  
  /**
   * redirect
   *
   * @param  string $url  URL to redirect user
   * @return void
   */
  public function redirect(string $url) : void
  {
      header("Location: $url");
      exit;
  }

}