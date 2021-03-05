<?php

namespace App;

trait Input
{
  public function collectInput(string $type = 'GET')
  {
    $constant = 'INPUT_';
    $type = constant($constant.$type);
    $inputArray = filter_input_array($type, FILTER_SANITIZE_STRING);

    return $inputArray;
  }

}