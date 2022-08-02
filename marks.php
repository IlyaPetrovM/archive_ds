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
               <a class="navbar-brand">Архив экспедиции - Опись</a>
               
               <?php include 'menu.php'; ?> 
               
                <div class="d-flex">
                  <!--<input id=srch class="form-control me-2" type="search" placeholder="Введите фразу" value=''>-->
                  <!--<button class="btn btn-outline-success" onclick="query()">Обновить</button>-->
                </div>
            </div>
          </nav>
       </div>
       <div class=row>
            <div class="col-sm-6 order-sm-last">
               <img hidden id=previewImg style="width:100%;" class="embed-responsive embed-responsive-16by9" />
               <video hidden id=previewVideo style="width:100%;" class="embed-responsive embed-responsive-16by9" controls></video>
               <iframe hidden id=previewIframe style="width:100%; height:100%;" class="embed-responsive embed-responsive-16by9" ></iframe>
            </div>
            <div class="col-sm-6 ">
               <div id="example-table" ></div>
            </div>
         </div>
</body>
    
    
   <script>
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
    * Возвращает путь на обльшой файл или на прокси, в зависимости от наличия прокси.
    */
    function getFilePath(filename){
        const proxyFolder = 'https://archive.derevni-sela.ru/uploads/proxy/';
        const cloudFolder = 'https://archive.derevni-sela.ru/uploads/';
     
        if (fileExists(proxyFolder + filename)) {return proxyFolder + filename;}
        return cloudFolder + filename;
    }
       
   /**
   * Определяем расширение файла
   */
   function getUrlExtention( url ) {
      return url.split(/[#?]/)[0].split('.').pop().trim().toLowerCase();
   }
      
   /**
   * MAIN
   */
   var file_id = <?php echo $_GET['file_id'];?>;
   var http = new XMLHttpRequest();
    var q = 'SELECT path FROM files WHERE id ='+file_id;
    http.open('GET', "server/sqlClient.php?q="+q);
    http.send();
    http.onload = function(res){
       let fname = JSON.parse(http.response);
       let path = getFilePath(fname[0]['path'].replace(/^.*[\\\/]/, ''));
       
       let ext = getUrlExtention(path);
       console.log(ext);
       switch(ext){
          case 'mkv':
          case 'mov':
          case 'wav':
          case 'aac':
          case 'mp3':
          case 'mp4': 
            previewVideo.src = path; 
            previewVideo.hidden = false;
            break;
          case 'gif':
          case 'bmp':
          case 'svg':
          case 'png':
          case 'tif':
          case 'jpg':
            previewImg.src = path;
            previewImg.hidden = false;
            break;
          default:
            previewIframe.src = path;
            previewIframe.hidden = false;
       } 
       
    };
   
    
    var quer = `SELECT start_time, tags, describtion FROM marks WHERE file_id=${file_id};`;
      var table = new Tabulator("#example-table", {
         height:"800px",
         layout:"fitColumns",
         placeholder:"Обновите таблицу",
         //autoColumns:true,
         ajaxConfig:"POST", //ajax HTTP request type
         ajaxContentType:"json",
         ajaxURL:"server/sqlClient.php?q="+quer,
         columns:[
             {title:"Время", field:"start_time", width:"80", 
             cellClick: 
               function(e, cell){
                   let timeStr = cell.getRow().getData().start_time;
                   let timeSec = 0;
                   let timeArr = timeStr.split(':');
                   timeSec = (parseInt(timeArr[0])*60*60 + parseInt(timeArr[1])*60 + parseInt(timeArr[2]));
                   console.log("Посмотреть: ", timeArr, timeSec); 
                   previewVideo.currentTime = timeSec;
                   previewVideo.play();
               },
             formatter:
               function(cell){
                  return '<button class="btn btn-outline-secondary btn-sm">'+cell.getValue()+' </button>'
               }
             },
             {title:"Тэги", field:"tags", widthGrow:1, formatter:"textarea"},
             {title:"Описание", field:"describtion", widthGrow:2, formatter:"textarea"},
         ]
      });
     

   </script>
</html>
