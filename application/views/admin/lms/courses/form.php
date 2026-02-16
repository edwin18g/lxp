<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <!-- Page Header -->
       

        <!-- Tabs -->
        <div class="card">
            <div class="body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#overview" data-toggle="tab">
                            <i class="material-icons">info_outline</i> OVERVIEW
                        </a>
                    </li>
                    <li role="presentation" class="<?php echo empty($id) ? 'disabled' : ''; ?>">
                        <a href="#curriculum" data-toggle="tab" <?php echo empty($id) ? 'onclick="return false;"' : ''; ?>>
                            <i class="material-icons">format_list_numbered</i> CURRICULUM
                        </a>
                    </li>
                    <li role="presentation" class="<?php echo empty($id) ? 'disabled' : ''; ?>">
                        <a href="#students" data-toggle="tab" <?php echo empty($id) ? 'onclick="return false;"' : ''; ?>>
                            <i class="material-icons">people</i> LEARNERS
                        </a>
                    </li>
                </ul>

                <div class="tab-content" style="margin-top: 20px;">
                    
                    <!-- Tab 1: Overview (The Main Form) -->
                    <div role="tabpanel" class="tab-pane fade in active" id="overview">
                        <?php echo form_open_multipart(site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.'save'), array('class' => 'form-horizontal', 'id' => 'form-create', 'role'=>"form")); ?>
                            
                            <?php if(! empty($id)) { ?> <!-- in case of update courses -->
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <?php } ?>

                            <div class="row clearfix" style="display: flex; flex-wrap: wrap;">
                                <!-- Left Column: Main Information -->
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="display: flex;">
                                    <div class="card" style="width: 100%;">
                                        <div class="header bg-blue-grey">
                                            <h2>
                                                <i class="material-icons" style="vertical-align: middle; margin-right: 5px;">info</i> Course Details
                                            </h2>
                                        </div>
                                        <div class="body">
                                            <!-- Title -->
                                            <div class="row clearfix">
                                                <div class="col-lg-12">
                                                    <label class="form-label"><?php echo lang('common_title'); ?></label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <?php echo form_input($title);?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Category -->
                                            <div class="row clearfix">
                                                <div class="col-lg-12">
                                                    <label class="form-label"><?php echo lang('courses_category'); ?></label>
                                                    <div class="form-group">
                                                        <div class="form-line" id="show_sub_categories">
                                                            <?php echo form_dropdown($category); ?>
                                                            <?php if(!empty($id)) foreach($category_l as $c_l) { echo form_dropdown($c_l); } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Description -->
                                            <div class="row clearfix">
                                                <div class="col-lg-12">
                                                    <label class="form-label"><?php echo lang('common_description'); ?></label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <?php echo form_textarea($description); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column: Settings, Media, SEO -->
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    
                                    <!-- Publishing Card -->
                                    <div class="card">
                                        <div class="header bg-blue-grey">
                                            <h2>
                                                <i class="material-icons" style="vertical-align: middle; margin-right: 5px;">publish</i> Publishing
                                            </h2>
                                        </div>
                                        <div class="body">
                                            <div class="row clearfix">
                                                <div class="col-sm-12">
                                                    <label class="form-label"><?php echo lang('common_status'); ?></label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <?php echo form_dropdown($status);?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label class="form-label"><?php echo lang('common_featured'); ?></label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <?php echo form_dropdown($featured);?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn bg-<?php echo $this->settings->admin_theme ?> btn-lg waves-effect btn-block">
                                                        <i class="material-icons">save</i> <?php echo lang('action_submit') ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Media Card -->
                                    <div class="card">
                                        <div class="header bg-blue-grey">
                                            <h2>
                                                <i class="material-icons" style="vertical-align: middle; margin-right: 5px;">image</i> Course Media
                                            </h2>
                                        </div>
                                        <div class="body">
                                            <label class="form-label"><?php echo lang('common_images'); ?></label>
                                            <div class="form-group">
                                                <div class="picture-container">
                                                    <div class="picture-select">
                                                        <img src="<?php echo base_url('themes/admin/img/choose_files.png'); ?>" class="img-responsive">
                                                        <?php echo form_input($images);?>
                                                    </div>
                                                </div>
                                                <?php if(! empty($c_images)) { ?>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="gallery" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px;">
                                                                <?php foreach($c_images as $val) { ?> 
                                                                    <div style="position: relative; width: 80px; height: 80px;">
                                                                        <img src="<?php echo base_url('upload/courses/images/'.image_to_thumb($val)); ?>" class="img-responsive img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                                                                    </div>
                                                                <?php } ?>
                                                            </div>                                
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SEO Card -->
                                    <div class="card">
                                        <div class="header" data-toggle="collapse" data-target="#seo_body" style="cursor: pointer;">
                                            <h2>
                                                <i class="material-icons" style="vertical-align: middle; margin-right: 5px;">search</i> SEO Configuration
                                                <i class="material-icons pull-right">expand_more</i>
                                            </h2>
                                        </div>
                                        <div class="body collapse" id="seo_body">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo lang('common_meta_title'); ?></label>
                                                <div class="form-line">
                                                    <?php echo form_input($meta_title);?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?php echo lang('common_meta_tags'); ?></label>
                                                <div class="form-line">
                                                    <?php echo form_input($meta_tags);?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?php echo lang('common_meta_description'); ?></label>
                                                <div class="form-line">
                                                    <?php echo form_textarea($meta_description);?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php echo form_close();?>
                    </div>

                    <!-- Tab 2: Curriculum -->
                    <div role="tabpanel" class="tab-pane fade" id="curriculum">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="header" style="background: #fcfcfc;">
                                        <h2 id="curriculum_header_title" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                            <span>COURSE CURRICULUM</span>
                                            <?php if(!empty($id)) { ?>
                                            <button type="button" id="btn_add_lecture" class="btn btn-primary waves-effect btn-sm">
                                                <i class="material-icons" style="font-size: 18px;">add</i> ADD LECTURE
                                            </button>
                                            <button type="button" id="btn_cancel_lecture" class="btn btn-default waves-effect btn-sm" style="display: none;">
                                                <i class="material-icons" style="font-size: 18px;">close</i> CANCEL
                                            </button>
                                            <?php } ?>
                                        </h2>
                                    </div>
                                    <div class="body">
                                        <?php if(empty($id)) { ?>
                                            <div class="alert alert-info">Please save the course details first to manage the curriculum.</div>
                                        <?php } else { ?>
                                            
                                            <!-- Lecture List Container -->
                                            <div id="curriculum_container">
                                                <div class="text-center">
                                                    <div class="preloader pl-size-xl">
                                                        <div class="spinner-layer pl-blue">
                                                            <div class="circle-clipper left">
                                                                <div class="circle"></div>
                                                            </div>
                                                            <div class="circle-clipper right">
                                                                <div class="circle"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                             <!-- Offcanvas Lecture Form -->
                                             <div class="offcanvas-backdrop" id="lecture-offcanvas-backdrop"></div>
                                             <div class="offcanvas-sidebar" id="lecture-offcanvas">
                                                 <div class="offcanvas-header">
                                                     <h4 style="margin: 0; font-weight: 700; color: #333;" id="offcanvas_lecture_title">ADD NEW LECTURE</h4>
                                                     <button type="button" class="btn btn-default btn-circle waves-effect" id="close-lecture-offcanvas">
                                                         <i class="material-icons">close</i>
                                                     </button>
                                                 </div>
                                                 <div class="offcanvas-body">
                                                     <?php echo form_open_multipart(site_url('admin/courses/lecture_save'), array('class' => 'form-horizontal', 'id' => 'form-lecture-create', 'role'=>"form")); ?>
                                                         <input type="hidden" name="course_id" value="<?php echo $id; ?>">
                                                         <input type="hidden" name="id" id="lecture_id" value=""> <!-- For Edit -->

                                                         <div class="row clearfix m-b-20">
                                                             <div class="col-sm-12">
                                                                 <label class="form-label">Section</label>
                                                                 <div class="form-group">
                                                                     <div class="form-line">
                                                                         <select name="section_id" id="lecture_section_id_select" class="form-control show-tick" required>
                                                                             <option value="0">Uncategorized</option>
                                                                         </select>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>

                                                         <div class="row clearfix m-b-20">
                                                             <div class="col-sm-12">
                                                                 <label class="form-label">Content Type</label>
                                                                 <div class="form-group">
                                                                     <div class="form-line">
                                                                         <?php 
                                                                         $lecture_types = array(
                                                                             '' => '-- Select Content Type --',
                                                                             '1' => 'Google Drive',
                                                                             '2' => 'PDF Document',
                                                                             '3' => 'YouTube / Vimeo'
                                                                         );
                                                                         echo form_dropdown('category', $lecture_types, '', 'id="lecture_category" class="form-control" required'); 
                                                                         ?>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>

                                                         <div class="row clearfix m-b-20">
                                                             <div class="col-sm-12">
                                                                 <label class="form-label">Title</label>
                                                                 <div class="form-group">
                                                                     <div class="form-line">
                                                                         <input type="text" name="title" id="lecture_title" class="form-control" required>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>

                                                         <div class="row clearfix m-b-20">
                                                             <div class="col-sm-12">
                                                                 <label class="form-label">URL / File ID</label>
                                                                 <div class="form-group">
                                                                     <div class="form-line">
                                                                         <input type="text" name="meta_title" id="lecture_meta_title" class="form-control" required placeholder="Enter Video URL or File ID">
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>

                                                         <div class="row clearfix m-b-20">
                                                             <div class="col-sm-12">
                                                                 <label class="form-label">Description</label>
                                                                 <div class="form-group">
                                                                     <div class="form-line">
                                                                         <textarea name="description" id="lecture_description" class="form-control" rows="3"></textarea>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>

                                                         <div class="row clearfix m-b-20">
                                                             <div class="col-sm-6">
                                                                 <label class="form-label">Status</label>
                                                                 <div class="form-group">
                                                                     <div class="form-line">
                                                                         <select name="status" id="lecture_status" class="form-control">
                                                                             <option value="1">Active</option>
                                                                             <option value="0">Inactive</option>
                                                                         </select>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                             <div class="col-sm-6">
                                                                 <label class="form-label">Secure Content</label>
                                                                 <div class="form-group">
                                                                     <div class="form-line">
                                                                         <select name="featured" id="lecture_featured" class="form-control">
                                                                             <option value="1">Yes (Secure)</option>
                                                                             <option value="0">No (Public)</option>
                                                                         </select>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>

                                                         <div class="row clearfix m-t-20">
                                                             <div class="col-sm-12">
                                                                 <button type="submit" class="btn btn-primary btn-lg btn-block waves-effect">SAVE LECTURE</button>
                                                             </div>
                                                         </div>
                                                     <?php echo form_close(); ?>
                                                 </div>
                                             </div>

                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Learners -->
                    <div role="tabpanel" class="tab-pane fade" id="students">
                         <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="header">
                                        <h2 style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                            <span>ENROLLED LEARNERS</span>
                                            <button type="button" class="btn btn-primary waves-effect btn-sm" onclick="enrollLearners()">
                                                <i class="material-icons" style="font-size: 18px;">person_add</i> ENROLL LEARNERS
                                            </button>
                                        </h2>
                                    </div>
                                    <div class="body">
                                        <?php if(empty($id)) { ?>
                                            <div class="alert alert-info">Please save the course details first to manage learners.</div>
                                        <?php } else { ?>
                                            <div class="table-responsive">
                                                <table id="students_table" class="table table-bordered table-striped table-hover dataTable" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling for the new form layout */
    .nav-tabs {
        border-bottom: none;
        background: #f8f9fa;
        padding: 0;
        border-radius: 12px 12px 0 0;
        margin-bottom: 25px;
        display: flex;
        width: 100%;
    }
    .nav-tabs > li {
        flex: 1;
        display: flex;
    }
    .nav-tabs > li > a {
        font-weight: 600;
        color: #777;
        border: none !important;
        padding: 18px 25px;
        transition: all 0.3s;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        border-radius: 0;
    }
    .nav-tabs > li:first-child > a {
        border-radius: 12px 0 0 0;
    }
    .nav-tabs > li:last-child > a {
        border-radius: 0 12px 0 0;
    }
    .nav-tabs > li > a i {
        margin-right: 8px;
        font-size: 20px !important;
    }
    .nav-tabs > li.active > a {
        color: #2196F3 !important;
        background: #fff !important;
        border-bottom: 3px solid #2196F3 !important;
        box-shadow: 0 -4px 10px rgba(0,0,0,0.03);
    }
    .card {
        border: none;
        border-radius: 12px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06) !important;
        margin-bottom: 30px;
        transition: transform 0.2s;
    }
    .card .header {
        border-radius: 12px 12px 0 0 !important;
        padding: 18px 25px !important;
        border-bottom: 1px solid #f5f5f5;
    }
    .card .header h2 {
        font-size: 15px !important;
        font-weight: 600;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-group .form-line {
        border-bottom: 1px solid #eee !important;
    }
    .form-line.focused {
        border-bottom: 2px solid #2196F3 !important;
    }
    .form-label {
        font-weight: 600;
        color: #888;
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .btn-circle {
        border-radius: 50% !important;
    }

    /* Offcanvas Sidebar */
    .offcanvas-sidebar {
        position: fixed;
        right: -100%;
        top: 0;
        width: 50%;
        height: 100%;
        background: #fff;
        z-index: 1050;
        box-shadow: -5px 0 25px rgba(0,0,0,0.1);
        transition: right 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
    }
    .offcanvas-sidebar.active {
        right: 0;
    }
    .offcanvas-header {
        padding: 20px 25px;
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .offcanvas-body {
        padding: 30px 25px;
        overflow-y: auto;
        flex-grow: 1;
    }
    .offcanvas-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        z-index: 1040;
        display: none;
        backdrop-filter: blur(2px);
    }
    .offcanvas-backdrop.active {
        display: block;
    }
</style>

<!-- DataTables & Embedded Form Logic -->
<?php if(!empty($id)) { ?>
<!-- SortableJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

<script>
// Global variables and functions
    var courseId = "<?php echo $id; ?>";
    
    window.loadCurriculum = function() {
        if(courseId) {
            $('#curriculum_container').load("<?php echo site_url('admin/courses/render_curriculum/'); ?>" + courseId);
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Load Curriculum
        loadCurriculum();

        // Initialize Students Table
        $('#students_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('admin/courses/ajax_users_list') ?>",
                "type": "POST",
                "data": function ( d ) {
                    d.id = "<?php echo $id; ?>";
                }
            },
            "columns": [
                { "data": 0 }, 
                { "data": 1 }, 
                { "data": 2 }, 
                { "data": 3 },
            ],
            "order": [[ 0, "desc" ]],
            "language": {
                "search": "",
                "searchPlaceholder": "Search learners..."
            }
        });

        // Toggle Offcanvas Form
        window.openLectureOffcanvas = function(title = 'ADD NEW LECTURE', selectedSectionId = 0) {
            $('#offcanvas_lecture_title').text(title);
            
            // Load sections
            $.ajax({
                url: "<?php echo site_url('admin/courses/ajax_get_sections/'); ?>" + courseId,
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    if(response.flag == 1) {
                        var html = '<option value="0">Uncategorized</option>';
                        $.each(response.data, function(i, section) {
                            html += '<option value="'+section.id+'">'+section.title+'</option>';
                        });
                        $('#lecture_section_id_select').html(html).val(selectedSectionId);
                        
                        // Refresh selectpicker
                        if ($('#lecture_section_id_select').parents('.bootstrap-select').length > 0) {
                            $('#lecture_section_id_select').selectpicker('refresh');
                        } else if ($.fn.selectpicker) {
                            $('#lecture_section_id_select').selectpicker();
                        }
                    }
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr);
                }
            });

            $('#lecture-offcanvas, #lecture-offcanvas-backdrop').addClass('active');
            $('body').css('overflow', 'hidden'); // Lock scroll
        }

        window.closeLectureOffcanvas = function() {
            $('#lecture-offcanvas, #lecture-offcanvas-backdrop').removeClass('active');
            $('body').css('overflow', ''); // Unlock scroll
            // Reset form
            $('#form-lecture-create')[0].reset();
            $('#lecture_id').val('');
            if($('#lecture_section_id').length > 0) $('#lecture_section_id').val('');
        }

        $('#btn_add_lecture').on('click', function() {
            closeLectureOffcanvas(); // Clear any existing state
            openLectureOffcanvas('ADD NEW LECTURE');
        });

        $('#close-lecture-offcanvas, #lecture-offcanvas-backdrop').on('click', function() {
            closeLectureOffcanvas();
        });

        // Handle AJAX Form Submission for Lectures
        $('#form-lecture-create').on('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            var submitBtn = $(this).find('button[type="submit"]');
            var originalText = submitBtn.text();
            
            submitBtn.prop('disabled', true).text('SAVING...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.flag == 1) {
                        // Success
                        swal('Success', response.msg, 'success');
                        
                        // Close offcanvas and reload
                        closeLectureOffcanvas();
                        loadCurriculum();
                    } else {
                        // Error
                        swal('Error', response.msg, 'error');
                    }
                },
                error: function() {
                    swal('Error', 'An internal error occurred', 'error');
                },
                complete: function() {
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });

        // Initialize global functions for edit/delete since they are called from inside the loaded view
        window.deleteLecture = function(id) {
            swal({
                title: "<?php echo lang('alert_delete_confirm'); ?>",
                text: "<?php echo lang('alert_delete_confirm_text'); ?>",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "<?php echo lang('action_delete'); ?>",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    url: "<?php echo site_url('admin/courses/delete_lecture'); ?>",
                    type: "POST",
                    data: {id: id},
                    dataType: 'json',
                    success: function (response) {
                        if (response.flag == 1) {
                            swal("Deleted!", response.msg, "success");
                            loadCurriculum();
                        } else {
                            swal("Error", response.msg, "error");
                        }
                    },
                    error: function () {
                        swal("Error", "Internal server error", "error");
                    }
                });
            });
        }

        window.editLecture = function(id) {
             $.ajax({
                url: "<?php echo site_url('admin/courses/ajax_get_lecture/'); ?>" + id,
                type: "GET",
                dataType: 'json',
                success: function (response) {
                    if (response.flag == 1) {
                        var data = response.data;
                        var row = Array.isArray(data) ? data[0] : data;
                        
                        $('#lecture_id').val(row.id);
                        $('#lecture_title').val(row.cl_name);
                        $('#lecture_category').val(row.cl_type).change();
                        $('#lecture_meta_title').val(row.cl_file_name);
                        $('#lecture_description').val(row.cl_decsription);
                        
                        $('#lecture_status').val(row.cl_status).change(); 
                        $('#lecture_featured').val(row.cl_secure).change();
                        
                        // UI Transitions
                        openLectureOffcanvas('EDIT LECTURE', row.section_id);
                    } else {
                         swal("Error", response.msg, "error");
                    }
                },
                error: function () {
                    swal("Error", "Internal server error", "error");
                }
            });
        }
    });

    function statusUpdatesecure(element, id) {
        var status = $(element).prop('checked') ? 1 : 0;
        $.ajax({
            url: "<?php echo site_url('admin/courses/status_lecture'); ?>",
            type: "POST",
            data: {
                id: id, 
                status: status,
                csrf_token: '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: 'json',
            success: function (response) {
                if (response.flag == 1) {
                   // swal("Success", response.msg, "success");
                } else {
                    swal("Error", response.msg, "error");
                    // Revert toggle
                    $(element).prop('checked', !status);
                }
            },
            error: function () {
                swal("Error", "Internal server error", "error");
                $(element).prop('checked', !status);
            }
        });
    }

    window.enrollLearners = function() {
        $('#enrollmentModal').modal('show');
        loadUsersForEnrollment();
    }
</script>

<!-- Enrollment Modal -->
<div class="modal fade" id="enrollmentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="padding: 20px 25px; border-bottom: 1px solid #f0f0f0;">
                <h4 class="modal-title" style="font-weight: 700; color: #333;">ENROLL LEARNERS</h4>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div class="search-bar" style="padding: 15px 25px; background: #f8f9fa; display: flex; align-items: center;">
                    <div class="form-group" style="margin: 0; flex-grow: 1;">
                        <div class="form-line">
                            <input type="text" id="user_search" class="form-control" placeholder="Search by name, email or mobile...">
                        </div>
                    </div>
                    <i class="material-icons" style="color: #aaa; margin-left: 10px;">search</i>
                </div>
                <div id="users_list_container" style="height: 400px; overflow-y: auto; padding: 10px 25px;">
                    <!-- Users will be loaded here via AJAX -->
                    <div class="text-center" style="padding: 50px;">
                        <div class="preloader pl-size-md">
                            <div class="spinner-layer pl-blue">
                                <div class="circle-clipper left"><div class="circle"></div></div>
                                <div class="circle-clipper right"><div class="circle"></div></div>
                            </div>
                        </div>
                        <p style="margin-top: 15px; color: #888;">Loading learners...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="padding: 15px 25px; border-top: 1px solid #f0f0f0;">
                <div class="pull-left" id="selected_count_wrapper" style="display: none; align-items: center;">
                    <span class="label label-primary" id="selected_user_count_badge" style="padding: 5px 10px; border-radius: 20px;">0 SELECTED</span>
                </div>
                <button type="button" class="btn btn-primary waves-effect" id="confirm_enrollment" disabled>ENROLL SELECTED</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCEL</button>
            </div>
        </div>
    </div>
</div>

<script>
    var selectedUsers = [];
    
    function loadUsersForEnrollment() {
        var keyword = $('#user_search').val();
        $.ajax({
            url: "<?php echo site_url('admin/courses/ajax_get_unrolled_users/'); ?>" + courseId,
            type: "POST",
            data: {
                keyword: keyword,
                csrf_token: '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(html) {
                $('#users_list_container').html(html);
                updateSelectedView();
            }
        });
    }

    $(document).on('keyup', '#user_search', function() {
        clearTimeout(window.userSearchTimer);
        window.userSearchTimer = setTimeout(loadUsersForEnrollment, 500);
    });

    $(document).on('change', '.user-enroll-check', function() {
        var userId = $(this).val();
        if($(this).is(':checked')) {
            if(!selectedUsers.includes(userId)) selectedUsers.push(userId);
        } else {
            selectedUsers = selectedUsers.filter(id => id !== userId);
        }
        updateSelectedView();
    });

    function updateSelectedView() {
        if(selectedUsers.length > 0) {
            $('#selected_count_wrapper').css('display', 'flex');
            $('#selected_user_count_badge').text(selectedUsers.length + ' SELECTED');
            $('#confirm_enrollment').prop('disabled', false);
        } else {
            $('#selected_count_wrapper').hide();
            $('#confirm_enrollment').prop('disabled', true);
        }
    }

    $('#confirm_enrollment').on('click', function() {
        var btn = $(this);
        btn.prop('disabled', true).text('ENROLLING...');
        
        $.ajax({
            url: "<?php echo site_url('admin/courses/user_save_beta'); ?>",
            type: "POST",
            data: {
                user_id: selectedUsers.join(','),
                course_id: courseId,
                csrf_token: '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: 'json',
            success: function(response) {
                swal("Success", "Learners enrolled successfully", "success");
                $('#enrollmentModal').modal('hide');
                $('#students_table').DataTable().ajax.reload();
                selectedUsers = [];
            },
            error: function() {
                swal("Error", "Failed to enroll learners", "error");
                btn.prop('disabled', false).text('ENROLL SELECTED');
            }
        });
    });
</script>

<!-- Section Modal -->
<div class="modal fade" id="sectionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="sectionModalLabel">Add New Section</h4>
            </div>
            <div class="modal-body">
                <form id="form-section">
                    <input type="hidden" name="id" id="section_id">
                    <input type="hidden" name="course_id" value="<?php echo $id; ?>">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="title" id="section_title" class="form-control" required>
                            <label class="form-label">Section Title</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="saveSection()">SAVE CHANGES</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<script>
    // ... existing initialization code ...

    // Section Management Functions
    function addSection() {
        $('#section_id').val('');
        $('#section_title').val('');
        $('#sectionModalLabel').text('Add New Section');
        $('#sectionModal').modal('show');
    }

    function editSection(id, title) {
        $('#section_id').val(id);
        $('#section_title').val(title);
        $('#sectionModalLabel').text('Edit Section');
        $('#sectionModal').modal('show');
        // Re-focus label if needed for Material Design
        $('.form-line').addClass('focused');
    }

    function saveSection() {
        var formData = $('#form-section').serialize();
        $.ajax({
            url: "<?php echo site_url('admin/courses/save_section'); ?>",
            type: "POST",
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#sectionModal').modal('hide');
                    loadCurriculum(); // Reload the list
                    swal("Success", response.message, "success");
                } else {
                    var errorMsg = response.message;
                    if (response.errors && typeof response.errors === 'object') {
                        errorMsg += "\n";
                        for (var key in response.errors) {
                            if (response.errors.hasOwnProperty(key)) {
                                errorMsg += "- " + response.errors[key] + "\n";
                            }
                        }
                    }
                    swal("Error", errorMsg, "error");
                }
            },
            error: function (xhr) {
                var errorMsg = "Internal server error";
                if(xhr.responseJSON && xhr.responseJSON.message) {
                     errorMsg = xhr.responseJSON.message;
                     if (xhr.responseJSON.errors && typeof xhr.responseJSON.errors === 'object') {
                        errorMsg += "\n";
                        for (var key in xhr.responseJSON.errors) {
                            if (xhr.responseJSON.errors.hasOwnProperty(key)) {
                                errorMsg += "- " + xhr.responseJSON.errors[key] + "\n";
                            }
                        }
                    }
                }
                swal("Error", errorMsg, "error");
            }
        });
    }

    function deleteSection(id) {
        swal({
            title: "Delete Section?",
            text: "All lectures in this section will be moved to 'Uncategorized'.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: "<?php echo site_url('admin/courses/delete_section'); ?>",
                type: "POST",
                data: {id: id},
                dataType: 'json',
                success: function (response) {
                    if (response.flag == 1) {
                        swal("Deleted!", response.msg, "success");
                        loadCurriculum();
                    } else {
                        swal("Error", response.msg, "error");
                    }
                },
                error: function () {
                    swal("Error", "Internal server error", "error");
                }
            });
        });
    }

    // Add Lecture (Modified to handle Section ID)
    window.addLectureToSection = function(sectionId) {
        // Open offcanvas with pre-selected section
        openLectureOffcanvas('ADD LECTURE TO SECTION', sectionId);
    }
</script>
<?php } ?>