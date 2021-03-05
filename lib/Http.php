<?php

namespace App;

trait Http
{
  public function collectInput(string $type = 'GET')
  {
    $constant = 'INPUT_';
    $type = constant($constant.$type);
    $inputArray = filter_input_array($type, FILTER_SANITIZE_STRING);

    return $inputArray;
  }

  public function logout() : void
  {
    $serverArray = $this->collectInput('SERVER');
    session_destroy();
    $url = (!empty($serverArray['PHP_SELF'])) ? $serverArray['PHP_SELF'] : 'index.php';
    $this->redirect($url);
  }

  public function redirect(string $url): void
  {
      header("Location: $url");
      exit(0);
  }


}