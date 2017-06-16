<?php
  session_start();
  function isLogin()
  {
    if(isset($_COOKIE['username']) && isset($_COOKIE['password']))
    {
      $username = $_COOKIE['username'];
      $password = $_COOKIE['password'];
      if(isset($_SESSION['username']) && isset($_SESSION['password']))
      {
        if($username==$_SESSION['username'] && $password==$_SESSION['password'])
        {
          return true;
        }
        else
        {
          return false;
        }
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }

  function tips($string)
  {
    echo '<script>alert("'. $string .'")</script>';
  }

?>
