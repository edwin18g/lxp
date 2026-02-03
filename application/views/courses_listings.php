<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>

<div class="page-default bg-grey typo-dark">
	<!-- Container -->
	<div class="container">
		<div class="row">
		
		
			<!-- Page Content -->
			<div class="col-md-12">
				<!-- Course Container -->
				<div class="row course-container">
					<?php if(! empty($courses)) { foreach($courses as $key => $val) {?>
					<!-- Column -->
					<div class="col-md-3">
						<!-- Course Wrapper -->
						<div class="course-wrapper">
							<!-- Course Banner Image -->
							<a href="<?php echo site_url('courses/lecture/'.$val->id) ?>" title="<?php lang('action_view'); ?>" >
								<div class="course-banner-wrap">
									<img alt="Course" class="img-responsive" src="<?php echo base_url().($val->images ? '/upload/courses/images/'.image_to_thumb(json_decode($val->images)[0]) : 'themes/default/images/course/course-01.jpg') ?>" width="600" height="220">
							
								</div><!-- Course Banner Image -->
							</a>
							<!-- Course Detail -->
							<div class="course-detail-wrap">
								<!-- Course Teacher Detail -->
								<div class="teacher-wrap hidden">
									<?php if(empty($val->tutor)) { ?>
									<img class="img-responsive" src="<?php echo base_url().'themes/default/images/teacher/thumb-teacher-01.jpg' ?>" width="100" height="100">
									<h5><small><?php echo lang('action_coming_soon'); ?></small></h5>
									<?php } else { ?>
									<a href="<?php echo site_url('tutors/').$val->tutor->username ?>">
										<img alt="<?php echo $val->tutor->first_name.' '.$val->tutor->last_name ?>" class="img-responsive" src="<?php echo base_url().($val->tutor->image ? '/upload/users/images/'.image_to_thumb($val->tutor->image) : 'themes/default/images/teacher/thumb-teacher-01.jpg') ?>" width="100" height="100">
										<small><?php echo lang('users_role_tutor') ?></small>
										<h5><span><?php echo $val->tutor->first_name.' '.$val->tutor->last_name ?></span></h5>
									</a>
									<?php } ?>
									<small><a href="<?php echo site_url('courses/lecture/'.$val->id) ?>" title="<?php lang('action_view'); ?>" ><?php echo $val->total_tutors > 0 ? $val->total_tutors.' '.lang('action_more') : '' ?></a></small>
								</div><!-- Course Teacher Detail -->
								
								<!-- Course Content -->
								<div class="course-content">
									<h4><a href="<?php echo site_url('courses/lecture/'.$val->id) ?>" title="<?php lang('action_view'); ?>" ><?php echo $val->title ?></a></h4>
									<!-- < ?php if(!$val->total_batches) { ?>
									<a disabled class="btn disabled">< ? php echo lang('action_coming_soon') ?></a>
									< ?php } else { ?>
									<a href="< ?php echo site_url('bbooking/').str_replace(' ', '+', $val->title) ?>" class="btn"><?php echo lang('action_apply_now') ?></a>
									<p>< ?php echo lang('menu_batches') ?> < ?php echo $val->total_batches ? '+'.$val->total_batches : $val->total_batches; ?></p>
									< ?php } ?> -->
									<!--<a href="< ?php echo site_url('courses/course_board/'.$val->id) ?>" class="btn">Go To Learn</a>-->
								</div><!-- Course Content -->
							</div><!-- Course Detail -->
						</div><!-- Course Wrapper -->
					</div><!-- Column -->		
					<?php } } else { ?>
					<div class="col-md-12 text-center">
						<h3><?php echo lang('c_l_no_courses') ?></h3>
						<p><?php echo sprintf(lang('c_l_for_category'), $category); ?></p>
					</div>
					<?php } ?>
				</div><!-- Row -->
				
			</div><!-- Column -->
		</div><!-- Row -->	
	</div><!-- Container -->
</div>