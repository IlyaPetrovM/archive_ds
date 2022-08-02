<?php require_once __DIR__.'/boot.php'; 
   if (!check_auth()) { 
      header('Location: login.php');
   }
?>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link href="dist/css/tabulator.min.css" rel="stylesheet">
   <script type="text/javascript" src="dist/js/tabulator.min.js"></script>

</head>
<body> 
<div class="container-fluid">
      <div class=row>
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
             <div class="container-fluid">
               <a class="navbar-brand">Архив экспедиции</a>
               
               <?php include 'menu.php'; ?> 
               
                <div class="d-flex">
                  <!--<input id=srch class="form-control me-2" type="search" placeholder="Введите фразу" value=''>-->
                  <button class="btn btn-outline-success" onclick="query()">Поиск</button>
                </div>
            </div>
          </nav>
       </div>
       <div class=row>
            <div id="example-table" class="col"></div>
            <!--<div class="col-sm-2">Предпросмотр</div>-->
         </div>
</body>
    
    
   <script>
   
      var table = new Tabulator("#example-table", {
         height:"calc(100% - 120px)",
         layout:"fitColumns",
         placeholder:"No Data Set",
         autoColumns:true,
         ajaxConfig:"POST", //ajax HTTP request type
         ajaxContentType:"json",
         
      });
    var quer = 'SELECT * FROM informants ORDER BY last_name ASC;';
      function query(str) {
         table.setData("server/sqlClient.php?q="+quer);
      }
      
      
   </script>
</html>
