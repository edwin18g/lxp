<?php defined('BASEPATH') OR exit('No direct script access allowed');

$type_meta = array(
    '1' => array('icon' => 'cloud_queue', 'label' => 'Google Drive', 'class' => 'type-drive'),
    '2' => array('icon' => 'picture_as_pdf', 'label' => 'PDF', 'class' => 'type-pdf'),
    '3' => array('icon' => 'play_arrow', 'label' => 'Video', 'class' => 'type-video'),
);
$default_type = array('icon' => 'insert_drive_file', 'label' => 'File', 'class' => 'type-file');

// Summary counts
$total_lectures = 0;
$type_counts = array('1' => 0, '2' => 0, '3' => 0);
$real_sections = 0;
foreach ((array) $curriculum as $s) {
    if ($s['id'] != 0) $real_sections++;
    foreach ($s['lectures'] as $l) {
        $total_lectures++;
        if (isset($type_counts[$l['cl_type']])) $type_counts[$l['cl_type']]++;
    }
}
?>

<?php if (!empty($curriculum)): ?>
    <!-- Summary -->
    <div class="curr-summary">
        <span class="curr-stat"><i class="material-icons">view_agenda</i> <strong><?php echo $real_sections; ?></strong> section<?php echo $real_sections == 1 ? '' : 's'; ?></span>
        <span class="curr-stat"><i class="material-icons">format_list_numbered</i> <strong><?php echo $total_lectures; ?></strong> lecture<?php echo $total_lectures == 1 ? '' : 's'; ?></span>
        <?php foreach ($type_counts as $t => $n): if (!$n) continue; ?>
            <span class="curr-stat <?php echo $type_meta[$t]['class']; ?>"><i class="material-icons"><?php echo $type_meta[$t]['icon']; ?></i> <?php echo $n . ' ' . $type_meta[$t]['label']; ?></span>
        <?php endforeach; ?>
        <span class="curr-hint"><i class="material-icons">drag_indicator</i> Drag to reorder</span>
    </div>
<?php endif; ?>

<div id="curriculum-sections">
    <?php if (!empty($curriculum)): ?>
        <?php $section_no = 0; $lecture_no = 0; ?>
        <?php foreach ($curriculum as $section): ?>
            <?php
            $is_general = ($section['id'] == 0);
            if (!$is_general) $section_no++;
            $section_title = $is_general ? 'General / Uncategorized' : $section['title'];
            $count = count($section['lectures']);
            ?>
            <div class="section-item curr-section<?php echo $is_general ? ' is-general' : ''; ?>" data-section-id="<?php echo $section['id']; ?>">
                <div class="curr-section-head">
                    <?php if (!$is_general): ?>
                        <a class="section-drag-handle curr-handle" href="javascript:void(0);" title="Drag to reorder section">
                            <i class="material-icons">drag_indicator</i>
                        </a>
                    <?php endif; ?>

                    <button type="button" class="curr-section-toggle" data-toggle="collapse" data-target="#collapse_<?php echo $section['id']; ?>" aria-expanded="true">
                        <i class="material-icons curr-chevron">expand_more</i>
                        <span class="curr-section-text">
                            <span class="curr-section-label"><?php echo $is_general ? 'Not in a section' : 'Section ' . $section_no; ?></span>
                            <span class="curr-section-title"><?php echo htmlspecialchars($section_title); ?></span>
                        </span>
                        <span class="curr-count"><?php echo $count; ?> lecture<?php echo $count == 1 ? '' : 's'; ?></span>
                    </button>

                    <div class="curr-actions">
                        <button type="button" class="curr-icon-btn is-primary" title="Add lecture to this section"
                            onclick="addLectureToSection(<?php echo (int) $section['id']; ?>)">
                            <i class="material-icons">add</i>
                        </button>
                        <?php if (!$is_general): ?>
                            <button type="button" class="curr-icon-btn" title="Rename section"
                                onclick="editSection(<?php echo (int) $section['id']; ?>, <?php echo htmlspecialchars(json_encode($section['title']), ENT_QUOTES); ?>)">
                                <i class="material-icons">edit</i>
                            </button>
                            <button type="button" class="curr-icon-btn is-danger" title="Delete section"
                                onclick="deleteSection(<?php echo (int) $section['id']; ?>)">
                                <i class="material-icons">delete_outline</i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <div id="collapse_<?php echo $section['id']; ?>" class="collapse in">
                    <ul class="list-unstyled lecture-list curr-lectures" data-section-id="<?php echo $section['id']; ?>">
                        <?php if (!empty($section['lectures'])): ?>
                            <?php foreach ($section['lectures'] as $lecture): ?>
                                <?php
                                $lecture_no++;
                                $tm = isset($type_meta[$lecture['cl_type']]) ? $type_meta[$lecture['cl_type']] : $default_type;
                                $is_active = ($lecture['cl_status'] == 1);
                                $is_secure = ($lecture['cl_secure'] == 1);
                                ?>
                                <li class="lecture-item curr-lecture<?php echo $is_active ? '' : ' is-draft'; ?>" data-id="<?php echo $lecture['id']; ?>">
                                    <a href="javascript:void(0);" class="lecture-drag-handle curr-handle" title="Drag to reorder or move to another section">
                                        <i class="material-icons">drag_indicator</i>
                                    </a>
                                    <span class="curr-num"><?php echo $lecture_no; ?></span>
                                    <span class="curr-type <?php echo $tm['class']; ?>" title="<?php echo $tm['label']; ?>">
                                        <i class="material-icons"><?php echo $tm['icon']; ?></i>
                                    </span>
                                    <div class="curr-lecture-main">
                                        <div class="curr-lecture-title" title="<?php echo htmlspecialchars($lecture['cl_name']); ?>"><?php echo htmlspecialchars($lecture['cl_name']); ?></div>
                                        <div class="curr-lecture-meta">
                                            <span><?php echo $tm['label']; ?></span>
                                            <?php if (!empty($lecture['cl_file_name'])): ?>
                                                <span class="curr-dot">·</span>
                                                <span class="curr-url" title="<?php echo htmlspecialchars($lecture['cl_file_name']); ?>"><?php echo htmlspecialchars($lecture['cl_file_name']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="curr-lecture-tags">
                                        <span class="curr-chip <?php echo $is_active ? 'is-active' : 'is-draft'; ?>"><?php echo $is_active ? 'Active' : 'Draft'; ?></span>
                                        <span class="curr-chip <?php echo $is_secure ? 'is-secure' : 'is-public'; ?>" title="<?php echo $is_secure ? 'Only enrolled learners can access' : 'Anyone can preview'; ?>">
                                            <i class="material-icons"><?php echo $is_secure ? 'lock' : 'public'; ?></i><?php echo $is_secure ? 'Secure' : 'Public'; ?>
                                        </span>
                                    </div>
                                    <div class="curr-actions">
                                        <button type="button" class="curr-icon-btn" title="Edit lecture" onclick="editLecture(<?php echo (int) $lecture['id']; ?>)">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" class="curr-icon-btn is-danger" title="Delete lecture" onclick="deleteLecture(<?php echo (int) $lecture['id']; ?>)">
                                            <i class="material-icons">delete_outline</i>
                                        </button>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="empty-placeholder curr-empty-drop">
                                <i class="material-icons">move_to_inbox</i> No lectures yet. Drag one here or add a new lecture.
                            </li>
                        <?php endif; ?>
                    </ul>

                    <button type="button" class="curr-add-inline" onclick="addLectureToSection(<?php echo (int) $section['id']; ?>)">
                        <i class="material-icons">add</i> Add lecture<?php echo $is_general ? '' : ' to ' . htmlspecialchars($section_title); ?>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="curr-empty">
            <div class="curr-empty-icon"><i class="material-icons">video_library</i></div>
            <h4>Build your course curriculum</h4>
            <p>Group lectures into sections (e.g. "Week 1 – Basics"), then add videos, PDFs or Drive files.</p>
            <div class="curr-empty-actions">
                <button type="button" class="btn btn-primary waves-effect" onclick="addSection()"><i class="material-icons">view_agenda</i> Add first section</button>
                <button type="button" class="btn btn-default waves-effect" onclick="addLectureToSection(0)"><i class="material-icons">add</i> Add a lecture</button>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php if (!empty($curriculum)): ?>
    <button type="button" class="curr-add-section" onclick="addSection()">
        <i class="material-icons">add_circle_outline</i> Add new section
    </button>
<?php endif; ?>

<script>
    // Helper to reload orders for all lectures in a group
    function updateLectureOrders(sectionId, listEl) {
        var newOrder = [];
        $(listEl).find('li.lecture-item').each(function () {
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

    // Renumber lectures after a drag so the numbers stay sequential
    function renumberLectures() {
        $('#curriculum-sections li.lecture-item .curr-num').each(function (i) {
            $(this).text(i + 1);
        });
    }

    // 1. Sortable sections
    var sectionEl = document.getElementById('curriculum-sections');
    if (sectionEl && window.Sortable) {
        Sortable.create(sectionEl, {
            handle: '.section-drag-handle',
            animation: 150,
            onEnd: function () {
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
                renumberLectures();
            }
        });
    }

    // 2. Sortable lectures (can move between sections)
    document.querySelectorAll('.lecture-list').forEach(function (el) {
        if (!window.Sortable) return;
        Sortable.create(el, {
            group: 'lectures',
            handle: '.lecture-drag-handle',
            draggable: '.lecture-item',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function (evt) {
                var targetSectionId = evt.to.getAttribute('data-section-id');
                var sourceSectionId = evt.from.getAttribute('data-section-id');

                // Drop the "empty" hint from a list that now has lectures
                $(evt.to).find('.empty-placeholder').remove();

                updateLectureOrders(targetSectionId, evt.to);
                if (targetSectionId !== sourceSectionId) {
                    updateLectureOrders(sourceSectionId, evt.from);
                }
                renumberLectures();
            }
        });
    });

    // Rotate chevron when a section is collapsed
    $('#curriculum-sections .collapse').on('hide.bs.collapse show.bs.collapse', function (e) {
        $(this).closest('.curr-section').toggleClass('is-collapsed', e.type === 'hide');
    });
</script>
