
<?php
   require_once __DIR__.'/boot.php';
   $config = include __DIR__.'/server/config.php'; 

    $con = new mysqli($config['db_host'], 
                     $config['db_user'], 
                     $config['db_pass'], 
                     $config['db_name']);
    $pass = '';
$res_arr = Array();
    $result = $con->query("SELECT pass,email FROM users WHERE email like '". $_POST['username'] . "' LIMIT 1;");
    if($result) {
        $res_arr = $result->fetch_array();
        if($res_arr['email'] == $_POST['username']) echo 'Пользователя нашли. ';
        else echo 'Пользователь с почтой '. $res_arr['email'] .' не найден. <a href="login.php">Попробовать снова</a>.';
        $pass  = $res_arr['pass'];
        if (password_verify($_POST['password'], $pass)){
            $_SESSION['username'] = $_POST['username'];
            echo 'Пароль введён верно! ';
            header('Location: /');
            die;
        }else{
           echo '<br>Пароль неверен. Попробуйте <a href="login.php">ещё раз</a>';
           //header('Location: login.php');
        }
    }
    else {
        echo '<br> Возникла ошибка. Обратитесь к администратору сайта. <a href="login.php">Попробовать снова</a>';
        //header('Location: /login.php');
        //die;
    }
    



mysqli_close($con);
?>