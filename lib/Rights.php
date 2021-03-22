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
   * @param  mixed $item  Optional (object or null), if the requested action concerns a specific item
   * @return void
   */
  public function checkAccess(bool $admin = false, object $item = null) : void
  {
    $isConnected = self::isConnected();

    if(!$isConnected)
    {
      $this->redirect('index.php?page=login');
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
          case 'Comment' : // if comment, allowed user is the author of the concerned post
            $author = $item->getPostAuthor();
            $allowedUser = $author->id;
            break;
          case 'Post' : // if post, allowed user is the author
            $allowedUser = $item->author;
            break;
          case 'User' : // if user, allowed user is the user himself
            $allowedUser = $item->id;
            break;
          default :
            $allowedUser = 0;
        }

        $currentSession = filter_var_array($_SESSION);
        $user_id = $currentSession['user_id'];
        if($allowedUser != $user_id) $isAllowed = false;
      }
    }
    
    if (!$isAllowed) $this->redirect('index.php?page=access-denied');

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
  public function display(string $type, string $path, string $pageTitle, array $variables = [])
  {
    $isConnected = self::isConnected();
    $isAdmin = self::isAdmin();
    Renderer::render($type, $path, $isConnected, $isAdmin, $pageTitle, $variables);
  }
  
  /**
   * isConnected
   * Test if a user is connected thanks to the $_SESSION superglobal
   *
   * @return bool
   */
  public static function isConnected() : bool
  {
    $connection = (array_key_exists('connection', $_SESSION)) ? filter_var((bool) $_SESSION['connection'], FILTER_SANITIZE_STRING) : false;

    return (bool) $connection;
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