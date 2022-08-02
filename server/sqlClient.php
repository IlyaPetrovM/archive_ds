<?php
   $config = include __DIR__.'/config.php';
   
   $con = new mysqli($config['db_host'], 
                     $config['db_user'], 
                     $config['db_pass'], 
                     $config['db_name']);
   
   $result = $con->query($_GET['q'] . ';');
   
   if(!$result) echo(json_encode(false));
   
   $tmpArray = array();
   foreach ($result as $row) $tmpArray[] = $row;
   echo json_encode($tmpArray);
   
   mysqli_close($con);
?>