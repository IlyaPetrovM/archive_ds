
<?php
   require_once __DIR__.'/boot.php';
   $config = include __DIR__.'/config.php'; 
   
echo 'usr: '.$_POST['username'];
echo 'psv: '.$_POST['password'];

if ($_POST['password'] == $config['db_pass'] && $_POST['username'] == $config['db_user']){
   
    $_SESSION['username'] = $_POST['username'];
    header('Location: /');
    die;
}else{
   echo 'пароль неверен';
   header('Location: login.php');
   
}


?>