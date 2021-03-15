<?php

namespace App;

trait Rights
{
  use Http;
  
  /**
   * checkAccess
   * Check if a user is connected and has rights to make action, and redirect to the login page or denied access page if not
   *
   * @param  bool $admin  True if an admin role is needed, False else
   * @param  mixed $item  Optional, if the requested action concerns an specific item
   * @return void
   */
  public function checkAccess(bool $admin = false, object $item = null) : void
  {
    $isConnected = self::isConnected();

    if(!$isConnected)
    {
      $this->redirect('index.php?login');
    }

    $isAdmin = self::isAdmin();
    $isAllowed = (bool) true;

    if(!$isAdmin)
    {
      if($admin)
      {
        $isAllowed = false;
      }

      if(!$admin AND !empty($item))
      {
        $itemClass = new \ReflectionClass($item);
        $classname = $itemClass->getShortName();
        
        switch ($classname)
        {
          case 'Comment' : // if comment, check if the post_id is in the user's posts
            $user_posts = $_SESSION['user_posts'];
            if(!in_array($item->post_id, $user_posts)) $isAllowed = false;
            break;
          case 'Post' : // if post, check if the user is the author
            $user_id = $_SESSION['user_id'];
            if($item->author != $user_id) $isAllowed = false;
            break;
          case 'User' : // if user, check if this is the current connected user
            $user_id = $_SESSION['user_id'];
            if($item->id != $user_id) $isAllowed = false;
            break;
          default :
            $isAllowed = false;
        }
      }
    }
    
    if (!$isAllowed) $this->redirect('index.php?controller=page&task=showAccessDenied');

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
  public static function isConnected() : bool
  {
    $connection = (array_key_exists('connection', $_SESSION)) ? filter_var($_SESSION['connection'], FILTER_SANITIZE_STRING) : false;

    return $connection;
  }

  /**
   * isAdmin
   * Test if a connected user is an admin thanks to the $_SESSION superglobal
   *
   * @return bool
   */
  public static function isAdmin() : bool
  {
    $role = (array_key_exists('user_role', $_SESSION)) ? filter_var($_SESSION['user_role'], FILTER_SANITIZE_STRING) : 0;

    return ($role == 1);
  }

}