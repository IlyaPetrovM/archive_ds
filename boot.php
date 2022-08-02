<?php 
session_start();
   //if ($_SESSION('username') === '') {
  //    header('Location: login.php');
      //die;
   //}
   

function check_auth(): bool
{
    return !!($_SESSION['username'] ?? false);
}

?>