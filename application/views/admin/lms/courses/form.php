<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <!-- Page Header -->
        <div class="block-header">
            <h2 class="text-uppercase" style="margin-bottom: 20px;">
                <?php echo !empty($id) ? lang('action_edit') : lang('action_create'); ?>
                <a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2)) ?>" class="btn btn-default btn-circle waves-effect waves-circle waves-float pull-right"><i class="material-icons">arrow_back</i></a>
                <?php if(!empty($id)) { echo '<a role="button" onclick="ajaxDelete('.$id.', ``, `'.lang('menu_course').'`)" class="btn btn-danger btn-circle waves-effect waves-circle waves-float pull-right" style="margin-right: 10px;"><i class="material-icons">delete_forever</i></a>'; } ?>
            </h2>
        </div>

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

                            <div class="row clearfix">
                                <!-- Left Column: Main Information -->
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <h2>
                                                <i class="material-icons" style="vertical-align: middle; margin-right: 5px;">title</i> Basic Information
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
                                        <div class="header">
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
                                                            <div class="gallery">
                                                                <?php foreach($c_images as $val) { ?> 
                                                                    <img src="<?php echo base_url('upload/courses/images/'.image_to_thumb($val)); ?>" class="col-sm-4 img-responsive thumbnail" style="margin-top: 10px;">            
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
                                    <div class="header">
                                        <h2 id="curriculum_header_title">
                                            COURSE CURRICULUM
                                        </h2>
                                        <ul class="header-dropdown m-r--5">
                                            <li class="dropdown">
                                                <?php if(!empty($id)) { ?>
                                                <button type="button" id="btn_add_lecture" class="btn btn-primary waves-effect">
                                                    <i class="material-icons">add</i> ADD NEW LECTURE
                                                </button>
                                                <button type="button" id="btn_cancel_lecture" class="btn btn-default waves-effect" style="display: none;">
                                                    <i class="material-icons">close</i> CANCEL
                                                </button>
                                                <?php } ?>
                                            </li>
                                        </ul>
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

                                            <!-- Embedded Lecture Form -->
                                            <div id="lecture_form_container" style="display: none; margin-top: 20px;">
                                                <?php echo form_open_multipart(site_url('admin/courses/lecture_save'), array('class' => 'form-horizontal', 'id' => 'form-lecture-create', 'role'=>"form")); ?>
                                                    <input type="hidden" name="course_id" value="<?php echo $id; ?>">
                                                    <input type="hidden" name="id" id="lecture_id" value=""> <!-- For Edit -->

                                                    <div class="row clearfix">
                                                        <div class="col-md-2 form-control-label">
                                                            <label>Content Type</label>
                                                        </div>
                                                        <div class="col-md-10">
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

                                                    <div class="row clearfix">
                                                        <div class="col-md-2 form-control-label">
                                                            <label>Title</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" name="title" id="lecture_title" class="form-control" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row clearfix">
                                                        <div class="col-md-2 form-control-label">
                                                            <label>URL / File ID</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" name="meta_title" id="lecture_meta_title" class="form-control" required placeholder="Enter Video URL or File ID">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row clearfix">
                                                        <div class="col-md-2 form-control-label">
                                                            <label>Description</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <textarea name="description" id="lecture_description" class="form-control" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row clearfix">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-4 form-control-label">
                                                                    <label>Status</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <select name="status" id="lecture_status" class="form-control">
                                                                                <option value="1">Active</option>
                                                                                <option value="0">Inactive</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>      
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-4 form-control-label">
                                                                    <label>Secure</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <select name="featured" id="lecture_featured" class="form-control"> <!-- mapped to 'featured'/cl_secure in controller -->
                                                                                <option value="1">Yes</option>
                                                                                <option value="0">No</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>      
                                                        </div>
                                                    </div>

                                                    <div class="row clearfix">
                                                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SAVE LECTURE</button>
                                                        </div>
                                                    </div>
                                                <?php echo form_close(); ?>
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
                                        <h2>
                                            ENROLLED LEARNERS
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
    .card .header {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(204, 204, 204, 0.35);
    }
    .card .header h2 {
        font-size: 16px;
        color: #555;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .form-group .form-line {
        border-bottom: 1px solid #ddd;
    }
    .form-group .form-line:after {
        border-bottom: 2px solid #2196F3;
    }
    .form-label {
        font-weight: normal;
        color: #aaa;
        font-size: 12px;
        text-transform: uppercase;
    }
    .nav-tabs > li > a {
        font-weight: 600;
        color: #555;
    }
    .nav-tabs > li.active > a, 
    .nav-tabs > li.active > a:hover, 
    .nav-tabs > li.active > a:focus {
        color: #2196F3;
        font-weight: 700;
    }
</style>

<!-- DataTables & Embedded Form Logic -->
<?php if(!empty($id)) { ?>
<!-- SortableJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var courseId = "<?php echo $id; ?>";

        // Load Curriculum
        loadCurriculum();

        function loadCurriculum() {
            $('#curriculum_container').load("<?php echo site_url('admin/courses/render_curriculum/'); ?>" + courseId);
        }

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
             "order": [[ 0, "desc" ]]
        });

        // Toggle "Add Lecture" Form
        $('#btn_add_lecture').on('click', function() {
            $('#curriculum_container').slideUp();
            $('#lecture_form_container').slideDown();
            $(this).hide();
            $('#btn_cancel_lecture').show();
            $('#curriculum_header_title').text('ADD NEW LECTURE');
            // Reset form
            $('#form-lecture-create')[0].reset();
            $('#lecture_id').val('');
        });

        $('#btn_cancel_lecture').on('click', function() {
            $('#lecture_form_container').slideUp();
            $('#curriculum_container').slideDown();
            $(this).hide();
            $('#btn_add_lecture').show();
            $('#curriculum_header_title').text('COURSE CURRICULUM');
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
                        
                        // Reset and switch view
                        $('#btn_cancel_lecture').trigger('click');
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
                        
                        $('#lecture_status').val(row.cl_secure).change(); 
                        $('#lecture_featured').val(row.cl_status).change();
                        
                        // UI Transitions
                        $('#curriculum_header_title').text('EDIT LECTURE');
                        $('#curriculum_container').slideUp();
                        $('#lecture_form_container').slideDown();
                        $('#btn_add_lecture').hide();
                        $('#btn_cancel_lecture').show();
                        
                        $('html, body').animate({
                            scrollTop: $("#lecture_form_container").offset().top - 100
                        }, 500);
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
            data: {id: id, status: status},
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
        // ... switch to form ...
        $('#curriculum_container').slideUp();
        $('#lecture_form_container').slideDown();
        $('#btn_add_lecture').hide();
        $('#btn_cancel_lecture').show();
        $('#curriculum_header_title').text('ADD NEW LECTURE');
        
        $('#form-lecture-create')[0].reset();
        $('#lecture_id').val('');
        
        // Set Section ID hidden field (need to add this to form)
        if($('#lecture_section_id').length == 0) {
            $('<input>').attr({
                type: 'hidden',
                id: 'lecture_section_id',
                name: 'section_id',
                value: sectionId
            }).appendTo('#form-lecture-create');
        } else {
            $('#lecture_section_id').val(sectionId);
        }
    }
</script>
<?php } ?>