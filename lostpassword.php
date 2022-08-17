<html>
<head>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> 
   <link href="dist/css/tabulator.min.css" rel="stylesheet">
   <script type="text/javascript" src="dist/js/tabulator.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.0.1/build/global/luxon.min.js"></script>

</head>
<body class=container> 
   
   <h1 class="mb-3">Сброс пароля</h1>

   <form method="post" action="do_resetpass.php" >

       <div  class="mb-3">
           <label for="email" class="form-label">Почта</label>
           <input id="email" type="text" class="form-control"  name="email" required>
       </div>
       <div class="d-flex justify-content-between">
           <button type="submit" class="btn btn-primary">Отправиль новый пароль</button>
           <a class="btn btn-outline-primary" href="index.php">Ой, не то</a>
       </div>
       
   </form>
   
   
</body>
</html>