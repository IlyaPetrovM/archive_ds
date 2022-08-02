

<?php 
   require_once __DIR__.'/boot.php';
   if (!check_auth()) { 
      header('Location: login.php');
   }
   
   include 'files.php'; 
?>
