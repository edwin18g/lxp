<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--<link rel="stylesheet" href="<?php echo base_url('themes/default/plyr/plyr.css') ?>" />-->
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.10/plyr.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<style>


.page-header {
display: flex;
    align-items: center;
    background-color: #110101;
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
    /*height: 100vh;*/
    overflow: hidden;
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
          
body {
    display: block;
    margin:0px !important;
}
</style>

<div class="col-md-9 meida-block" >
    <!--<div class="col-sm-12 page-header"><div class="logo" style="    width: 40%;">-->
    <!--        <a href="< ?php echo site_url(''); ?>">-->
    <!--            <img alt="Universh"  src="< ?php echo base_url('upload/institute/logo.png') ?>" style="    height: 30px;">-->
    <!--        </a>-->
            <!-- <a href="< ? php echo site_url(''); ?>" class="institute-name">
    <!--            < ?php echo $this->settings->site_name; ?>-->
    <!--        </a> -->
    <!--    </div><span style="padding-left:15px"><i class="fa fa-file-video-o" aria-hidden="true"></i>  </span>-->
    <!--    <span style="padding-left:15px">  < ?php echo $lecture['cl_name'] ?></span>-->
    <!--    </div>-->
	<?php if($lecture['cl_type']  == '3'):?>

 <div class="preivew-area  text-center">
                <video id="player" controls height="100%">
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
    if(videoId){
        player.source = {
            type: 'video',
            sources: [{
                src: videoId, // From the YouTube video link
                provider: 'youtube',
            },],
        };
    }
    

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
    <li class="list-group-item <?php echo ($this->active_lecture == $lecture['id'] )?'active':''?> "><a href="<?php echo base_url('courses/lecture/'.$lecture['cl_course_id'].'/'.$lecture['id'])?>"><?php echo $lecture['cl_name']?></a></li> 
    <?php endforeach; 
    
    else: ?>
    <li class="list-group-item">No lecture Found!</li>
    <?php endif;?>
   
  
	  </ul>
	
</div>



  





