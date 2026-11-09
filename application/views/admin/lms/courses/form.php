<?php defined('BASEPATH') OR exit('No direct script access allowed');
$active_tab = (isset($active_tab) && !empty($id)) ? $active_tab : 'overview';
$tab_base = site_url('admin/courses/form' . (!empty($id) ? '/' . (int) $id : ''));
?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 course-form-tabs course-form-card course-offcanvas">
        <!-- Page Header -->
        <!-- Tabs: left menu + right content -->
        <div class="card course-tabs-card">
            <div class="body course-tabs-layout">
                <aside class="course-tabs-nav">
                    <div class="course-tabs-nav-label">Course setup</div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="<?php echo $active_tab === 'overview' ? 'active' : ''; ?>">
                            <a href="#overview" data-toggle="tab" data-tab="overview" data-url="<?php echo $tab_base; ?>">
                                <i class="material-icons">info_outline</i>
                                <span class="course-nav-text"><strong>Overview</strong><small>Title, category, pricing &amp; media</small></span>
                            </a>
                        </li>
                        <li role="presentation" class="<?php echo empty($id) ? 'disabled' : ($active_tab === 'curriculum' ? 'active' : ''); ?>">
                            <a href="#curriculum" data-toggle="tab" data-tab="curriculum" data-url="<?php echo $tab_base . '/curriculum'; ?>" <?php echo empty($id) ? 'onclick="return false;"' : ''; ?>>
                                <i class="material-icons">format_list_numbered</i>
                                <span class="course-nav-text"><strong>Curriculum</strong><small>Sections &amp; lectures</small></span>
                                <?php echo empty($id) ? '<span class="course-nav-lock" title="Save the course first"><i class="material-icons">lock</i></span>' : ''; ?>
                            </a>
                        </li>
                        <li role="presentation" class="<?php echo empty($id) ? 'disabled' : ($active_tab === 'learners' ? 'active' : ''); ?>">
                            <a href="#students" data-toggle="tab" data-tab="learners" data-url="<?php echo $tab_base . '/learners'; ?>" <?php echo empty($id) ? 'onclick="return false;"' : ''; ?>>
                                <i class="material-icons">people_outline</i>
                                <span class="course-nav-text"><strong>Learners</strong><small>Enrolled students</small></span>
                                <?php echo empty($id) ? '<span class="course-nav-lock" title="Save the course first"><i class="material-icons">lock</i></span>' : ''; ?>
                            </a>
                        </li>
                    </ul>
                </aside>

                <div class="tab-content course-tabs-content">
                    
                    <!-- Tab 1: Overview (The Main Form) -->
                    <div role="tabpanel" class="tab-pane fade<?php echo $active_tab === 'overview' ? ' in active' : ''; ?>" id="overview">
                        <?php if (!empty($insights)) { $in = $insights; ?>
                        <!-- Course insights -->
                        <div class="ci-wrap">
                            <div class="ci-tiles">
                                <a class="ci-tile" href="#" data-goto="tab:curriculum">
                                    <span class="ci-icon is-indigo"><i class="material-icons">format_list_numbered</i></span>
                                    <span class="ci-body">
                                        <span class="ci-label">Lectures</span>
                                        <strong><?php echo number_format($in['lectures']['published']); ?><small> published</small></strong>
                                        <span class="ci-sub"><?php
                                            $bits = array();
                                            if ($in['lectures']['draft']) $bits[] = $in['lectures']['draft'] . ' draft';
                                            if ($in['lectures']['videos']) $bits[] = $in['lectures']['videos'] . ' video';
                                            if ($in['lectures']['pdfs']) $bits[] = $in['lectures']['pdfs'] . ' PDF';
                                            if ($in['lectures']['drive']) $bits[] = $in['lectures']['drive'] . ' Drive';
                                            $bits[] = $in['sections'] . ' section' . ($in['sections'] == 1 ? '' : 's');
                                            echo htmlspecialchars(implode(' · ', $bits));
                                        ?></span>
                                    </span>
                                </a>
                                <a class="ci-tile" href="#" data-goto="tab:learners">
                                    <span class="ci-icon is-green"><i class="material-icons">groups</i></span>
                                    <span class="ci-body">
                                        <span class="ci-label">Learners</span>
                                        <strong><?php echo number_format($in['learners']['total']); ?><small> enrolled</small></strong>
                                        <span class="ci-sub"><?php echo number_format($in['learners']['active']); ?> with access<?php echo $in['learners']['new_30'] ? ' · <b class="ci-up">+' . number_format($in['learners']['new_30']) . '</b> in 30 days' : ''; ?></span>
                                    </span>
                                </a>
                                <div class="ci-tile">
                                    <span class="ci-icon is-amber"><i class="material-icons">insights</i></span>
                                    <span class="ci-body">
                                        <span class="ci-label">Avg. completion</span>
                                        <?php if ($in['progress']['avg'] === NULL) { ?>
                                            <strong class="ci-muted">—</strong>
                                            <span class="ci-sub">Needs learners and published lectures</span>
                                        <?php } else { ?>
                                            <strong><?php echo (int) $in['progress']['avg']; ?><small>%</small></strong>
                                            <span class="ci-bar"><span style="width: <?php echo min(100, (int) $in['progress']['avg']); ?>%"></span></span>
                                            <span class="ci-sub"><?php echo number_format($in['progress']['started']); ?> started · <?php echo number_format($in['progress']['finished']); ?> finished<?php echo $in['progress']['last_at'] ? ' · last ' . htmlspecialchars(time_elapsed_string($in['progress']['last_at'])) : ''; ?></span>
                                        <?php } ?>
                                    </span>
                                </div>
                                <div class="ci-tile">
                                    <span class="ci-icon is-slate"><i class="material-icons">update</i></span>
                                    <span class="ci-body">
                                        <span class="ci-label">Last updated</span>
                                        <strong class="ci-strong-sm"><?php echo $in['updated'] ? htmlspecialchars(time_elapsed_string($in['updated'])) : '—'; ?></strong>
                                        <span class="ci-sub"><?php echo $in['updated'] ? date('d M Y, g:i A', strtotime($in['updated'])) : ''; ?></span>
                                    </span>
                                </div>
                            </div>

                            <div class="ci-check">
                                <div class="ci-check-head">
                                    <div>
                                        <div class="ci-check-title">Course setup</div>
                                        <div class="ci-sub"><?php echo $in['done']; ?> of <?php echo count($in['checks']); ?> done<?php echo $in['score'] === 100 ? ' — ready for learners' : ''; ?></div>
                                    </div>
                                    <span class="ci-score <?php echo $in['score'] === 100 ? 'is-done' : ($in['score'] >= 60 ? 'is-mid' : 'is-low'); ?>"><?php echo $in['score']; ?>%</span>
                                </div>
                                <span class="ci-bar ci-bar-lg"><span style="width: <?php echo $in['score']; ?>%"></span></span>
                                <ul class="ci-list">
                                    <?php foreach ($in['checks'] as $c) { ?>
                                        <li class="<?php echo $c['ok'] ? 'is-ok' : 'is-todo'; ?>">
                                            <i class="material-icons"><?php echo $c['ok'] ? 'check_circle' : 'radio_button_unchecked'; ?></i>
                                            <span class="ci-item"><?php echo htmlspecialchars($c['label']); ?><span class="ci-sub"><?php echo htmlspecialchars($c['hint']); ?></span></span>
                                            <?php if (!$c['ok']) { ?><a href="#" class="ci-fix" data-goto="<?php echo htmlspecialchars($c['fix']); ?>">Fix</a><?php } ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php } ?>

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
                    <div role="tabpanel" class="tab-pane fade<?php echo $active_tab === 'curriculum' ? ' in active' : ''; ?>" id="curriculum">
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
                                            <button type="button" class="btn btn-default waves-effect" onclick="openBulkAdd()">
                                                <i class="material-icons">playlist_add</i> Bulk Add
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
                    <div role="tabpanel" class="tab-pane fade<?php echo $active_tab === 'learners' ? ' in active' : ''; ?>" id="students">
                        <div class="card lr-card">
                            <div class="header curr-card-head">
                                <div class="curr-card-title">
                                    <div>
                                        <h2>Learners</h2>
                                        <p>People enrolled in this course. Select several to change access or remove them in one go.</p>
                                    </div>
                                    <?php if (!empty($id)) { ?>
                                    <div class="curr-card-buttons">
                                        <button type="button" class="btn btn-primary waves-effect" onclick="enrollLearners()">
                                            <i class="material-icons">group_add</i> Enroll learners
                                        </button>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="body">
                                <?php if (empty($id)) { ?>
                                    <div class="alert alert-info">Please save the course details first to manage learners.</div>
                                <?php } else { ?>
                                    <div class="lr-stats">
                                        <button type="button" class="lr-stat is-active" data-status=""><strong id="lr_stat_total">–</strong> enrolled</button>
                                        <button type="button" class="lr-stat" data-status="active"><span class="lr-dot is-on"></span><strong id="lr_stat_active">–</strong> active</button>
                                        <button type="button" class="lr-stat" data-status="inactive"><span class="lr-dot"></span><strong id="lr_stat_inactive">–</strong> inactive</button>
                                    </div>
                                    <div class="cl-toolbar lr-toolbar">
                                        <div class="cl-search">
                                            <i class="material-icons">search</i>
                                            <input type="text" id="lr_search" placeholder="Search name, email, phone or username…" aria-label="Search learners">
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="students_table" class="table cl-table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width:36px"><label class="curr-check" title="Select all on this page"><input type="checkbox" id="lr_check_all"><span class="curr-check-box"></span></label></th>
                                                    <th>Learner</th>
                                                    <th>Phone</th>
                                                    <th>Enrolled</th>
                                                    <th>Last login</th>
                                                    <th>Access</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
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
            if (window.bulkSelection) bulkSelection.restore(); // keep ticks across reloads
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
            window.learnersTable = $('#students_table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'rt<"cl-foot"lip>',
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100],
                autoWidth: false,
                order: [[3, 'desc']],
                ajax: {
                    url: "<?php echo site_url('admin/courses/learners_list/' . (int) $id); ?>",
                    type: 'POST',
                    data: function (d) { d.status = $('.lr-stat.is-active').data('status') || ''; d[csrf_name] = csrf_token; },
                    dataSrc: function (json) {
                        if (json.stats) $.each(json.stats, function (k, v) { $('#lr_stat_' + k).text(Number(v).toLocaleString()); });
                        return json.data;
                    }
                },
                columns: [
                    { name: 'select', orderable: false },
                    { name: 'name' },
                    { name: 'phone', orderable: false, className: 'cl-hide-sm' },
                    { name: 'enrolled', className: 'cl-hide-xs' },
                    { name: 'last_login', className: 'cl-hide-sm' },
                    { name: 'status' },
                    { name: 'actions', orderable: false, className: 'text-right' }
                ],
                language: {
                    processing: '<div class="cl-loading"><i class="material-icons">sync</i> Loading…</div>',
                    emptyTable: 'No learners yet. Click “Enroll learners” to add some.',
                    zeroRecords: 'No learners match your search.',
                    info: 'Showing _START_–_END_ of _TOTAL_', infoEmpty: 'No learners', infoFiltered: '(filtered from _MAX_)', lengthMenu: 'Show _MENU_',
                    paginate: { previous: '<i class="material-icons">chevron_left</i>', next: '<i class="material-icons">chevron_right</i>' }
                },
                drawCallback: function () { if (window.learnerSelection) learnerSelection.sync(); }
            });
            var lrTimer = null;
            $('#lr_search').on('input', function () {
                var v = $.trim(this.value);
                clearTimeout(lrTimer);
                lrTimer = setTimeout(function () { if (learnersTable.search() !== v) learnersTable.search(v).draw(); }, 400);
            });
            $('.lr-stat').on('click', function () {
                $('.lr-stat').removeClass('is-active'); $(this).addClass('is-active');
                learnersTable.draw();
            });
        }
        $('a[href="#students"][data-toggle="tab"]').on('shown.bs.tab', initStudentsTable);

        // Each tab has its own URL (…/form/{id}/curriculum, …/learners): keep the address bar in sync,
        // and support Back/Forward between tabs.
        var $tabLinks = $('.course-tabs-nav a[data-toggle="tab"][data-url]');
        $tabLinks.on('shown.bs.tab', function () {
            var url = $(this).data('url');
            if (window.history && history.pushState && location.href.split(/[?#]/)[0] !== url) {
                history.pushState({ courseTab: $(this).data('tab') }, '', url + location.search);
            }
        });
        if (window.history && history.replaceState) {
            var $activeLink = $('.course-tabs-nav li.active a[data-tab]');
            var canonical = $activeLink.data('url');
            // Unknown tab names (e.g. …/form/49/abc) open Overview: show its real URL in the address bar
            history.replaceState({ courseTab: $activeLink.data('tab') || 'overview' }, '',
                canonical && location.href.split(/[?#]/)[0] !== canonical ? canonical + location.search : location.href);
        }
        // Insights: "Fix" links / tiles jump to the right tab or field
        $(document).on('click', '[data-goto]', function (e) {
            e.preventDefault();
            var target = String($(this).data('goto'));
            if (target.indexOf('tab:') === 0) {
                $tabLinks.filter('[data-tab="' + target.slice(4) + '"]').tab('show');
                $('html, body').animate({ scrollTop: 0 }, 200);
                return;
            }
            var field = target.slice(6), $el;
            if (field === 'seo') { $('#seo_body').collapse('show'); $el = $('#meta_title'); }
            else if (field === 'images') { $el = $('input[name="images[]"]').first(); }
            else if (field === 'description') { $el = $('#description'); }
            else { $el = $('#' + field); }
            var $box = $el.closest('.form-group, .card').first();
            if (!$box.length) $box = $el;
            $('html, body').animate({ scrollTop: Math.max(0, $box.offset().top - 100) }, 250);
            $box.addClass('ci-flash'); setTimeout(function () { $box.removeClass('ci-flash'); }, 1600);
            if (field === 'description' && window.tinymce && tinymce.get('description')) tinymce.get('description').focus();
            else if (field !== 'images') $el.trigger('focus');
        });

        window.addEventListener('popstate', function (e) {
            var tab = (e.state && e.state.courseTab) || 'overview';
            var $link = $tabLinks.filter('[data-tab="' + tab + '"]');
            if ($link.length && !$link.parent().hasClass('active')) {
                $link.data('fromHistory', true);
                $link.one('shown.bs.tab', function () { $link.removeData('fromHistory'); });
                $link.tab('show');
            }
        });
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

</script>

<!-- ===================== Learners: bulk bar + Enroll dialog ===================== -->
<div class="bulk-bar" id="lrBulkBar" hidden role="toolbar" aria-label="Bulk actions for selected learners">
    <div class="bulk-bar-count"><strong id="lrBulkCount">0</strong> selected</div>
    <div class="bulk-bar-actions">
        <button type="button" class="bulk-btn" data-lr-bulk="activate"><i class="material-icons">check_circle</i><span>Activate access</span></button>
        <button type="button" class="bulk-btn" data-lr-bulk="deactivate"><i class="material-icons">block</i><span>Deactivate access</span></button>
        <button type="button" class="bulk-btn is-danger" data-lr-bulk="remove"><i class="material-icons">person_remove</i><span>Remove from course</span></button>
    </div>
    <button type="button" class="bulk-clear" id="lrBulkClear" title="Clear selection"><i class="material-icons">close</i></button>
</div>

<div class="modal fade" id="enrollmentModal" tabindex="-1" role="dialog" aria-labelledby="enrollTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bulk-add enroll-modal">
            <div class="modal-header">
                <h4 class="modal-title" id="enrollTitle">Enroll learners</h4>
                <p>Pick learners from the list, or paste a list of emails, phone numbers or usernames.</p>
                <div class="enroll-tabs" role="tablist">
                    <button type="button" class="enroll-tab is-active" data-mode="pick" role="tab"><i class="material-icons">checklist</i> Search &amp; select</button>
                    <button type="button" class="enroll-tab" data-mode="paste" role="tab"><i class="material-icons">content_paste</i> Paste a list</button>
                </div>
            </div>
            <div class="modal-body">
                <!-- Pick mode -->
                <div class="enroll-pane" data-pane="pick">
                    <div class="enroll-pick-bar">
                        <div class="cl-search"><i class="material-icons">search</i><input type="text" id="enroll_q" placeholder="Search learners not yet in this course…"></div>
                        <label class="curr-check"><input type="checkbox" id="enroll_all_shown"><span class="curr-check-box"></span><span>Select all shown</span></label>
                    </div>
                    <div class="enroll-list" id="enroll_list"></div>
                    <div class="enroll-list-foot"><span id="enroll_list_info"></span><button type="button" class="btn btn-default btn-sm" id="enroll_more" hidden>Load more</button></div>
                </div>
                <!-- Paste mode -->
                <div class="enroll-pane" data-pane="paste" hidden>
                    <textarea id="enroll_paste" class="bulk-lines" rows="7" spellcheck="false" placeholder="One per line, or separated by commas:&#10;priya@example.com&#10;9876543210&#10;rahul.k"></textarea>
                    <div class="bulk-preview" id="enroll_paste_preview" hidden></div>
                </div>
            </div>
            <div class="modal-footer">
                <label class="curr-check enroll-status"><input type="checkbox" id="enroll_active" checked><span class="curr-check-box"></span><span>Give access now (active)</span></label>
                <span class="bulk-add-note" id="enroll_note"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-default" id="enroll_check" hidden><i class="material-icons">fact_check</i> Check list</button>
                <button type="button" class="btn btn-primary" id="enroll_go" disabled><i class="material-icons">group_add</i> <span>Enroll</span></button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    function esc(t) { return $('<div>').text(t == null ? '' : String(t)).html(); }
    function toast(ok, msg) {
        if (ok && typeof show_success === 'function') return show_success(msg);
        if (!ok && typeof show_danger === 'function') return show_danger(msg);
        swal(ok ? 'Done' : 'Could not update', msg, ok ? 'success' : 'error');
    }
    function reloadLearners() { if (window.learnersTable) learnersTable.ajax.reload(null, false); }

    /* ---------- Selection + bulk actions on enrolled learners ---------- */
    var sel = {};
    function selIds() { return Object.keys(sel); }
    window.learnerSelection = {
        sync: function () {
            var boxes = $('#students_table .js-learner-check');
            boxes.each(function () { this.checked = !!sel[this.value]; $(this).closest('tr').toggleClass('is-selected', this.checked); });
            var on = boxes.filter(':checked').length, all = document.getElementById('lr_check_all');
            if (all) { all.checked = boxes.length > 0 && on === boxes.length; all.indeterminate = on > 0 && on < boxes.length; }
            var n = selIds().length;
            $('#lrBulkCount').text(n);
            $('#lrBulkBar').prop('hidden', n === 0);
            $('body').toggleClass('has-bulk-bar', n > 0);
        },
        clear: function () { sel = {}; this.sync(); }
    };
    $(document).on('change', '.js-learner-check', function () { if (this.checked) sel[this.value] = true; else delete sel[this.value]; learnerSelection.sync(); });
    $(document).on('change', '#lr_check_all', function () {
        var on = this.checked;
        $('#students_table .js-learner-check').each(function () { if (on) sel[this.value] = true; else delete sel[this.value]; });
        learnerSelection.sync();
    });
    $('#lrBulkClear').on('click', function () { learnerSelection.clear(); });
    // Leaving the Learners tab clears its selection (its bar would otherwise sit over other tabs)
    $('a[href="#students"][data-toggle="tab"]').on('hide.bs.tab', function () { learnerSelection.clear(); });

    function learnersAction(action, ids, done) {
        var data = { course_id: courseId, action: action, ids: ids };
        data[csrf_name] = csrf_token;
        $('#lrBulkBar').addClass('is-busy');
        return $.post("<?php echo site_url('admin/courses/learners_bulk'); ?>", data, null, 'json')
            .done(function (res) { toast(res.flag == 1, $('<div>').html(res.msg).text()); if (res.flag == 1 && done) done(); reloadLearners(); })
            .fail(function (xhr) { toast(false, 'Server error (HTTP ' + xhr.status + '). Please try again.'); reloadLearners(); })
            .always(function () { $('#lrBulkBar').removeClass('is-busy'); });
    }
    $('#lrBulkBar').on('click', '[data-lr-bulk]', function () {
        var action = $(this).data('lr-bulk'), ids = selIds(), n = ids.length;
        if (action === 'remove') {
            swal({ title: 'Remove ' + n + ' learner' + (n === 1 ? '' : 's') + ' from this course?', text: 'They will lose access to this course. Their user accounts are not deleted.',
                type: 'warning', showCancelButton: true, confirmButtonColor: '#e11d48', confirmButtonText: 'Yes, remove ' + n, closeOnConfirm: true },
                function (ok) { if (ok !== false) learnersAction('remove', ids, function () { learnerSelection.clear(); }); });
            return;
        }
        learnersAction(action, ids);
    });
    // Row switch + row remove
    window.learnerToggle = function (csId, input) {
        var active = input.checked;
        $(input).closest('.ul-switch').find('.ul-switch-label').text(active ? 'Active' : 'Inactive');
        learnersAction(active ? 'activate' : 'deactivate', [csId]);
    };
    window.learnerRemove = function (csId, name) {
        swal({ title: 'Remove ' + name + ' from this course?', text: 'Their user account is not deleted.', type: 'warning', html: false,
            showCancelButton: true, confirmButtonColor: '#e11d48', confirmButtonText: 'Yes, remove', closeOnConfirm: true },
            function (ok) { if (ok !== false) { delete sel[csId]; learnersAction('remove', [csId]); } });
    };

    /* ---------- Enroll dialog ---------- */
    var picked = {}, mode = 'pick', nextOffset = 0, qTimer = null, pastePreview = null;
    function pickedIds() { return Object.keys(picked); }

    function updateEnrollButton() {
        var n = mode === 'pick' ? pickedIds().length : (pastePreview ? pastePreview.enroll.length : 0);
        $('#enroll_go').prop('disabled', n === 0).find('span').text(n ? 'Enroll ' + n + ' learner' + (n === 1 ? '' : 's') : 'Enroll');
        if (mode === 'pick') $('#enroll_note').text(n ? n + ' selected' : '');
    }
    function syncShownAll() {
        var boxes = $('#enroll_list .js-enroll-pick'), on = boxes.filter(':checked').length, all = document.getElementById('enroll_all_shown');
        all.checked = boxes.length > 0 && on === boxes.length; all.indeterminate = on > 0 && on < boxes.length;
    }
    function loadCandidates(append) {
        if (!append) { nextOffset = 0; $('#enroll_list').html('<div class="enroll-empty"><span class="curr-spinner"></span> Loading…</div>'); }
        var data = { q: $.trim($('#enroll_q').val()), offset: nextOffset };
        data[csrf_name] = csrf_token;
        $.post("<?php echo site_url('admin/courses/learner_candidates/' . (int) $id); ?>", data, null, 'json').done(function (res) {
            var html = '';
            (res.rows || []).forEach(function (u) {
                var initials = (u.name || '?').split(/\s+/).map(function (w) { return w.charAt(0); }).join('').slice(0, 2).toUpperCase();
                html += '<label class="enroll-row"><span class="curr-check"><input type="checkbox" class="js-enroll-pick" value="' + parseInt(u.id, 10) + '"' + (picked[u.id] ? ' checked' : '') + '><span class="curr-check-box"></span></span>'
                    + '<span class="ul-avatar"><span class="ul-initials">' + esc(initials) + '</span>' + (u.image ? '<img src="' + esc(u.image) + '" alt="" loading="lazy" onerror="this.remove()">' : '') + '</span>'
                    + '<span class="ul-user-text"><span class="ul-name">' + esc(u.name) + (u.active != 1 ? ' <span class="lr-flag">Account off</span>' : '') + '</span>'
                    + '<span class="ul-sub">' + esc(u.email) + (u.mobile ? ' · ' + esc(u.mobile) : '') + '</span></span></label>';
            });
            if (!append) $('#enroll_list').html(html || '<div class="enroll-empty">' + (data.q ? 'No learners match “' + esc(data.q) + '” (or they are already enrolled).' : 'Everyone is already enrolled.') + '</div>');
            else $('#enroll_list').append(html);
            nextOffset = res.next;
            $('#enroll_more').prop('hidden', res.next === null);
            $('#enroll_list_info').text(res.total ? 'Showing ' + $('#enroll_list .enroll-row').length + ' of ' + Number(res.total).toLocaleString() : '');
            syncShownAll();
        }).fail(function (xhr) { $('#enroll_list').html('<div class="enroll-empty">Could not load learners (HTTP ' + xhr.status + ').</div>'); });
    }

    window.enrollLearners = function () {
        picked = {}; pastePreview = null; mode = 'pick';
        $('#enroll_q').val(''); $('#enroll_paste').val(''); $('#enroll_paste_preview').prop('hidden', true).empty();
        $('.enroll-tab').removeClass('is-active').filter('[data-mode="pick"]').addClass('is-active');
        $('.enroll-pane').prop('hidden', true).filter('[data-pane="pick"]').prop('hidden', false);
        $('#enroll_check').prop('hidden', true); $('#enroll_note').text('');
        updateEnrollButton();
        $('#enrollmentModal').modal('show');
        loadCandidates(false);
        setTimeout(function () { $('#enroll_q').trigger('focus'); }, 300);
    };
    $('.enroll-tab').on('click', function () {
        mode = $(this).data('mode');
        $('.enroll-tab').removeClass('is-active'); $(this).addClass('is-active');
        $('.enroll-pane').prop('hidden', true).filter('[data-pane="' + mode + '"]').prop('hidden', false);
        $('#enroll_check').prop('hidden', mode !== 'paste');
        $('#enroll_note').text(mode === 'paste' ? (pastePreview ? '' : 'Click “Check list” to see who will be enrolled.') : '');
        updateEnrollButton();
        setTimeout(function () { $(mode === 'pick' ? '#enroll_q' : '#enroll_paste').trigger('focus'); }, 50);
    });
    $('#enroll_q').on('input', function () { clearTimeout(qTimer); qTimer = setTimeout(function () { loadCandidates(false); }, 350); });
    $('#enroll_more').on('click', function () { loadCandidates(true); });
    $(document).on('change', '.js-enroll-pick', function () { if (this.checked) picked[this.value] = true; else delete picked[this.value]; syncShownAll(); updateEnrollButton(); });
    $('#enroll_all_shown').on('change', function () {
        var on = this.checked;
        $('#enroll_list .js-enroll-pick').each(function () { this.checked = on; if (on) picked[this.value] = true; else delete picked[this.value]; });
        updateEnrollButton();
    });

    function enrollPost(extra) {
        var data = $.extend({ course_id: courseId, status: $('#enroll_active').is(':checked') ? 1 : 0 }, extra);
        data[csrf_name] = csrf_token;
        return $.post("<?php echo site_url('admin/courses/learners_enroll'); ?>", data, null, 'json');
    }
    $('#enroll_paste').on('input', function () { pastePreview = null; $('#enroll_paste_preview').prop('hidden', true); $('#enroll_note').text('Click “Check list” to see who will be enrolled.'); updateEnrollButton(); });
    $('#enroll_check').on('click', function () {
        var $b = $(this).prop('disabled', true);
        $('#enroll_note').text('Checking…');
        enrollPost({ list: $('#enroll_paste').val(), preview: 1 }).done(function (res) {
            if (res.flag != 1) { $('#enroll_note').text($('<div>').html(res.msg).text()); return; }
            pastePreview = res;
            var block = function (title, cls, items, fmt) {
                if (!items.length) return '';
                return '<div class="enroll-group ' + cls + '"><div class="enroll-group-title">' + title + ' (' + items.length + ')</div><div class="enroll-chips">'
                    + items.slice(0, 200).map(fmt).join('') + (items.length > 200 ? '<span class="enroll-chip">+' + (items.length - 200) + ' more</span>' : '') + '</div></div>';
            };
            var person = function (u) { return '<span class="enroll-chip" title="' + esc(u.email) + '">' + esc(u.name) + '</span>'; };
            $('#enroll_paste_preview').html(
                block('Will be enrolled', 'is-ok', res.enroll, person) +
                block('Already enrolled — skipped', 'is-skip', res.already, person) +
                block('Not found — skipped', 'is-bad', res.not_found, function (t) { return '<span class="enroll-chip">' + esc(t) + '</span>'; }) ||
                '<div class="enroll-empty">Paste at least one email, phone number or username.</div>'
            ).prop('hidden', false);
            $('#enroll_note').text(res.enroll.length ? '' : 'Nobody new to enroll.');
            updateEnrollButton();
        }).fail(function (xhr) { $('#enroll_note').text('Server error (HTTP ' + xhr.status + ').'); })
          .always(function () { $b.prop('disabled', false); });
    });
    $('#enroll_go').on('click', function () {
        var $b = $(this).prop('disabled', true);
        var extra = mode === 'pick' ? { user_ids: pickedIds() } : { user_ids: pastePreview.enroll.map(function (u) { return u.id; }) };
        enrollPost(extra).done(function (res) {
            if (res.flag == 1) {
                $('#enrollmentModal').modal('hide');
                toast(true, res.msg);
                if (!window.learnersTable && typeof initStudentsTable === 'function') initStudentsTable();
                reloadLearners();
            } else { $('#enroll_note').text($('<div>').html(res.msg).text()); $b.prop('disabled', false); }
        }).fail(function (xhr) { $('#enroll_note').text('Server error (HTTP ' + xhr.status + ').'); $b.prop('disabled', false); });
    });
})();
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

<!-- ===================== Bulk actions for lectures ===================== -->
<div class="bulk-bar" id="bulkBar" hidden role="toolbar" aria-label="Bulk actions for selected lectures">
    <div class="bulk-bar-count"><strong id="bulkCount">0</strong> selected</div>
    <div class="bulk-bar-actions">
        <button type="button" class="bulk-btn" data-bulk="publish" title="Make visible to learners"><i class="material-icons">visibility</i><span>Publish</span></button>
        <button type="button" class="bulk-btn" data-bulk="unpublish" title="Hide from learners (draft)"><i class="material-icons">visibility_off</i><span>Unpublish</span></button>
        <button type="button" class="bulk-btn" data-bulk="secure" title="Only enrolled learners can open"><i class="material-icons">lock</i><span>Secure</span></button>
        <button type="button" class="bulk-btn" data-bulk="public" title="Anyone can preview"><i class="material-icons">public</i><span>Public</span></button>
        <div class="bulk-move">
            <button type="button" class="bulk-btn" id="bulkMoveBtn" aria-haspopup="true"><i class="material-icons">drive_file_move</i><span>Move to…</span></button>
            <div class="bulk-move-menu" id="bulkMoveMenu" hidden role="menu"></div>
        </div>
        <button type="button" class="bulk-btn is-danger" data-bulk="delete" title="Delete selected lectures"><i class="material-icons">delete_outline</i><span>Delete</span></button>
    </div>
    <button type="button" class="bulk-clear" id="bulkClear" title="Clear selection"><i class="material-icons">close</i></button>
</div>

<!-- Bulk add lectures -->
<div class="modal fade" id="bulkAddModal" tabindex="-1" role="dialog" aria-labelledby="bulkAddTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bulk-add">
            <div class="modal-header">
                <h4 class="modal-title" id="bulkAddTitle">Bulk add lectures</h4>
                <p>Paste one lecture per line: <code>Title | URL</code>, or just a YouTube link (the title is fetched for you). Rows copied from a spreadsheet (title, URL) work too.</p>
            </div>
            <div class="modal-body">
                <div class="bulk-add-grid">
                    <div class="form-group">
                        <label class="lf-label" for="bulk_section">Add to section</label>
                        <select id="bulk_section" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label class="lf-label" for="bulk_type">Content type</label>
                        <select id="bulk_type" class="form-control">
                            <option value="3">YouTube / Vimeo</option>
                            <option value="1">Google Drive</option>
                            <option value="2">PDF Document</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="lf-label" for="bulk_status">Status</label>
                        <select id="bulk_status" class="form-control">
                            <option value="1">Published</option>
                            <option value="0">Draft</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="lf-label" for="bulk_secure">Access</label>
                        <select id="bulk_secure" class="form-control">
                            <option value="1">Secure (enrolled only)</option>
                            <option value="0">Public preview</option>
                        </select>
                    </div>
                </div>
                <textarea id="bulk_lines" class="bulk-lines" rows="8" spellcheck="false" placeholder="Intro to Spark | https://www.youtube.com/watch?v=xxxxxxxxxxx&#10;https://youtu.be/yyyyyyyyyyy&#10;Week 1 notes | https://drive.google.com/file/d/…"></textarea>
                <div class="bulk-preview" id="bulkPreview" hidden></div>
            </div>
            <div class="modal-footer">
                <span class="bulk-add-note" id="bulkAddNote"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-default" id="bulkPreviewBtn"><i class="material-icons">visibility</i> Preview</button>
                <button type="button" class="btn btn-primary" id="bulkAddBtn" disabled><i class="material-icons">playlist_add</i> <span>Add lectures</span></button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var selected = {};      // lecture id -> true (survives curriculum reloads)
    var lastClicked = null; // for shift-click range selection

    function ids() { return Object.keys(selected); }
    function esc(t) { return $('<div>').text(t == null ? '' : String(t)).html(); }

    function sync() {
        var $c = $('#curriculum_container');
        var all = $c.find('.js-select-lecture');
        all.each(function () {
            this.checked = !!selected[this.value];
            $(this).closest('.curr-lecture').toggleClass('is-selected', this.checked);
        });
        $c.find('.curr-section').each(function () {
            var boxes = $(this).find('.js-select-lecture'), on = boxes.filter(':checked').length;
            var head = $(this).find('.js-select-section')[0];
            if (head) { head.checked = boxes.length > 0 && on === boxes.length; head.indeterminate = on > 0 && on < boxes.length; }
        });
        var total = all.length, on = all.filter(':checked').length, sa = $c.find('.js-select-all')[0];
        if (sa) { sa.checked = total > 0 && on === total; sa.indeterminate = on > 0 && on < total; }

        // Drop ids that no longer exist (deleted / reloaded)
        var present = {}; all.each(function () { present[this.value] = 1; });
        Object.keys(selected).forEach(function (id) { if (!present[id]) delete selected[id]; });

        var n = ids().length;
        $('#bulkCount').text(n);
        $('#bulkBar').prop('hidden', n === 0);
        $('body').toggleClass('has-bulk-bar', n > 0);
    }

    window.bulkSelection = { restore: sync, clear: function () { selected = {}; lastClicked = null; sync(); } };

    // Lecture checkbox (shift-click selects the range from the last click)
    $(document).on('click', '.js-select-lecture', function (e) {
        var boxes = $('#curriculum_container .js-select-lecture'), idx = boxes.index(this);
        if (e.shiftKey && lastClicked !== null && lastClicked !== idx) {
            var from = Math.min(lastClicked, idx), to = Math.max(lastClicked, idx);
            boxes.slice(from, to + 1).each(function () { if (this.checked !== undefined) { if (e.target.checked) selected[this.value] = true; else delete selected[this.value]; } });
        } else {
            if (this.checked) selected[this.value] = true; else delete selected[this.value];
        }
        lastClicked = idx;
        sync();
    });
    $(document).on('change', '.js-select-section', function () {
        var on = this.checked;
        $(this).closest('.curr-section').find('.js-select-lecture').each(function () { if (on) selected[this.value] = true; else delete selected[this.value]; });
        sync();
    });
    $(document).on('change', '.js-select-all', function () {
        var on = this.checked;
        $('#curriculum_container .js-select-lecture').each(function () { if (on) selected[this.value] = true; else delete selected[this.value]; });
        sync();
    });
    // Clicking the checkbox must not start a drag or toggle the section
    $(document).on('mousedown click', '.curr-check', function (e) { e.stopPropagation(); });

    $('#bulkClear').on('click', function () { window.bulkSelection.clear(); });
    $(document).on('keydown', function (e) { if (e.key === 'Escape' && ids().length && !$('.modal.in, .modal.show').length) window.bulkSelection.clear(); });

    function runBulk(action, extra) {
        var n = ids().length;
        var data = $.extend({ course_id: courseId, action: action, ids: ids() }, extra || {});
        data[csrf_name] = csrf_token;
        $('#bulkBar').addClass('is-busy');
        $.post("<?php echo site_url('admin/courses/lecture_bulk'); ?>", data, null, 'json')
            .done(function (res) {
                if (res.flag == 1) {
                    if (typeof show_success === 'function') show_success(res.msg); else swal('Done', res.msg, 'success');
                    if (action === 'delete' || action === 'move') window.bulkSelection.clear();
                    loadCurriculum();
                } else {
                    swal('Could not update', $('<div>').html(res.msg).text(), 'error');
                }
            })
            .fail(function (xhr) { swal('Could not update', 'Server error (HTTP ' + xhr.status + '). Please try again.', 'error'); })
            .always(function () { $('#bulkBar').removeClass('is-busy'); });
    }

    $('#bulkBar').on('click', '[data-bulk]', function () {
        var action = $(this).data('bulk'), n = ids().length;
        if (action === 'delete') {
            swal({
                title: 'Delete ' + n + ' lecture' + (n === 1 ? '' : 's') + '?',
                text: 'This cannot be undone. Learner progress for these lectures may be lost.',
                type: 'warning', showCancelButton: true, confirmButtonColor: '#e11d48',
                confirmButtonText: 'Yes, delete ' + n, closeOnConfirm: true
            }, function (ok) { if (ok !== false) runBulk('delete'); });
            return;
        }
        runBulk(action);
    });

    // Move to… menu lists the course's sections from the page
    $('#bulkMoveBtn').on('click', function (e) {
        e.stopPropagation();
        var html = '<button type="button" class="bulk-move-item" data-section="0">General / Uncategorized</button>';
        $('#curriculum_container .curr-section').each(function () {
            var id = $(this).data('section-id');
            if (id != 0) html += '<button type="button" class="bulk-move-item" data-section="' + parseInt(id, 10) + '">' + esc($(this).find('.curr-section-title').first().text()) + '</button>';
        });
        $('#bulkMoveMenu').html(html).prop('hidden', !$('#bulkMoveMenu').prop('hidden'));
    });
    $(document).on('click', '.bulk-move-item', function () {
        $('#bulkMoveMenu').prop('hidden', true);
        runBulk('move', { section_id: $(this).data('section') });
    });
    $(document).on('click', function () { $('#bulkMoveMenu').prop('hidden', true); });

    /* ---------- Bulk add ---------- */
    var previewOk = false;
    window.openBulkAdd = function (sectionId) {
        var opts = '<option value="0">General / Uncategorized</option>';
        $('#curriculum_container .curr-section').each(function () {
            var id = $(this).data('section-id');
            if (id != 0) opts += '<option value="' + parseInt(id, 10) + '">' + esc($(this).find('.curr-section-title').first().text()) + '</option>';
        });
        $('#bulk_section').html(opts).val(String(sectionId || 0));
        $('#bulkAddModal select').each(function () { if ($.fn.selectpicker && $(this).data('selectpicker')) $(this).selectpicker('refresh'); });
        previewOk = false; $('#bulkAddBtn').prop('disabled', true); $('#bulkPreview').prop('hidden', true).empty(); $('#bulkAddNote').text('');
        $('#bulkAddModal').modal('show');
        setTimeout(function () { $('#bulk_lines').trigger('focus'); }, 300);
    };
    // Any change invalidates the preview
    $('#bulk_lines, #bulk_type').on('input change', function () { previewOk = false; $('#bulkAddBtn').prop('disabled', true); $('#bulkAddNote').text('Preview to check the lines before adding.'); });

    function bulkPost(preview) {
        var data = {
            course_id: courseId, section_id: $('#bulk_section').val(), category: $('#bulk_type').val(),
            status: $('#bulk_status').val(), featured: $('#bulk_secure').val(), lines: $('#bulk_lines').val(), preview: preview ? 1 : 0
        };
        data[csrf_name] = csrf_token;
        return $.post("<?php echo site_url('admin/courses/lecture_bulk_add'); ?>", data, null, 'json');
    }
    function renderPreview(rows) {
        var bad = 0, html = '<table><thead><tr><th>#</th><th>Title</th><th>URL / File ID</th></tr></thead><tbody>';
        rows.forEach(function (r) {
            if (r.error) bad++;
            html += '<tr class="' + (r.error ? 'is-error' : '') + '"><td>' + r.line + '</td><td>' + esc(r.title || '—') + '</td><td>' + esc(r.url)
                + (r.error ? '<div class="bulk-row-error">' + esc(r.error) + '</div>' : '') + '</td></tr>';
        });
        $('#bulkPreview').html(html + '</tbody></table>').prop('hidden', false);
        return bad;
    }
    $('#bulkPreviewBtn').on('click', function () {
        var $b = $(this).prop('disabled', true);
        $('#bulkAddNote').text('Checking lines…');
        bulkPost(true).done(function (res) {
            if (res.flag != 1) { $('#bulkAddNote').text(res.msg); return; }
            var bad = renderPreview(res.rows);
            previewOk = bad === 0;
            $('#bulkAddBtn').prop('disabled', !previewOk).find('span').text(previewOk ? 'Add ' + res.valid + ' lecture' + (res.valid === 1 ? '' : 's') : 'Add lectures');
            $('#bulkAddNote').text(bad ? bad + ' line' + (bad === 1 ? ' needs' : 's need') + ' fixing (in red).' : 'Looks good.');
        }).fail(function (xhr) { $('#bulkAddNote').text('Server error (HTTP ' + xhr.status + ').'); })
          .always(function () { $b.prop('disabled', false); });
    });
    $('#bulkAddBtn').on('click', function () {
        if (!previewOk) return;
        var $b = $(this).prop('disabled', true);
        bulkPost(false).done(function (res) {
            if (res.flag == 1) {
                $('#bulkAddModal').modal('hide');
                $('#bulk_lines').val('');
                if (typeof show_success === 'function') show_success(res.msg); else swal('Done', res.msg, 'success');
                loadCurriculum();
            } else {
                if (res.rows) renderPreview(res.rows);
                $('#bulkAddNote').text($('<div>').html(res.msg).text());
                $b.prop('disabled', false);
            }
        }).fail(function (xhr) { $('#bulkAddNote').text('Server error (HTTP ' + xhr.status + ').'); $b.prop('disabled', false); });
    });
})();
</script>
<?php } ?>