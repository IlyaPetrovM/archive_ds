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
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.0.1/build/global/luxon.min.js"></script>

</head>
<body> 
   <div class="container-fluid">
      <div class=row>
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
             <div class="container-fluid">
               <a class="navbar-brand">Архив экспедиции - Файлы</a>
               
               <?php include 'menu.php'; ?> 
               
                <div class="d-flex">
                  <input id=srch class="form-control me-2" type="search" placeholder="Введите фразу" value=''>
                  <button class="btn btn-outline-success" onclick="query()">Поиск</button>
                </div>
            </div>
          </nav>
       </div>
       <div class=row>
     
            <div  class="col">
               <div id="example-table" class="embed-responsive embed-responsive-16by9">
            </div>
         </div>
    </div>
</body>
    
    
   <script>
   const icon_download = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path fill-rule="evenodd" d="M7.47 10.78a.75.75 0 001.06 0l3.75-3.75a.75.75 0 00-1.06-1.06L8.75 8.44V1.75a.75.75 0 00-1.5 0v6.69L4.78 5.97a.75.75 0 00-1.06 1.06l3.75 3.75zM3.75 13a.75.75 0 000 1.5h8.5a.75.75 0 000-1.5h-8.5z"></path></svg>';
   
   const icon_comment = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path fill-rule="evenodd" d="M16 1.25v4.146a.25.25 0 01-.427.177L14.03 4.03l-3.75 3.75a.75.75 0 11-1.06-1.06l3.75-3.75-1.543-1.543A.25.25 0 0111.604 1h4.146a.25.25 0 01.25.25zM2.75 3.5a.25.25 0 00-.25.25v7.5c0 .138.112.25.25.25h2a.75.75 0 01.75.75v2.19l2.72-2.72a.75.75 0 01.53-.22h4.5a.25.25 0 00.25-.25v-2.5a.75.75 0 111.5 0v2.5A1.75 1.75 0 0113.25 13H9.06l-2.573 2.573A1.457 1.457 0 014 14.543V13H2.75A1.75 1.75 0 011 11.25v-7.5C1 2.784 1.784 2 2.75 2h5.5a.75.75 0 010 1.5h-5.5z"></path></svg>';
   
       /**
       *
       */
        function fileExists(url) {
            var http = new XMLHttpRequest();
           
            if (url.length === 0) {
                return false;
            } else {
                try{
                http.open('HEAD', url,false);
                http.send();
                return (http.status === 200);
                }catch(e){
                    console.log(e);
                    return (http.status === 200);
                }
            }
            return false;
        }
        
        /**
       *
       */
       function getFilePath(filename){
           const proxyFolder = 'https://archive.derevni-sela.ru/uploads/proxy/';
           const cloudFolder = 'https://archive.derevni-sela.ru/uploads/';
        
           if (fileExists(proxyFolder + filename)) {return proxyFolder + filename;}
           return cloudFolder + filename;
       }
       
       /**
       *
       */
       function openFile(event, name){
           //getFilePath
           window.open(getFilePath(name),"_blank");
          //previewVideo.src = getFilePath(name);
           event.stopPropagation();
           console.log(event,name);
       }
       
      /**
       * MAIN CODE
       */
      var quer1 = "SELECT f.id AS id, f.path AS path, f.tags AS tags," +
               "GROUP_CONCAT( CONCAT( inf.last_name,' ', inf.first_name,' ', inf.middle_name ) separator '; ') AS informants, "+
               "GROUP_CONCAT( m.describtion separator '; ' ) AS marks, " +
               "f.`оператор` AS author, " +
               "f.date_created AS `date_created`, f.date_updated AS date_updated, " +
               "f.old_filename AS old_filename, "+
               "f.`кто загрузил` AS who_created"+
           " FROM ((( files f " +
                       " LEFT JOIN files_to_informants AS conn ON (conn.file_id = f.id) ) " +
                       " LEFT JOIN informants `inf` ON (conn.inf_id = inf.id)) "+
                       " LEFT JOIN marks m ON (m.file_id = f.id) ) "+
            " GROUP BY f.id "+
           " ORDER BY  f.id DESC";
      var table = new Tabulator("#example-table", {
         height:"800px",
         layout:"fitColumns",
         placeholder:"Введите поисковую фразу",
         ajaxURL:"server/sqlClient.php?q="+quer1,
         ajaxConfig:"POST", //ajax HTTP request type
         ajaxParams:{"q": quer1},
         ajaxContentType:"json",
         layout:"fitColumns",
           columns:[
              {formatter:function(){return icon_download;}, 
                  width:"20", 
                  hozAlign:"center",  
                     cellClick:function(e, cell){ 
                        openFile(e, cell.getRow().getData().path.replace(/^.*[\\\/]/, ''));
                        console.log("Посмотреть",cell.getRow().getData()); 
                     } 
               },
               {title:"Опись по времени", field:"marks",  width:'20', hozAlign:"center",
                     formatter:function(){return icon_comment;}, 
                     cellClick:function(e, cell){ 
                        console.log("Опись", cell.getRow().getData()); 
                        window.open('marks.php?file_id='+cell.getRow().getData().id);
                      }
               },
               {title:"id", field:"id", width:"100", formatter:"plaintext", hozAlign:"center" },
               {title:"Путь", field:"path", formatter:"plaintext", hozAlign:"right" },
               {title:"Тэги", field:"tags", formatter:"textarea"},
               {title:"Информанты", field:"informants",  formatter:"plaintext"},
               {title:"Оператор", field:"author", formatter:"plaintext"},
               {title:"Дата создания", field:"date_created", width:"100",  hozAlign:"center",  formatter:"datetime", formatterParams:{ outputFormat:"dd MMM HH:mm"}},
               {title:"Дата редактирования", field:"date_updated", width:"100",   hozAlign:"center", formatter:"datetime", formatterParams:{ outputFormat:"dd MMM HH:mm"}},
               {title:"Старое название", field:"old_filename",   formatter:"plaintext"},
               {title:"Кто загрузил", field:"who_created",   formatter:"plaintext"},
               {formatter:"buttonCross", width:"50", hozAlign:"center",  cellClick:function(e, cell){ console.log(cell._cell.row.data); } }
           ]
      });

      function query(str) {
         var having = "";
         if (srch.value != "") {
            having = " HAVING (tags LIKE '%"+srch.value+"%' OR marks LIKE '%"+srch.value+"%' OR informants LIKE '%"+srch.value+"%'  ) ";
         }
        var quer = "SELECT f.id AS id, f.path AS path, f.tags AS tags," +
                        "GROUP_CONCAT( CONCAT( inf.last_name,' ', inf.first_name,' ', inf.middle_name ) separator '; ') AS informants, "+
                        "GROUP_CONCAT( m.describtion separator '; ' ) AS marks, " +
                        "f.`оператор` AS author, " +
                        "f.date_created AS `date_created`, f.date_updated AS date_updated, " +
                        "f.old_filename AS old_filename, "+
                        "f.`кто загрузил` AS who_created"+
                    " FROM ((( files f " +
                                " LEFT JOIN files_to_informants AS conn ON (conn.file_id = f.id) ) " +
                                " LEFT JOIN informants `inf` ON (conn.inf_id = inf.id)) "+
                                " LEFT JOIN marks m ON (m.file_id = f.id) ) "+
                     " GROUP BY f.id "+
                       having +
                    " ORDER BY  f.id DESC";
         table.setData("server/sqlClient.php?q="+quer);
      }
   </script>
</html>
