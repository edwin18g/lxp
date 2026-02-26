<?php defined('BASEPATH') OR exit('No direct script access allowed');

?>

<html>
  <head>
  <title>Bootstrap 4 Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
   <script type="text/javascript" charset="utf-8" src="https://cdn.jsdelivr.net/clappr/latest/clappr.min.js"></script>
    
    <script type="text/javascript" charset="utf-8" src="<?=base_url('themes/default/js/clappr-youtube-plugin.js')?>"></script>
   
    <script type="text/javascript" charset="utf-8" src="<?=base_url('themes/default/js/main.js')?>"></script>
    <script type="text/javascript" charset="utf-8" src="https://cdn.jsdelivr.net/ace/1.2.6/min/ace.js"></script>
   <!-- Compiled and minified CSS -->
   
</head>


        

<script>
      window.clappr = window.clappr || {}
      window.clappr.externals = []

      function addExternal() {
        var url = document.getElementById('js-link')
        window.clappr.externals.push(url.value)
        addTag(url.value)
        url.value = ''
      }

      function addTag(url) {
        var colors = ["aliceblue", "antiquewhite", "azure", "black", "blue", "brown", "yellow", "teal"]
        var color = colors[Math.floor(Math.random() * colors.length)]
        var span = document.createElement('span')

        span.style.backgroundColor = color
        span.className = "external-js"
        span.innerText = url.split(/\//).pop().split(/\./)[0]

        document.getElementById('external-js-panel').appendChild(span)
      }
      
      function getId(url) {
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        var match = url.match(regExp);

        if (match && match[2].length == 11) {
            return match[2];
        } else {
            return 'error';
        }
    }
 var __file='';
     var videoFile ='<?php echo $lecture['cl_file_name'] ?>';
 
    var videoId = getId(videoFile);
    </script>



<body>
 <style>
.player-poster[data-poster] .play-wrapper[data-poster] svg {
    height: 50px !important;
}

.page-header {
display: flex;
    align-items: center;
    background-color: #ffffff;
    padding: 10px 50px;
    position: relative;
    margin: 0;
    border: none;
    -webkit-box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);
    -moz-box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);
    -ms-box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);
    -o-box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);
    box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);
    height: 52px;
    overflow: hidden;
    position: absolute;
    z-index: 1000;
}
.responsive-container {
position:relative;
padding-bottom:56.25%;
padding-top:30px;
height:0;
overflow:hidden;
}
.list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
    z-index: 2;
    color: #383838 !important;
    background-color: #a8c4eb;
    border-color: cornsilk;
    border-left: 2px solid #ffffff;
    border-right: 2px solid #1f275a;
    background-image: linear-gradient(to right, #ffffff , #9694ff);
    box-shadow: -2px 0px 6px 0px #4c49499c;
}
a, a:hover, a:focus, a.active, .typo-dark h1 a:hover, .typo-dark h1 a:focus, .typo-dark h1 a.active, .typo-dark h2 a:hover, .typo-dark h2 a:focus, .typo-dark h2 a.active, .typo-dark h3 a:hover, .typo-dark h3 a:focus, .typo-dark h3 a.active, .typo-dark h4 a:hover, .typo-dark h4 a:focus, .typo-dark h4 a.active, .typo-dark h5 a:hover, .typo-dark h5 a:focus, .typo-dark h5 a.active, .typo-dark h6 a:hover, .typo-dark h6 a:focus, .typo-dark h6 a.active, .typo-light h1 a:hover, .typo-light h1 a:focus, .typo-light h1 a.active, .typo-light h2 a:hover, .typo-light h2 a:focus, .typo-light h2 a.active, .typo-light h3 a:hover, .typo-light h3 a:focus, .typo-light h3 a.active, .typo-light h4 a:hover, .typo-light h4 a:focus, .typo-light h4 a.active, .typo-light h5 a:hover, .typo-light h5 a:focus, .typo-light h5 a.active, .typo-light h6 a:hover, .typo-light h6 a:focus, .typo-light h6 a.active {
    color: #000000;
}
.responsive-container iframe, .responsive-container object, .responsive-container embed {
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
}
.preivew-area {
	background: #000;
    height: calc(100vh);
}

.meida-block {
    padding:0px;    margin: 0;
    height: 100vh;
    overflow: hidden;
}
.aside-group{
  height: 100vh;
    overflow: auto;
    padding: 64px 0px 0px 0px;
}

 @media (max-width: 480px) { 
           .meida-block {
    padding:0px;    margin: 0;
    height: 250px;
    overflow: hidden;
}
.preivew-area {
    background: #000;
    height: 250px;
    position: fixed;
    width: 100%;
}

.page-header {display:none;}
        } 
        
         @media (min-width: 480px) and (max-width: 768px) { 
           .meida-block {
    padding:0px;    margin: 0;
    height: 400px;
    overflow: hidden;
}
.preivew-area {
    background: #000;
    height: 400px;
    position: fixed;
    width: 100%;
}

.page-header {display:none;}
        } 
          

</style>
<div class="container-fluid">
  
   <div class="row">
        <div class="col-sm-12 page-header">     <a href="<?php echo site_url(''); ?>">
                <img alt="Universh"  src="<?php echo base_url('upload/institute/logo.png') ?>" style="    height: 30px;">
            </a>
          
        <span style="padding-left:15px"><i class="fa fa-file-video-o" aria-hidden="true"></i>  </span>
        <span style="padding-left:15px">  <?php echo $lecture['cl_name'] ?></span>
        </div>

        
        
      <div class="col-sm-9 meida-block">   	<?php if($lecture['cl_type']  == '3'):?>
<div id="output">
 <div id="player-wrapper" class="player"></div>  
</div>
  

<?php else:?>
<div class="responsive-container" id="lec_content"><span id="loading">loading....</span></div>
<?php endif;?>
        </div>
      <div class="col-sm-3 aside-group"> 
      
      <ul class="list-group">
          <?php
    if(!empty($all_leture)): foreach($all_leture as $lecture_key=>$lecture):?>
    
   
    <li class="list-group-item <?php echo ($this->active_lecture == $lecture['id'] )?'active':''?> "><a href="<?php echo base_url('courses/lecture/'.$lecture['cl_course_id'].'/'.$lecture['id'])?>"><?php echo $lecture['cl_name']?></a></li> 
    <?php endforeach; 
    
          else: ?>
      <li class="list-group-item">No lecture Found!</li>
         <?php endif;?>
    
    </ul>
    
     </div>
   
    </div>

       

 <script>
      var urlParams;
      (function() {
        window.onpopstate = function () {
          var match,
              pl     = /\+/g,  // Regex for replacing addition symbol with a space
              search = /([^&=]+)=?([^&]*)/g,
              decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
              query  = window.location.search.substring(1);

          urlParams = {};
          while (match = search.exec(query))
            urlParams[decode(match[1])] = decode(match[2]);
        }
        window.onpopstate();
      })();
      //Clappr.Log.level(Clappr.Log.LEVEL_DEBUG);
      //Clappr.Log.setLevel(0);
      var playerElement = document.getElementById("player-wrapper");
var vid = videoId;
//var vid = 'huXO_YPwgdw'; // nettv
var player = new Clappr.Player({
  
  source: vid,
  poster: 'https://i.ytimg.com/vi/'+vid+'/hqdefault.jpg',

  height: '100%',
  width: '100%',
  autoPlay:true,
  //plugins: [YoutubePlugin],
  plugins: [YoutubePlugin],
 
  //plugins: [YoutubePluginControl],
  languageCode: 'en'
});

player.attachTo(playerElement);

      //editor
      window.onload = function() {
        var editor = ace.edit("editor");
        var session = editor.getSession();

        editor.setTheme("ace/theme/katzenmilch");
        session.setMode("ace/mode/javascript");
        session.setTabSize(2);
        session.setUseSoftTabs(true);

        var parser = new Parser($('#output'));
        var load = function(fn) {
          if (window.clappr.externals.length > 0) {
            var lastScript = window.clappr.externals.length
            window.clappr.externals.forEach(function(url, index) {
	      var script = document.createElement('script')

	      script.setAttribute("type", "text/javascript")
	      script.setAttribute("src", url)
              if (index === (lastScript - 1)) {
		script.onload = fn
              }
	      script.onerror = function(e){alert('we cant load ' + url + ': e' + e)}

	      document.body.appendChild(script)
            })
	  } else {
	    fn()
          }
        }

        $('.run').click(function() {
          var code = ace.edit('editor').getSession().getValue();
          load(function(){parser.parse(code)})
        });
      }
      
      
       
    </script>
    </body>
</html>

 








  




