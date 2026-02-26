<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<header><nav class="navbar navbar-default" style="margin:0px">
  <div class="container-fluid">
    <div class="" style="    display: flex;
    
    align-items: start;
    font-weight: 300;
    height: 100%;">
   
    <a class="navbar-brand" href="<?php echo site_url(''); ?>" style="align-self: center;
    margin: 0 24px 0 0;">
        <img alt="Universh"  src="<?php echo base_url('upload/institute/logo.png') ?>" style="    border: 0;
    vertical-align: middle;
    max-width: 100px;
    height: auto;">
      </a>
      <a class="navbar-brand" href="<?php echo site_url('courses/my_courses'); ?>" style="align-self: center;
    margin: 0 24px 0 0;"><i class="fa fa-undo" aria-hidden="true"></i>  MyCourse</a>
    <a class="navbar-brand" href="<?php echo site_url(''); ?>" style="align-self: center;
    margin: 0 24px 0 0;"><?=$course_detail->title?></a>
    
    
    </div>
  </div>
  
</nav></header>
<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3  sidebar" style="margin:0px;padding:0px">
        <img src="<?=(!empty($this->meta_image))?$this->meta_image:'http://www.ibcs-primax.com/education/wp-content/uploads/2017/08/big_data_hadoop.jpg'?>"   width="100%" class="image-responsive"/>
          
            <ul class="nav nav-sidebar">
            
         <li style="text-align: center;
    padding: 7px 5px;
    text-transform: uppercase;
    background: #f7f7f7;">  <h6 style="margin: 0px;">Course Contents</h6></li>
 
							<?php if(!empty($course_lectue)): 
								
								foreach($course_lectue as $key => $lecture):
								
								?>
								<li><a href="<?=($this->session->userdata('logged_in'))?base_url('courses/course_board/'.$lecture['cl_course_id'].'#'.$lecture['id']):'#'?>"><span><i class="fa fa-play"></i> </span><?=" ".$lecture['cl_name']?> </a></li>
								<?php endforeach; endif;  ?>
								
          </ul>
       
        
       
        
          
         
        </div>
        <div class="col-sm-9  main" id="content_block" style="    min-height: 600px;
    margin: 0px;
    padding: 0px;
    background: black;color:#ffff;">
          
<div style="text-align: center;
    padding: 120px 1px;"> <h3 style="color:#ffff;">Course Content Not available</h3> </div>
          

         
        </div>
      </div>
    </div>


    <script>
    var course_id   = uri_seg_3;
    var admin_url = '<?php echo site_url();?>'; 
    var url = ''; 
    var keyword = null; 
    var slug = ''; 
    var currentRequest = null; 
    function router () { 
      url             = location.hash.slice(1) || '/';	
      if(url != '/')
      {
        $('#content_block').html('loading... '); 
        currentRequest  =	$.ajax(
                            { url: site_url+'courses/content_course', 
                              type: "POST", 
                              data: {'id':course_id,'content_id':url,'finger':fingerprint,'csrf_token':csrf_token}, 
                              beforeSend : function() { 
                                if(currentRequest != null) { 
                                  currentRequest.abort(); 
                                  } 
                                }, 
                              success: function(response){	
                              
                                
                                  $('#content_block').html(response); 
                             
                               
                                } 
                              }); 
      }
     
                        } 
    
      window.addEventListener('hashchange', router); 
      window.addEventListener('load', router); </script>