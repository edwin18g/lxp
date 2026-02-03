<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

// echo "<pre>"; print_r($my_courses);
?>
<div ></div>
 <!-- Section Slider -->
 <style>
 form.dark .form-control {
    background: none repeat scroll 0 0 #0603036e;
    color: #fff;
}
.btn-radius {
       padding: 8px 12px !important;
}
.d-flex{
        display: flex;
    align-items: center;
    justify-content: space-around;
    flex-wrap: wrap;

}
 </style>





<!-- Section Featured Courses -->
<?php if(! empty($f_courses)) { ?>
<section class="pad-top-none typo-dark">
    <div class="container">
        <!-- Row -->
        <div class="row">
            <!-- Title -->
            <div class="col-sm-12">
                <div class="title-container sm">
                    <div class="title-wrap">
                        <h3 class="title">courses</h3>
                        <span class="separator line-separator"></span>
                    </div>
                </div>
            </div>
            <!-- Title -->
            
            <!-- Column -->
            <?php foreach($f_courses as $key => $val) { ?>
            <div class="col-sm-3 col-xs-6">
                <!-- Course Wrapper -->
                <div class="course-wrapper">
                    
                    <?php 
                    
                    
                    $hide_entroll = true;
                    
                    if(!empty($_SESSION['logged_in']))
                    {
                        if(in_array($val->id, $my_courses))
                        {
                           $go_to_url         = site_url('courses/lecture/'.$val->id);  
                           $hide_entroll      = false;
                        }
                        else
                        {
                            $go_to_url =  site_url('courses/detail/').str_replace(' ', '+', $val->title);        
                        }
                           
                    }
                    else
                    {
                         $go_to_url =  site_url('courses/detail/').str_replace(' ', '+', $val->title);       
                    }
                    
                     
                    
                    ?>
                  
                    <!-- Course Banner Image -->
                    <a href="<?php echo $go_to_url; ?>" title="<?php lang('action_view'); ?>" >
                        <div class="course-banner-wrap ">
                            <img alt="Course" class="img-responsive" src="<?php echo base_url().($val->images ? '/upload/courses/images/'.image_to_thumb(json_decode($val->images)[0]) : 'themes/default/images/course/course-01.jpg') ?>" width="600" height="220">
                            <!-- < ?php if($val->total_recurring) { ?>
                            <span class="cat bg-green">< ?php echo $val->total_recurring.' '.lang('c_l_repetitive_batch'); ?></span>
                            < ?php } elseif($val->starting_price) { ?>
                            <span class="cat bg-blue">< ?php echo lang('c_l_starts_from'); ?> : < ?php echo $val->starting_price.' '.$this->settings->default_currency; ?></span>
                            < ?php } else { ?>
                            <span class="cat bg-yellow">Active</span>
                            < ?php } ?> -->
                        </div><!-- Course Banner Image -->
                    </a>
                    <!-- Course Detail -->
                    <div class="course-detail-wrap">
                        <!-- Course Teacher Detail -->
                        <div class="teacher-wrap hidden">
                            <?php if(empty($val->tutor)) { ?>
                            <img class="img-responsive" src="<?php echo base_url().'themes/default/images/teacher/thumb-teacher-01.jpg' ?>" width="100" height="100">
                            <h5 class=""><small><?php echo lang('action_coming_soon'); ?></small></h5>
                            <?php } 
                            
                            else 
                            
                            { ?>
                            <a href="<?php echo site_url('tutors/').$val->tutor->username ?>">
                                <img alt="<?php echo $val->tutor->first_name.' '.$val->tutor->last_name ?>" class="img-responsive" src="<?php echo base_url().($val->tutor->image ? '/upload/users/images/'.image_to_thumb($val->tutor->image) : 'themes/default/images/teacher/thumb-teacher-01.jpg') ?>" width="100" height="100">
                                <small><?php echo lang('users_role_tutor') ?></small>
                                <h5><span><?php echo $val->tutor->first_name.' '.$val->tutor->last_name ?></span></h5>
                            </a>
                            <?php } ?>
                            <small><a href="<?php echo site_url('courses/detail/').str_replace(' ', '+', $val->title) ?>" title="<?php lang('action_view'); ?>" ><?php echo $val->total_tutors > 0 ? $val->total_tutors.' '.lang('action_more') : '' ?></a></small>
                        </div><!-- Course Teacher Detail -->
                        
                        <!-- Course Content -->
                        <div class="course-content">
                            <h4><a href="<?php echo site_url('courses/detail/').str_replace(' ', '+', $val->title) ?>" title="<?php lang('action_view'); ?>" ><?php echo $val->title ?></a></h4>
                            <!-- < ?php if(!$val->total_batches) { ?> -->
                            <div class="d-flex">
                            <?php if($hide_entroll): ?>
                              <a  class="btn btn-radius " href="<?php echo (!empty($_SESSION['logged_in']))?site_url('courses/detail/').str_replace(' ', '+', $val->title):site_url('auth/register'); ?>"> Enroll Now<?php /*echo lang('action_coming_soon')*/ ?></a>  
                            <?php endif;?>
                              
                                <a class="btn btn-radius " href="<?php echo site_url('courses/detail/').str_replace(' ', '+', $val->title); ?>" title="Course Material" >Videos</a>
                                                          
                            </div>
                            <!-- < ?php } else { ?>
                            <a href="< ?php echo site_url('bbooking/').str_replace(' ', '+', $val->title) ?>" class="btn">< ?php echo lang('action_apply_now') ?></a>
                            <p>< ?php echo lang('menu_batches') ?> < ?php echo $val->total_batches ? '+'.$val->total_batches : $val->total_batches; ?></p>
                            < ?php } ?> -->
                        </div><!-- Course Content -->
                    </div><!-- Course Detail -->
                </div><!-- Course Wrapper -->
            </div><!-- Column -->
            <?php } ?>
         
        </div><!-- Row -->
    </div><!-- Container -->
</section><!-- Section Featured Courses -->
<?php } ?>


