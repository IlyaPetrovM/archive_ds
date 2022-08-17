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
                      <input id=srch class="form-control me-2" type="search" placeholder="Введите фразу" value=''>
                      <button class="btn btn-outline-success" onclick="query()">Поиск</button>
                    </div>
                </div>
              </nav>
           </div>
           <div class=row>
                <div id="example-table" class="col"></div>
                <!--<div class="col-sm-2">Предпросмотр</div>-->
             </div>
        </div>
</body>
    
    
   <script>
       srch.addEventListener('keydown', function(e){ if (e.code == 'Enter') srch.blur(), query();  });
    
      var table = new Tabulator("#example-table", {
         height:"calc(100% - 120px)",
         layout:"fitColumns",
         placeholder:"Введите фразу для поиска",
         autoColumns:true,
         ajaxConfig:"POST", //ajax HTTP request type
         ajaxContentType:"json",
         
      });
    var search_str = '';
   
      function query(str) {
        search_str = srch.value;
         var quer = "(SELECT `f`.`id` AS `id` , 'files' AS `Таблица`, f.path,  CAST(`f`.`date_created` AS CHAR(255) CHARSET utf8mb4) AS `Время начала`, f.tags As `Описание файла`, ' ' AS `Описание` , f.`кто загрузил` " + 
                        " FROM `files_ext` as `f` " + 
                        " WHERE `f`.`tags` LIKE '%" + search_str + "%' OR `f`.`Информанты` LIKE '%" + search_str + "%') " + 
                    " UNION ALL " + 
                    " (SELECT `fs`.`id` AS `id`, 'marks' AS `Таблица`, fs.path, `m`.`start_time` AS `start_time`, fs.tags,`m`.`describtion` AS `describtion`, fs.`кто загрузил` " +
                        " FROM `marks` as `m` " + 
                        " LEFT JOIN files as fs ON  (fs.id = m.file_id) WHERE `m`.`describtion` LIKE '%" + search_str + "%' OR `m`.`tags` LIKE '%" + search_str + "%') ";
         table.setData("server/sqlClient.php?q="+quer);
      }
   </script>
</html>
