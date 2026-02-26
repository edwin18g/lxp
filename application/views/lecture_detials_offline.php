<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php /** @package WordPress @subpackage Default_Theme  **/
header("Access-Control-Allow-Origin: *"); 
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.10/plyr.css" />
 
  </head>
  <body>
<div class="container-fluid">
  <div class="row">
<div class="col-md-9  p-0" >
  
   
	<?php if($lecture['cl_type']  == '3'):?>

 <div class="preivew-area  text-center">
          <!--<button >click to download</button>       -->
<video id="player"  height="100%" playsinline controls >
  
  <!--<source src="https://drive.google.com/uc?export=download&id=1KBH6EiFBn4-lYaNGA9Y4YrKOU-NIbAKf" type="video/webm" />-->
           


</video>
  </div>
  <script>
  	 var __file='';
     var videoFile ='<?php echo $lecture['cl_file_name'] ?>';
  </script>
  <!--<script src="<?php echo base_url('themes/default/plyr/plyr.js')?>"></script>-->
  <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
  <script type="text/javascript">
   
    
    function getId(url) {
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        var match = url.match(regExp);

        if (match && match[2].length == 11) {
            return match[2];
        } else {
            return 'error';
        }
    }

    var videoId = getId(videoFile);

    const player = new Plyr('#player',{'settings':['captions', 'quality', 'speed', 'loop']});
    
    // if(videoId){
    //     player.source = {
    //         type: 'video',
    //         sources: [{
    //             src: videoId, // From the YouTube video link
    //             provider: 'youtube',
    //         },],
    //     };
    // }
    

    /*
    YouTube video link
    https://www.youtube.com/watch?v=aqz-KE-bpKQ
    */
</script>

<?php else:?>
<div class="responsive-container" id="lec_content"><span id="loading">loading....</span></div>
<?php endif;?>
</div>
<div class="col-md-3" style="padding: 0px;height: calc(100vh);background: #f8f8f8;box-shadow: 1px 5px 6px 0px;overflow-y: auto;">
    <ul class="list-group" id="lectures">
    <?php
    if(!empty($all_leture)): foreach($all_leture as $lecture_key=>$lecture):?>
    <li class="list-group-item d-flex justify-content-between  ">
      <a href="<?php echo base_url('courses/lecture/'.$lecture['cl_course_id'].'/'.$lecture['id'])?>"><?php echo $lecture['cl_name']?></a>
    <span style="cursor: pointer;"  onclick="getVideoFile('https://cors-escape.herokuapp.com/https://drive.google.com/uc?export=download&id=1_r44WYWppadlEpaZbf7cGEAfcAj3JV2k')"><svg xmlns="http://www.w3.org/2000/svg"  id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" style=" height: 25px;width: 25px;"><g><path d="m38.938 309.499v-37.499h-15v37.499c0 12.406 10.094 22.5 22.5 22.5h209.064v-15h-209.063c-4.136 0-7.501-3.364-7.501-7.5z"/><path d="m38.938 22.5c0-4.136 3.365-7.5 7.5-7.5h41.249v-15h-41.248c-12.407 0-22.5 10.094-22.5 22.5v234.499h15v-234.499z"/><path d="m370.94 22.5v99.749h15v-99.749c0-12.406-10.094-22.5-22.5-22.5h-260.752v15h260.752c4.135 0 7.5 3.364 7.5 7.5z"/><path d="m488.062 316.999h-42.122v-37.499h-15v52.499h21.504l-74.004 75.766-74.003-75.766h21.503v-179.751h105v112.251h15v-127.251h-135v179.751h-42.121l109.621 112.232z"/><path d="m385.941 467h76.811v30h-168.624v-30h76.812v-15h-91.812v60h198.624v-60h-91.811z"/><path d="m340.94 60h15v45h-15z"/><path d="m340.94 30h15v15h-15z"/><path d="m400.94 197.248h15v45h-15z"/><path d="m400.94 167.248h15v15h-15z"/><path d="m83.938 286.999h15v15h-15z"/><path d="m53.938 286.999h15v15h-15z"/><path d="m277.313 166-137.624-82.218v164.435zm-122.624-55.784 93.376 55.784-93.376 55.783z"/><path d="m355.94 316.999h15v15h-15z"/><path d="m385.94 316.999h15v15h-15z"/><path d="m169.689 158.5h15v15h-15z"/></g></svg></span></li> 
    <?php endforeach; 
    
    else: ?>
    <li class="list-group-item">No lecture Found!</li>
    <?php endif;?>
   
  
	  </ul>
	
</div>


</div>
</div>
  
<script type="text/javascript">
    
    
 
    window.indexedDB = window.indexedDB || window.webkitIndexedDB ||
                       window.mozIndexedDB || window.OIndexedDB || 
                       window.msIndexedDB;
                         
    var IDBTransaction = window.IDBTransaction || 
                         window.webkitIDBTransaction || 
                         window.OIDBTransaction || 
                         window.msIDBTransaction;
                           
    var dbVersion = 1.0; 
    var indexedDB = window.indexedDB;
    var dlStatusText = document.getElementById("fetchstatus");
  
    // Create/open database
    var request = indexedDB.open("VideoFiles", dbVersion),
       db,
       createObjectStore = function (dataBase) {
           dataBase.createObjectStore("Videos");
       }
  
  
         

        function getVideoFile(Url) {
          var xhr = new XMLHttpRequest(),
          blob;
          // Get the Video file from the server.
          xhr.open("GET", Url, true);     
          xhr.responseType = "blob";
          xhr.addEventListener("load", function () {
             if (xhr.status === 200) {
                 blob = xhr.response;
                 putVideoInDb(blob);
                 dlStatusText.innerHTML = "SUCCESS: Video file downloaded.";
             }
             else {
                 dlStatusText.innerHTML = "ERROR: Unable to download video.";
             }
           }, false);
            xhr.addEventListener("progress", function (evt) {
        if(evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total;
            console.log(percentComplete);
        }
    }, false);
           xhr.send();
       }
  
       putVideoInDb = function (blob) {
          var transaction = db.transaction(["Videos"], "readwrite");
          var put = transaction.objectStore("Videos").put(blob, "savedvideo");
       };
  
  
     request.onerror = function (event) {
         console.log("Error creating/accessing IndexedDB database");
     };
  
     request.onsuccess = function (event) {
         console.log("Success creating/accessing IndexedDB database");
         db = request.result;
         
          // Open a transaction to the database
        var transaction = db.transaction(["Videos"], "readwrite");
 
        // Retrieve the video file
        transaction.objectStore("Videos").get("savedvideo").onsuccess = 
        function (event) {
                 
        var videoFile = event.target.result;
        var URL = window.URL || window.webkitURL;
        var videoURL = URL.createObjectURL(videoFile);
 
        // Set video src to ObjectURL
        var videoElement = document.getElementById("player");
            videoElement.setAttribute("src", videoURL);
 
       var mimeDisplayElement = document.getElementById("vidMimeDisplay");
           mimeDisplayElement.innerHTML = videoFile.type;
        };
  
         db.onerror = function (event) {
             console.log("Error creating/accessing IndexedDB database");
         };
          
         
         
     }
      
     // For future use. Currently only in latest Firefox versions
     request.onupgradeneeded = function (event) {
         createObjectStore(event.target.result);
     };
      
      
      function getIdDriveUel(url) {
  var id = "";
  var parts = url.split(/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?/);
  if (url.indexOf('?id=') >= 0){
     id = (parts[6].split("=")[1]).replace("&usp","");
     return id;
   } else {
   id = parts[5].split("/");
   //Using sort to get the id as it is the longest element. 
   var sortArr = id.sort(function(a,b){return b.length - a.length});
   id = sortArr[0];
   return id;
   }
 }
      
      console.log(getIdDriveUel('https://drive.google.com/file/d/1KBH6EiFBn4-lYaNGA9Y4YrKOU-NIbAKf/view'));
      
    //   getVideoFile('https://drive.google.com/uc?export=download&id=1KBH6EiFBn4-lYaNGA9Y4YrKOU-NIbAKf');

</script>




  
<script type="text/javascript">
    
    
 
    window.indexedDB = window.indexedDB || window.webkitIndexedDB ||
                       window.mozIndexedDB || window.OIndexedDB || 
                       window.msIndexedDB;
                         
    var IDBTransaction = window.IDBTransaction || 
                         window.webkitIDBTransaction || 
                         window.OIDBTransaction || 
                         window.msIDBTransaction;
                           
    var dbVersion = 1.0; 
    var indexedDB = window.indexedDB;
    var dlStatusText = document.getElementById("fetchstatus");
  
    // Create/open database
    var request = indexedDB.open("VideoFiles", dbVersion),
       db,
       createObjectStore = function (dataBase) {
           dataBase.createObjectStore("Videos");
       }
  
  
         

        function getVideoFile(Url) {
          var xhr = new XMLHttpRequest(),
          blob;
          // Get the Video file from the server.
          xhr.open("GET", Url, true);     
          xhr.responseType = "blob";
          xhr.addEventListener("load", function () {
             if (xhr.status === 200) {
                 blob = xhr.response;
                 putVideoInDb(blob);
                 dlStatusText.innerHTML = "SUCCESS: Video file downloaded.";
             }
             else {
                 dlStatusText.innerHTML = "ERROR: Unable to download video.";
             }
           }, false);
            xhr.addEventListener("progress", function (evt) {
        if(evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total;
            console.log(percentComplete);
        }
    }, false);
           xhr.send();
       }
  
       putVideoInDb = function (blob) {
          var transaction = db.transaction(["Videos"], "readwrite");
          var put = transaction.objectStore("Videos").put(blob, "savedvideo");
       };
  
  
     request.onerror = function (event) {
         console.log("Error creating/accessing IndexedDB database");
     };
  
     request.onsuccess = function (event) {
         console.log("Success creating/accessing IndexedDB database");
         db = request.result;
         
          // Open a transaction to the database
        var transaction = db.transaction(["Videos"], "readwrite");
 
        // Retrieve the video file
        transaction.objectStore("Videos").get("savedvideo").onsuccess = 
        function (event) {
                 
        var videoFile = event.target.result;
        var URL = window.URL || window.webkitURL;
        var videoURL = URL.createObjectURL(videoFile);
 
        // Set video src to ObjectURL
        var videoElement = document.getElementById("player");
            videoElement.setAttribute("src", videoURL);
 
       var mimeDisplayElement = document.getElementById("vidMimeDisplay");
           mimeDisplayElement.innerHTML = videoFile.type;
        };
  
         db.onerror = function (event) {
             console.log("Error creating/accessing IndexedDB database");
         };
          
         
         
     }
      
     // For future use. Currently only in latest Firefox versions
     request.onupgradeneeded = function (event) {
         createObjectStore(event.target.result);
     };
      
      
      function getIdDriveUel(url) {
  var id = "";
  var parts = url.split(/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?/);
  if (url.indexOf('?id=') >= 0){
     id = (parts[6].split("=")[1]).replace("&usp","");
     return id;
   } else {
   id = parts[5].split("/");
   //Using sort to get the id as it is the longest element. 
   var sortArr = id.sort(function(a,b){return b.length - a.length});
   id = sortArr[0];
   return id;
   }
 }
      
      console.log(getIdDriveUel('https://drive.google.com/file/d/1KBH6EiFBn4-lYaNGA9Y4YrKOU-NIbAKf/view'));
      
    //   getVideoFile('https://drive.google.com/uc?export=download&id=1KBH6EiFBn4-lYaNGA9Y4YrKOU-NIbAKf');

</script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>








