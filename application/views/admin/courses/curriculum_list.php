<div id="curriculum-sections">
    <?php if(!empty($curriculum)): ?>
        <?php foreach($curriculum as $section): ?>
            <div class="panel-group" id="accordion_<?php echo $section['id']; ?>" role="tablist" aria-multiselectable="true" style="margin-bottom: 10px;" data-section-id="<?php echo $section['id']; ?>">
                <div class="panel panel-default" style="border: 1px solid #ddd; border-radius: 4px; overflow: visible;">
                    <div class="panel-heading" role="tab" id="heading_<?php echo $section['id']; ?>" style="background-color: #f5f5f5; padding: 10px 15px; display: flex; align-items: center; justify-content: space-between;">
                        <h4 class="panel-title" style="margin: 0; font-size: 14px; font-weight: 600; display: flex; align-items: center; width: 100%;">
                            <a class="section-drag-handle" href="javascript:void(0);" style="cursor: move; margin-right: 10px; color: #999;">
                                <i class="material-icons">drag_handle</i>
                            </a>
                            <a role="button" data-toggle="collapse" data-parent="#accordion_<?php echo $section['id']; ?>" href="#collapse_<?php echo $section['id']; ?>" aria-expanded="true" aria-controls="collapse_<?php echo $section['id']; ?>" style="color: #333; text-decoration: none; flex-grow: 1;">
                                <?php echo $section['id'] == 0 ? 'General / Uncategorized' : $section['title']; ?>
                            </a>
                        </h4>
                        <div class="section-actions" style="min-width: 100px; text-align: right;">
                             <?php if($section['id'] != 0): ?>
                            <a href="javascript:void(0);" onclick="editSection(<?php echo $section['id']; ?>, '<?php echo addslashes($section['title']); ?>')" class="btn btn-default btn-xs waves-effect" title="Edit Section"><i class="material-icons" style="font-size: 16px;">edit</i></a>
                            <a href="javascript:void(0);" onclick="deleteSection(<?php echo $section['id']; ?>)" class="btn btn-danger btn-xs waves-effect" title="Delete Section"><i class="material-icons" style="font-size: 16px;">delete</i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div id="collapse_<?php echo $section['id']; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_<?php echo $section['id']; ?>">
                        <div class="panel-body" style="padding: 15px; background-color: #fff;">
                            <!-- Lectures List -->
                            <ul class="list-unstyled lecture-list" data-section-id="<?php echo $section['id']; ?>" style="min-height: 50px; margin-bottom: 0;">
                                <?php if(!empty($section['lectures'])): ?>
                                    <?php foreach($section['lectures'] as $lecture): ?>
                                        <li class="card m-b-10" data-id="<?php echo $lecture['id']; ?>" style="cursor: move; border: 1px solid #eee; box-shadow: none; margin-bottom: 5px;">
                                            <div class="body" style="padding: 8px 10px;">
                                                <div class="media" style="display: flex; align-items: center;">
                                                    <div class="media-left">
                                                        <a href="javascript:void(0);" class="lecture-drag-handle" style="cursor: move;">
                                                            <i class="material-icons text-muted" style="font-size: 18px;">drag_indicator</i>
                                                        </a>
                                                    </div>
                                                    <div class="media-left">
                                                        <?php
                                                            $icon = 'insert_drive_file';
                                                            $color = 'bg-grey';
                                                            if($lecture['cl_type'] == '3') { $icon = 'play_circle_filled'; $color='bg-red'; }
                                                            elseif($lecture['cl_type'] == '2') { $icon = 'picture_as_pdf'; $color='bg-amber'; }
                                                            elseif($lecture['cl_type'] == '1') { $icon = 'cloud_queue'; $color='bg-blue'; }
                                                        ?>
                                                        <i class="material-icons <?php echo $color; ?>" style="font-size: 18px; color: white; padding: 4px; border-radius: 4px;"><?php echo $icon; ?></i>
                                                    </div>
                                                    <div class="media-body" style="width: 100%; padding-left: 10px;">
                                                        <h4 class="media-heading" style="font-size: 14px; margin-bottom: 2px; color: #444;"><?php echo $lecture['cl_name']; ?></h4>
                                                        <p style="margin: 0; color: #999; font-size: 11px;">
                                                            <?php echo $lecture['cl_file_name']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="media-right" style="display: flex; align-items: center; min-width: 100px; justify-content: flex-end;">
                                                         <span class="label label-<?php echo ($lecture['cl_secure'] == 1) ? 'success' : 'default'; ?>" style="margin-right: 5px; font-size: 10px;">
                                                                <?php echo ($lecture['cl_secure'] == 1) ? 'Active' : 'Draft'; ?>
                                                            </span>
                                                        <a href="javascript:void(0);" onclick="editLecture(<?php echo $lecture['id']; ?>)" class="text-blue" style="margin: 0 5px;" title="Edit">
                                                            <i class="material-icons" style="font-size: 16px;">edit</i>
                                                        </a>
                                                        <a href="javascript:void(0);" onclick="deleteLecture(<?php echo $lecture['id']; ?>)" class="text-red" style="margin: 0 5px;" title="Delete">
                                                            <i class="material-icons" style="font-size: 16px;">delete</i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="empty-placeholder text-center text-muted" style="padding: 10px; border: 1px dashed #ddd; font-size: 12px;">Drag lectures here or add new one</li>
                                <?php endif; ?>
                            </ul>
                            
                            <!-- Add Lecture Button -->
                             <div style="text-align: center; margin-top: 10px; border-top: 1px dashed #eee; padding-top: 10px;">
                                 <button type="button" class="btn btn-default btn-sm waves-effect" onclick="addLectureToSection(<?php echo $section['id']; ?>)">
                                    <i class="material-icons" style="font-size: 14px;">add</i> Add Lecture
                                 </button>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center p-20">
            <p class="text-muted">No sections found. Start by adding a section.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Add Section Button (Floating or Fixed at bottom) -->
<div class="row clearfix m-t-20">
    <div class="col-xs-12 text-center">
        <button type="button" class="btn btn-primary btn-lg waves-effect" onclick="addSection()">
            <i class="material-icons">view_stream</i> ADD NEW SECTION
        </button>
    </div>
</div>

<script>
    // 1. Initialize Sortable for Sections
    if(typeof sectionSortable !== 'undefined') sectionSortable.destroy();
    var sectionEl = document.getElementById('curriculum-sections');
    var sectionSortable = Sortable.create(sectionEl, {
        handle: '.section-drag-handle',
        animation: 150,
        onEnd: function (evt) {
            var newOrder = [];
            $('#curriculum-sections > .panel-group').each(function() {
                newOrder.push($(this).data('section-id'));
            });
            
             // Sort Sections AJAX
             $.ajax({
                url: "<?php echo site_url('admin/courses/sort_section'); ?>",
                type: 'POST',
                data: {sections: newOrder},
                dataType: 'json',
                success: function(response) {
                    if(response.flag == 1) {
                         // Notification or silent success
                    }
                }
            });
        }
    });

    // 2. Initialize Sortable for Lectures (Nested)
    // We need to initialize for each list, allowing dragging between them
    var lectureLists = document.querySelectorAll('.lecture-list');
    lectureLists.forEach(function (el) {
        Sortable.create(el, {
            group: 'lectures', // Allow dragging between lists
            handle: '.lecture-drag-handle',
            animation: 150,
            ghostClass: 'blue-background-class',
            onEnd: function (evt) {
                var itemEl = evt.item;
                var newSectionId = evt.to.getAttribute('data-section-id');
                var newOrder = [];
                
                // Get order of the target list
                 $(evt.to).find('li.card').each(function() {
                     newOrder.push($(this).data('id'));
                 });

                 // Sort Lectures AJAX
                 $.ajax({
                    url: "<?php echo site_url('admin/courses/sort_lecture'); ?>",
                    type: 'POST',
                    data: {
                        lectures: newOrder, 
                        section_id: newSectionId
                    },
                    dataType: 'json',
                    success: function(response) {
                         // Notification or silent success
                    }
                });
            }
        });
    });
</script>