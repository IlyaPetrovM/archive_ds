<?php

require_once __DIR__.'/boot.php';


?>

<html>
<head>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> 
   <link href="dist/css/tabulator.min.css" rel="stylesheet">
   <script type="text/javascript" src="dist/js/tabulator.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.0.1/build/global/luxon.min.js"></script>

</head>
<body class=container> 
   
   <h1 class="mb-3">Вход</h1>

   <form method="post" action="do_login.php" >

       <div  class="mb-3">
           <label for="username" class="form-label">e-mail</label>
           <input id="username" type="text" class="form-control"  name="username" required>
       </div>
       <div  class="mb-3">
           <label for="password" class="form-label">Пароль</label>
           <input id="password" type="password" class="form-control"  name="password" required>
       </div>
       <div class="d-flex justify-content-between">
           <button type="submit" class="btn btn-primary">Войти</button>
           <a class="btn btn-outline-primary" href="lostpassword.php">Я забыл(а) пароль</a>
       </div>
       
   </form>
   
   
</body>
</html>