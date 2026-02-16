<div id="curriculum-sections">
    <?php if (!empty($curriculum)): ?>
        <?php foreach ($curriculum as $section): ?>
            <div class="panel-group section-item" id="accordion_<?php echo $section['id']; ?>" role="tablist"
                aria-multiselectable="true" style="margin-bottom: 10px;" data-section-id="<?php echo $section['id']; ?>">
                <div class="panel panel-default"
                    style="border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px;">
                    <div class="panel-heading" role="tab" id="heading_<?php echo $section['id']; ?>"
                        style="background-color: #fff; padding: 12px 20px; display: flex; align-items: center; border-left: 5px solid #2196F3; border-bottom: 1px solid #f0f0f0;">
                        <div style="display: flex; align-items: center; flex-grow: 1; min-width: 0;">
                            <a class="section-drag-handle" href="javascript:void(0);"
                                style="cursor: move; margin-right: 15px; color: #ccc; transition: color 0.3s; flex-shrink: 0;">
                                <i class="material-icons" style="font-size: 20px;">drag_handle</i>
                            </a>
                            <a role="button" data-toggle="collapse" data-parent="#accordion_<?php echo $section['id']; ?>"
                                href="#collapse_<?php echo $section['id']; ?>" aria-expanded="true"
                                aria-controls="collapse_<?php echo $section['id']; ?>"
                                style="color: #333; text-decoration: none; display: flex; align-items: center; min-width: 0; flex-grow: 1;">
                                <span
                                    style="font-size: 15px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?php echo $section['id'] == 0 ? 'General / Uncategorized' : $section['title']; ?>
                                </span>
                                <i class="material-icons text-muted"
                                    style="font-size: 18px; margin-left: 8px; flex-shrink: 0;">keyboard_arrow_down</i>
                            </a>
                        </div>
                        <div class="section-actions"
                            style="margin-left: 15px; flex-shrink: 0; display: flex; align-items: center;">
                            <?php if ($section['id'] != 0): ?>
                                <a href="javascript:void(0);"
                                    onclick="editSection(<?php echo $section['id']; ?>, '<?php echo addslashes($section['title']); ?>')"
                                    class="btn btn-default btn-circle waves-effect"
                                    style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center; margin-right: 5px;"
                                    title="Edit Section">
                                    <i class="material-icons" style="font-size: 18px; color: #666;">edit</i>
                                </a>
                                <a href="javascript:void(0);" onclick="deleteSection(<?php echo $section['id']; ?>)"
                                    class="btn btn-default btn-circle waves-effect"
                                    style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;"
                                    title="Delete Section">
                                    <i class="material-icons" style="font-size: 18px; color: #F44336;">delete</i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div id="collapse_<?php echo $section['id']; ?>" class="panel-collapse collapse in" role="tabpanel"
                        aria-labelledby="heading_<?php echo $section['id']; ?>">
                        <div class="panel-body" style="padding: 15px; background-color: #fcfcfc;">
                            <!-- Lectures List -->
                            <ul class="list-unstyled lecture-list" data-section-id="<?php echo $section['id']; ?>"
                                style="min-height: 50px; margin-bottom: 0;">
                                <?php if (!empty($section['lectures'])): ?>
                                    <?php foreach ($section['lectures'] as $lecture): ?>
                                        <li class="card m-b-10" data-id="<?php echo $lecture['id']; ?>"
                                            style="cursor: move; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.03); margin-bottom: 10px; border-radius: 8px; background: #fff; transition: all 0.3s; border: 1px solid #f0f0f0;">
                                            <div class="body" style="padding: 12px 15px;">
                                                <div class="media" style="display: flex; align-items: center; margin: 0; width: 100%;">
                                                    <div class="media-left" style="padding-right: 12px; flex-shrink: 0;">
                                                        <a href="javascript:void(0);" class="lecture-drag-handle"
                                                            style="cursor: move; color: #ddd;">
                                                            <i class="material-icons" style="font-size: 20px;">drag_indicator</i>
                                                        </a>
                                                    </div>
                                                    <div class="media-left" style="padding-right: 12px; flex-shrink: 0;">
                                                        <?php
                                                        $icon = 'insert_drive_file';
                                                        $color = 'bg-grey';
                                                        if ($lecture['cl_type'] == '3') {
                                                            $icon = 'play_circle_filled';
                                                            $color = 'bg-red';
                                                        } elseif ($lecture['cl_type'] == '2') {
                                                            $icon = 'picture_as_pdf';
                                                            $color = 'bg-amber';
                                                        } elseif ($lecture['cl_type'] == '1') {
                                                            $icon = 'cloud_queue';
                                                            $color = 'bg-blue';
                                                        }
                                                        ?>
                                                        <div class="<?php echo $color; ?>"
                                                            style="width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="material-icons"
                                                                style="font-size: 20px; color: white;"><?php echo $icon; ?></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body" style="min-width: 0; flex-grow: 1;">
                                                        <h4 class="media-heading"
                                                            style="font-size: 14px; margin-bottom: 2px; font-weight: 600; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                            <?php echo $lecture['cl_name']; ?></h4>
                                                        <p
                                                            style="margin: 0; color: #888; font-size: 11px; display: flex; align-items: center;">
                                                            <i class="material-icons"
                                                                style="font-size: 12px; margin-right: 4px;">link</i>
                                                            <span
                                                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                                <?php echo $lecture['cl_file_name']; ?>
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div class="media-right"
                                                        style="flex-shrink: 0; display: flex; align-items: center; padding-left: 15px;">
                                                        <span
                                                            class="label label-<?php echo ($lecture['cl_status'] == 1) ? 'success' : 'default'; ?>"
                                                            style="margin-right: 8px; padding: 3px 6px; border-radius: 4px; font-size: 10px; text-transform: uppercase;">
                                                            <?php echo ($lecture['cl_status'] == 1) ? 'Active' : 'Draft'; ?>
                                                        </span>
                                                        <?php if ($lecture['cl_secure'] == 1): ?>
                                                            <i class="material-icons text-success" title="Secure Content"
                                                                style="font-size: 18px; margin-right: 8px;">lock</i>
                                                        <?php else: ?>
                                                            <i class="material-icons text-muted" title="Public Content"
                                                                style="font-size: 18px; margin-right: 8px;">lock_open</i>
                                                        <?php endif; ?>
                                                        <a href="javascript:void(0);"
                                                            onclick="editLecture(<?php echo $lecture['id']; ?>)"
                                                            class="btn btn-default btn-circle waves-effect" title="Edit"
                                                            style="width: 28px; height: 28px; padding: 0; display: flex; align-items: center; justify-content: center; margin-right: 5px;">
                                                            <i class="material-icons" style="font-size: 15px; color: #2196F3;">edit</i>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            onclick="deleteLecture(<?php echo $lecture['id']; ?>)"
                                                            class="btn btn-default btn-circle waves-effect" title="Delete"
                                                            style="width: 28px; height: 28px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                                            <i class="material-icons"
                                                                style="font-size: 15px; color: #F44336;">delete</i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="empty-placeholder text-center text-muted"
                                        style="padding: 15px; border: 1px dashed #ddd; font-size: 12px; border-radius: 8px; margin-bottom: 10px; background: #fff;">
                                        Drag lectures here or add new one</li>
                                <?php endif; ?>
                            </ul>

                            <!-- Add Lecture Button -->
                            <div style="text-align: center; margin-top: 10px;">
                                <button type="button" class="btn btn-default btn-xs waves-effect"
                                    onclick="addLectureToSection(<?php echo $section['id']; ?>)"
                                    style="padding: 5px 15px; border-radius: 20px; color: #2196F3; border-color: #2196F3;">
                                    <i class="material-icons" style="font-size: 14px; vertical-align: middle;">add</i> ADD
                                    LECTURE
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

<!-- Add Section Button -->
<div class="row clearfix m-t-20">
    <div class="col-xs-12 text-center">
        <button type="button" class="btn btn-primary btn-lg waves-effect" onclick="addSection()"
            style="border-radius: 30px; padding: 10px 30px; font-weight: 700;">
            <i class="material-icons">view_stream</i> ADD NEW SECTION
        </button>
    </div>
</div>

<script>
    // Helper to reload orders for all lectures in a group
    function updateLectureOrders(sectionId, listEl) {
        var newOrder = [];
        $(listEl).find('li.card').each(function () {
            newOrder.push($(this).data('id'));
        });

        if (newOrder.length > 0) {
            $.ajax({
                url: "<?php echo site_url('admin/courses/sort_lecture'); ?>",
                type: 'POST',
                data: {
                    lectures: newOrder,
                    section_id: sectionId,
                    csrf_token: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json'
            });
        }
    }

    // 1. Initialize Sortable for Sections
    var sectionEl = document.getElementById('curriculum-sections');
    Sortable.create(sectionEl, {
        handle: '.section-drag-handle',
        animation: 150,
        onEnd: function (evt) {
            var newOrder = [];
            $('#curriculum-sections > .section-item').each(function () {
                newOrder.push($(this).data('section-id'));
            });

            $.ajax({
                url: "<?php echo site_url('admin/courses/sort_section'); ?>",
                type: 'POST',
                data: {
                    sections: newOrder,
                    csrf_token: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json'
            });
        }
    });

    // 2. Initialize Sortable for Lectures (Nested)
    var lectureLists = document.querySelectorAll('.lecture-list');
    lectureLists.forEach(function (el) {
        Sortable.create(el, {
            group: 'lectures',
            handle: '.lecture-drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function (evt) {
                // When an item is moved within a list OR between lists:
                // evt.to is the list the item moved into
                // evt.from is the list the item was taken from

                var targetSectionId = evt.to.getAttribute('data-section-id');
                var sourceSectionId = evt.from.getAttribute('data-section-id');

                // Update orders for the target list (always necessary)
                updateLectureOrders(targetSectionId, evt.to);

                // If moved between sections, ALSO update the source list orders (to fix gaps/indices)
                if (targetSectionId !== sourceSectionId) {
                    updateLectureOrders(sourceSectionId, evt.from);
                }
            }
        });
    });
</script>

<style>
    .sortable-ghost {
        opacity: 0.4;
        background-color: #e3f2fd !important;
        border: 2px dashed #2196F3 !important;
    }

    .sortable-chosen {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .section-drag-handle:hover {
        color: #2196F3 !important;
    }

    .lecture-drag-handle:hover {
        color: #2196F3 !important;
    }

    .lecture-list li.card:hover {
        border-color: #2196F3 !important;
        transform: translateY(-2px);
    }
</style>