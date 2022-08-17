<?php
$config = include __DIR__.'/server/config.php';


function randomPassword() {
    $alphabet = 'derevni-selaDEREVNISELA1553';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
// Проверяем наличие пользователя в базе

   
    $con = new mysqli($config['db_host'], 
                     $config['db_user'], 
                     $config['db_pass'], 
                     $config['db_name']);
    $count = 0;
    $result = $con->query("SELECT count(email) as em FROM users WHERE email like '". $_POST['email'] . "';");
    if($result) $count  = $result->fetch_array()['em'];
    //echo "В результате запроса получено значение: ". $count . "; <br>";
    mysqli_close($con);

if ($count > 0 ) {
    $to      = $_POST['email'];
    $subject = 'Восстановление пароля';
    $pass = randomPassword();
    $passHash = password_hash($pass, PASSWORD_DEFAULT);
    $message = 'Здравствуйте! Ваш новый пароль: ' . $pass . ' ';
    $headers = 'From: no-reply@archive.derevni-sela.ru' . "\r\n" .
        'Reply-To: no-reply@archive.derevni-sela.ru' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    
    
    // Сохраняем хэш пароля в базу
    $con = new mysqli($config['db_host'], 
                 $config['db_user'], 
                 $config['db_pass'], 
                 $config['db_name']);
    $upd_res = $con->query("UPDATE users SET pass='" . $passHash . "' WHERE email like '". $_POST['email'] . "';");
    if ($upd_res){ 
        echo 'Новый пароль сохранён <br>';
        mail($to, $subject, $message, $headers);
        echo "Письмо с новым паролем отправлено на вашу почту (проверьте спам)". $to;}
    else {
        echo('Пароль не удалось сохранить в базе :( <br>');
    }
    mysqli_close($con);
}else{
    echo "Такой почты не зарегистрировано! <a href='lostpassword.php'>Ввести ещё раз</>";
}


?>

