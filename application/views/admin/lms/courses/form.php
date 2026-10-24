<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 course-form-tabs course-form-card course-offcanvas">
        <!-- Page Header -->
        <div class="course-page-head">
            <a href="<?php echo site_url('admin/courses'); ?>" class="course-back" title="Back to courses">
                <i class="material-icons">arrow_back</i>
            </a>
            <div class="course-page-title">
                <div class="course-crumb"><a href="<?php echo site_url('admin/courses'); ?>">Courses</a> <i class="material-icons">chevron_right</i> <?php echo empty($id) ? 'New course' : 'Edit course'; ?></div>
                <h1><?php echo !empty($title['value']) ? htmlspecialchars($title['value']) : 'Untitled course'; ?></h1>
            </div>
        </div>

        <!-- Tabs: left menu + right content -->
        <div class="card course-tabs-card">
            <div class="body course-tabs-layout">
                <aside class="course-tabs-nav">
                    <div class="course-tabs-nav-label">Course setup</div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#overview" data-toggle="tab">
                                <i class="material-icons">info_outline</i>
                                <span class="course-nav-text"><strong>Overview</strong><small>Title, category, pricing &amp; media</small></span>
                            </a>
                        </li>
                        <li role="presentation" class="<?php echo empty($id) ? 'disabled' : ''; ?>">
                            <a href="#curriculum" data-toggle="tab" <?php echo empty($id) ? 'onclick="return false;"' : ''; ?>>
                                <i class="material-icons">format_list_numbered</i>
                                <span class="course-nav-text"><strong>Curriculum</strong><small>Sections &amp; lectures</small></span>
                                <?php echo empty($id) ? '<span class="course-nav-lock" title="Save the course first"><i class="material-icons">lock</i></span>' : ''; ?>
                            </a>
                        </li>
                        <li role="presentation" class="<?php echo empty($id) ? 'disabled' : ''; ?>">
                            <a href="#students" data-toggle="tab" <?php echo empty($id) ? 'onclick="return false;"' : ''; ?>>
                                <i class="material-icons">people_outline</i>
                                <span class="course-nav-text"><strong>Learners</strong><small>Enrolled students</small></span>
                                <?php echo empty($id) ? '<span class="course-nav-lock" title="Save the course first"><i class="material-icons">lock</i></span>' : ''; ?>
                            </a>
                        </li>
                    </ul>
                </aside>

                <div class="tab-content course-tabs-content">
                    
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
                                    <div class="header curr-card-head">
                                        <div id="curriculum_header_title" class="curr-card-title">
                                            <div>
                                                <h2>Course Curriculum</h2>
                                                <p>Organise lectures into sections. Learners see them in this order.</p>
                                            </div>
                                            <?php if(!empty($id)) { ?>
                                            <div class="curr-card-buttons">
                                            <button type="button" class="btn btn-default waves-effect" onclick="addSection()">
                                                <i class="material-icons">view_agenda</i> Add Section
                                            </button>
                                            <button type="button" id="btn_add_lecture" class="btn btn-primary waves-effect">
                                                <i class="material-icons">add</i> Add Lecture
                                            </button>
                                            </div>
                                            <button type="button" id="btn_cancel_lecture" class="btn btn-default waves-effect btn-sm" style="display: none;">
                                                <i class="material-icons" style="font-size: 18px;">close</i> CANCEL
                                            </button>
                                            <?php } ?>
                                        </div>
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
                                             <div class="offcanvas-sidebar lecture-panel" id="lecture-offcanvas" role="dialog" aria-labelledby="offcanvas_lecture_title">
                                                 <div class="offcanvas-header">
                                                     <div class="lecture-panel-heading">
                                                         <span class="lecture-panel-icon"><i class="material-icons">video_library</i></span>
                                                         <div>
                                                             <h4 id="offcanvas_lecture_title">Add new lecture</h4>
                                                             <p>Add a video, PDF or Google Drive file to this course.</p>
                                                         </div>
                                                     </div>
                                                     <button type="button" class="lecture-panel-close" id="close-lecture-offcanvas" title="Close">
                                                         <i class="material-icons">close</i>
                                                     </button>
                                                 </div>

                                                 <?php echo form_open_multipart(site_url('admin/courses/lecture_save'), array('class' => 'lecture-form', 'id' => 'form-lecture-create', 'role' => "form", 'novalidate' => 'novalidate')); ?>
                                                     <input type="hidden" name="course_id" value="<?php echo $id; ?>">
                                                     <input type="hidden" name="id" id="lecture_id" value=""> <!-- For Edit -->

                                                     <div class="offcanvas-body">
                                                         <div class="lecture-form-grid">
                                                             <!-- Left: details -->
                                                             <div class="lecture-form-col">
                                                                 <div class="lf-card">
                                                                     <div class="lf-card-title">Lecture details</div>

                                                                     <div class="form-group lf-field">
                                                                         <label class="lf-label" for="lecture_section_id_select">Section</label>
                                                                         <select name="section_id" id="lecture_section_id_select" class="form-control show-tick">
                                                                             <option value="0">Uncategorized</option>
                                                                         </select>
                                                                     </div>

                                                                     <div class="form-group lf-field">
                                                                         <label class="lf-label" for="lecture_category">Content type <span class="lf-req">*</span></label>
                                                                         <?php
                                                                         $lecture_types = array(
                                                                             '' => '-- Select Content Type --',
                                                                             '1' => 'Google Drive',
                                                                             '2' => 'PDF Document',
                                                                             '3' => 'YouTube / Vimeo'
                                                                         );
                                                                         echo form_dropdown('category', $lecture_types, '', 'id="lecture_category" class="form-control"');
                                                                         ?>
                                                                     </div>

                                                                     <div class="form-group lf-field">
                                                                         <label class="lf-label" for="lecture_title">Title <span class="lf-req">*</span></label>
                                                                         <input type="text" name="title" id="lecture_title" class="form-control" maxlength="200" placeholder="e.g. 21 Spark lazy evaluation">
                                                                     </div>

                                                                     <div class="form-group lf-field">
                                                                         <label class="lf-label" for="lecture_meta_title">URL / File ID <span class="lf-req">*</span></label>
                                                                         <input type="text" name="meta_title" id="lecture_meta_title" class="form-control" maxlength="200" placeholder="Paste a YouTube / Vimeo URL, or a Google Drive link / file ID">
                                                                         <div class="lf-hint">YouTube links are saved as an embed link automatically.</div>
                                                                     </div>

                                                                     <div class="form-group lf-field">
                                                                         <label class="lf-label" for="lecture_description">Description</label>
                                                                         <textarea name="description" id="lecture_description" class="form-control" rows="5" placeholder="What will learners get from this lecture? (optional)"></textarea>
                                                                     </div>
                                                                 </div>
                                                             </div>

                                                             <!-- Right: preview + visibility -->
                                                             <div class="lecture-form-col lecture-form-side">
                                                                 <div class="lecture-preview" id="lecture_preview">
                                                                     <div class="lecture-preview-head">
                                                                         <span class="lecture-preview-label"><i class="material-icons">visibility</i> Preview</span>
                                                                         <span class="lecture-preview-source" id="lecture_preview_source"></span>
                                                                         <a href="#" target="_blank" rel="noopener" class="lecture-preview-open" id="lecture_preview_open" style="display:none;">
                                                                             Open <i class="material-icons">open_in_new</i>
                                                                         </a>
                                                                     </div>
                                                                     <div class="lecture-preview-frame" id="lecture_preview_frame">
                                                                         <div class="lecture-preview-empty" id="lecture_preview_empty">
                                                                             <i class="material-icons">smart_display</i>
                                                                             <span>Choose a content type and paste a URL or File ID to see a preview.</span>
                                                                         </div>
                                                                     </div>
                                                                 </div>

                                                                 <div class="lf-card">
                                                                     <div class="lf-card-title">Visibility</div>
                                                                     <div class="lf-row">
                                                                         <div class="form-group lf-field">
                                                                             <label class="lf-label" for="lecture_status">Status</label>
                                                                             <select name="status" id="lecture_status" class="form-control">
                                                                                 <option value="1">Active</option>
                                                                                 <option value="0">Inactive</option>
                                                                             </select>
                                                                         </div>
                                                                         <div class="form-group lf-field">
                                                                             <label class="lf-label" for="lecture_featured">Access</label>
                                                                             <select name="featured" id="lecture_featured" class="form-control">
                                                                                 <option value="1">Secure (enrolled only)</option>
                                                                                 <option value="0">Public preview</option>
                                                                             </select>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>

                                                     <div class="offcanvas-footer">
                                                         <span class="lf-footer-note"><span class="lf-req">*</span> Required fields</span>
                                                         <button type="button" class="btn btn-default waves-effect lf-btn" id="lecture_cancel_btn">Cancel</button>
                                                         <button type="submit" class="btn btn-primary waves-effect lf-btn lf-btn-primary">Save Lecture</button>
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



<!-- DataTables & Embedded Form Logic -->
<?php if(!empty($id)) { ?>
<!-- SortableJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

<script>
// Global variables and functions
    var courseId = "<?php echo $id; ?>";
    
    // Load the curriculum with a timeout and a visible error + retry (jQuery .load() fails silently,
    // which left the spinner spinning forever when the request failed)
    var curriculumXhr = null;
    window.loadCurriculum = function() {
        if (!courseId) return;
        var $c = $('#curriculum_container');
        if (curriculumXhr) curriculumXhr.abort();
        if (!$c.children().length || $c.find('.curr-load-error').length) {
            $c.html('<div class="curr-loading"><span class="curr-spinner"></span> Loading curriculum…</div>');
        } else {
            $c.addClass('is-refreshing');
        }
        curriculumXhr = $.ajax({
            url: "<?php echo site_url('admin/courses/render_curriculum/'); ?>" + courseId,
            type: 'GET',
            dataType: 'html',
            cache: false,
            timeout: 30000
        }).done(function (html) {
            $c.html(html);
        }).fail(function (xhr, status) {
            if (status === 'abort') return;
            var reason = status === 'timeout' ? 'The server took too long to respond.'
                : (xhr.status ? 'Server error (HTTP ' + xhr.status + ').' : 'Network error. Check your connection.');
            $c.html('<div class="curr-load-error"><i class="material-icons">error_outline</i>'
                + '<div><strong>Couldn\'t load the curriculum.</strong><span>' + reason + '</span></div>'
                + '<button type="button" class="btn btn-default" onclick="loadCurriculum()"><i class="material-icons">refresh</i> Retry</button></div>');
        }).always(function () {
            $c.removeClass('is-refreshing');
            curriculumXhr = null;
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Load Curriculum
        loadCurriculum();

        // Learners table is built the first time its tab is opened (not on page load), so it doesn't
        // compete with the curriculum request.
        var studentsTableReady = false;
        function initStudentsTable() {
            if (studentsTableReady) return;
            studentsTableReady = true;
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
        }
        $('a[href="#students"][data-toggle="tab"]').on('shown.bs.tab', initStudentsTable);
        if ($('#students').hasClass('active')) initStudentsTable();

        // Toggle Offcanvas Form
        window.openLectureOffcanvas = function(title = 'Add new lecture', selectedSectionId = 0) {
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
            resetLecturePreview(); // also stops any playing video
            clearLectureErrors();
        }

        /* ---------- Lecture live preview ---------- */
        var previewTimer = null, previewSrc = '';

        function parseYouTubeId(v) {
            var m = v.match(/(?:youtube(?:-nocookie)?\.com\/(?:embed\/|watch\?(?:.*&)?v=|shorts\/|live\/|v\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/);
            if (m) return m[1];
            return /^[A-Za-z0-9_-]{11}$/.test(v) ? v : null;
        }
        function parseVimeoId(v) {
            var m = v.match(/vimeo\.com\/(?:video\/)?(\d+)/);
            return m ? m[1] : null;
        }
        function parseDriveId(v) {
            var m = v.match(/drive\.google\.com\/(?:file\/d\/|open\?(?:.*&)?id=|uc\?(?:.*&)?id=)([A-Za-z0-9_-]{10,})/) ||
                    v.match(/docs\.google\.com\/\w+\/d\/([A-Za-z0-9_-]{10,})/);
            if (m) return m[1];
            return /^[A-Za-z0-9_-]{20,}$/.test(v) ? v : null;
        }

        // Returns {src, open, source} or {error}
        function buildPreview(type, value) {
            var v = $.trim(value || ''), id;
            if (!type) return { error: 'Choose a content type to see a preview.' };
            if (!v) return { error: 'Paste a URL or File ID to see a preview.' };

            if (type === '3') {
                if ((id = parseYouTubeId(v))) return { src: 'https://www.youtube.com/embed/' + id + '?rel=0', open: 'https://www.youtube.com/watch?v=' + id, source: 'YouTube · ' + id };
                if ((id = parseVimeoId(v))) return { src: 'https://player.vimeo.com/video/' + id, open: 'https://vimeo.com/' + id, source: 'Vimeo · ' + id };
                return { error: "This doesn't look like a YouTube or Vimeo link. Paste the video URL or the 11-character YouTube ID." };
            }
            if ((id = parseDriveId(v))) {
                return { src: 'https://drive.google.com/file/d/' + id + '/preview', open: 'https://drive.google.com/file/d/' + id + '/view', source: 'Google Drive · ' + id.substr(0, 10) + '…' };
            }
            if (type === '2' && /^https?:\/\/\S+/i.test(v)) {
                return { src: v, open: v, source: 'PDF link' };
            }
            return { error: type === '1'
                ? "Couldn't find a Google Drive file ID. Paste the Drive share link or the file ID."
                : "Paste a Google Drive link / file ID or a direct link to the PDF." };
        }

        function renderLecturePreview() {
            var p = buildPreview($('#lecture_category').val(), $('#lecture_meta_title').val());
            var $frame = $('#lecture_preview_frame'), $wrap = $('#lecture_preview');
            $wrap.toggleClass('is-pdf', $('#lecture_category').val() !== '3');

            if (p.error) {
                previewSrc = '';
                $frame.find('iframe').remove();
                $('#lecture_preview_empty').show().find('span').text(p.error);
                $wrap.toggleClass('has-error', !!$.trim($('#lecture_meta_title').val()) && !!$('#lecture_category').val());
                $('#lecture_preview_source').text('');
                $('#lecture_preview_open').hide();
                return;
            }
            $wrap.removeClass('has-error');
            $('#lecture_preview_source').text(p.source);
            $('#lecture_preview_open').attr('href', p.open).show();
            if (p.src === previewSrc) return; // avoid reloading the same player
            previewSrc = p.src;
            $('#lecture_preview_empty').hide();
            $frame.find('iframe').remove();
            $('<iframe>', {
                src: p.src,
                allow: 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture',
                allowfullscreen: true,
                referrerpolicy: 'strict-origin-when-cross-origin',
                title: 'Lecture preview'
            }).appendTo($frame);
        }
        window.renderLecturePreview = renderLecturePreview;

        $('#lecture_meta_title').on('input', function () {
            clearTimeout(previewTimer);
            previewTimer = setTimeout(renderLecturePreview, 400);
        });
        $('#lecture_category').on('change', renderLecturePreview);

        function resetLecturePreview() {
            previewSrc = '';
            $('#lecture_preview_frame iframe').remove();
            $('#lecture_preview').removeClass('has-error is-pdf');
            $('#lecture_preview_empty').show().find('span').text('Choose a content type and paste a URL or File ID to see a preview.');
            $('#lecture_preview_source').text('');
            $('#lecture_preview_open').hide();
        }

        $('#btn_add_lecture').on('click', function() {
            closeLectureOffcanvas(); // Clear any existing state
            openLectureOffcanvas('Add new lecture');
        });

        $('#close-lecture-offcanvas, #lecture-offcanvas-backdrop, #lecture_cancel_btn').on('click', function() {
            closeLectureOffcanvas();
        });

        // Handle AJAX Form Submission for Lectures
        // Inline field errors (browser validation can't reach the theme's hidden <select>s, so we do it here)
        var lectureFieldMap = { category: '#lecture_category', title: '#lecture_title', meta_title: '#lecture_meta_title', section_id: '#lecture_section_id_select' };
        function clearLectureErrors() {
            $('#form-lecture-create .lecture-field-error').remove();
            $('#form-lecture-create .has-lecture-error').removeClass('has-lecture-error');
        }
        function showLectureError(field, msg) {
            var $group = $(lectureFieldMap[field] || ('[name="' + field + '"]')).closest('.form-group');
            if (!$group.length) return;
            $group.addClass('has-lecture-error');
            if (!$group.find('.lecture-field-error').length) {
                $('<div class="lecture-field-error"><i class="material-icons">error_outline</i><span></span></div>').appendTo($group).find('span').text(msg);
            }
        }
        function focusFirstLectureError() {
            var $first = $('#form-lecture-create .has-lecture-error').first();
            if (!$first.length) return;
            var $body = $('#lecture-offcanvas .offcanvas-body');
            $body.animate({ scrollTop: $body.scrollTop() + $first.offset().top - $body.offset().top - 20 }, 200);
            $first.find('input, textarea').first().trigger('focus');
        }
        function validateLectureForm() {
            clearLectureErrors();
            var ok = true, type = $('#lecture_category').val();
            if (!type) { showLectureError('category', 'Please select a content type.'); ok = false; }
            if (!$.trim($('#lecture_title').val())) { showLectureError('title', 'Please enter a lecture title.'); ok = false; }
            var url = $.trim($('#lecture_meta_title').val());
            if (!url) {
                showLectureError('meta_title', 'Please paste a URL or File ID.'); ok = false;
            } else if (type === '3') {
                // Videos must be a recognisable YouTube/Vimeo link (the server enforces the same rule).
                // Drive/PDF values are free-form (older lectures store plain file names), so only the preview warns.
                var p = buildPreview(type, url);
                if (p.error) { showLectureError('meta_title', p.error); ok = false; }
            }
            return ok;
        }
        $('#lecture_category, #lecture_title, #lecture_meta_title').on('change input', function () {
            $(this).closest('.form-group').removeClass('has-lecture-error').find('.lecture-field-error').remove();
        });

        $('#form-lecture-create').on('submit', function(e) {
            e.preventDefault();

            if (!validateLectureForm()) {
                focusFirstLectureError();
                return;
            }
            
            var formData = new FormData(this);
            var submitBtn = $(this).find('button[type="submit"]');
            var originalText = submitBtn.text();
            
            submitBtn.prop('disabled', true).text('Saving…');

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
                        // Error: mark the fields the server rejected, then show the message
                        var fields = response.error_fields || [];
                        if (typeof fields === 'string') { try { fields = JSON.parse(fields); } catch (err) { fields = []; } }
                        $.each(fields, function (i, f) { showLectureError(f, ''); });
                        $('#form-lecture-create .lecture-field-error span:empty').closest('.lecture-field-error').remove();
                        focusFirstLectureError();
                        swal('Could not save lecture', $('<div>').html(response.msg || 'Please check the form and try again.').text(), 'error');
                    }
                },
                error: function(xhr) {
                    var msg = 'The server could not save this lecture (HTTP ' + xhr.status + '). Please try again.';
                    if (xhr.status === 200) msg = 'Unexpected response from the server. You may have been logged out. Please reload the page and try again.';
                    swal('Could not save lecture', msg, 'error');
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
                        openLectureOffcanvas('Edit lecture', row.section_id);
                        renderLecturePreview();
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
                if ($.fn.DataTable.isDataTable('#students_table')) $('#students_table').DataTable().ajax.reload();
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
        openLectureOffcanvas('Add lecture to section', sectionId);
    }
</script>
<?php } ?>