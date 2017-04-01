<?php
  session_start();
  $from_url =  $_SERVER['HTTP_REFERER'];
  foreach($_COOKIE as $key=>$value)
  {
    setCookie($key,"",time()-60);
    $_COOKIE[$key] = "";
  }
  session_unset();
  session_destroy();
  header("Location:$from_url");
?>
