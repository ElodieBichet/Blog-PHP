<?php

namespace App;

trait Rights
{
  public function checkAccess()
  {
    $isConnected = Session::isConnected();

    if(!$isConnected)
    {
        Http::redirect('index.php?login');      
    }
  }

}