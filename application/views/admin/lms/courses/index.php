<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="cl-page">

    <!-- Page header -->
    <div class="cl-head">
        <div>
            <h1>Courses</h1>
            <p>Create, publish and manage your courses and batches.</p>
        </div>
        <a href="<?php echo site_url('admin/courses/form'); ?>" class="cl-btn cl-btn-primary cl-btn-lg">
            <i class="material-icons">add</i><span>New course</span>
        </a>
    </div>

    <!-- Stat cards double as quick filters -->
    <div class="cl-stats" role="tablist" aria-label="Filter courses">
        <button type="button" class="cl-stat is-active" data-filter="all">
            <span class="cl-stat-icon is-indigo"><i class="material-icons">import_contacts</i></span>
            <span><strong id="stat_all"><?php echo (int) $total_courses; ?></strong><small>All courses</small></span>
        </button>
        <button type="button" class="cl-stat" data-filter="active">
            <span class="cl-stat-icon is-green"><i class="material-icons">check_circle</i></span>
            <span><strong id="stat_active"><?php echo (int) $active_courses; ?></strong><small>Active</small></span>
        </button>
        <button type="button" class="cl-stat" data-filter="inactive">
            <span class="cl-stat-icon is-slate"><i class="material-icons">pause_circle_outline</i></span>
            <span><strong id="stat_inactive"><?php echo (int) $inactive_courses; ?></strong><small>Inactive</small></span>
        </button>
        <button type="button" class="cl-stat" data-filter="featured">
            <span class="cl-stat-icon is-amber"><i class="material-icons">star</i></span>
            <span><strong id="stat_featured"><?php echo (int) $featured_courses; ?></strong><small>Featured</small></span>
        </button>
    </div>

    <!-- List -->
    <div class="cl-card">
        <div class="cl-toolbar">
            <div class="cl-search">
                <i class="material-icons">search</i>
                <input type="text" class="global-dt-search" data-table="courses_table" placeholder="Search courses by title…" aria-label="Search courses">
            </div>
            <select id="category_filter" class="form-control" data-live-search="true" title="All categories">
                <option value="">All categories</option>
                <?php foreach ($categories as $cat) { ?>
                    <option value="<?php echo (int) $cat->id; ?>"><?php echo htmlspecialchars($cat->title); ?></option>
                <?php } ?>
            </select>
            <select id="status_filter" class="form-control" title="Any status">
                <option value="">Any status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            <button type="button" class="cl-reset" id="cl_reset" style="display:none;">
                <i class="material-icons">close</i> Clear filters
            </button>
        </div>

        <div class="table-responsive">
            <table id="courses_table" class="table cl-table" style="width:100%">
                <thead>
                    <tr>
                        <?php foreach ($t_headers as $val) {
                            echo '<th>' . $val . '</th>';
                        } ?>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var table;
    $(document).ready(function () {
        var featuredOnly = false;

        table = $('#courses_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[4, 'desc']],
            pageLength: 25,
            lengthMenu: [10, 25, 50, 100],
            dom: 'rt<"cl-foot"lip>',
            autoWidth: false,
            ajax: {
                url: "<?php echo site_url('admin/courses/ajax_list') ?>",
                type: "POST",
                data: function (d) {
                    d.category_id = $('#category_filter').val();
                    d.status = $('#status_filter').val();
                    d.featured = featuredOnly ? '1' : '';
                },
                dataSrc: function (json) {
                    if (json.stats) {
                        $.each(json.stats, function (k, v) { $('#stat_' + k).text(v); });
                    }
                    return json.data;
                }
            },
            // One entry per column: DataTables overwrites (not merges) className on body cells
            columnDefs: [
                { targets: [1], className: 'cl-hide-sm' },
                { targets: [2, 3], className: 'cl-col-num cl-hide-sm' },
                { targets: [4], className: 'cl-hide-xs' },
                { targets: [7], orderable: false, className: 'text-right' }
            ],
            language: {
                processing: '<div class="cl-loading"><i class="material-icons">sync</i> Loading…</div>',
                emptyTable: 'No courses yet. Click “New course” to create your first one.',
                zeroRecords: 'No courses match your search or filters.',
                info: 'Showing _START_–_END_ of _TOTAL_',
                infoEmpty: 'No courses',
                infoFiltered: '(filtered from _MAX_)',
                lengthMenu: 'Show _MENU_',
                paginate: { previous: '<i class="material-icons">chevron_left</i>', next: '<i class="material-icons">chevron_right</i>' }
            }
        });

        function syncUi() {
            var status = $('#status_filter').val();
            var key = featuredOnly ? 'featured' : (status === '1' ? 'active' : (status === '0' ? 'inactive' : 'all'));
            $('.cl-stat').removeClass('is-active').filter('[data-filter="' + key + '"]').addClass('is-active');
            var filtered = featuredOnly || status !== '' || $('#category_filter').val() !== '' || $.trim($('.cl-search input').val()) !== '';
            $('#cl_reset').toggle(filtered);
        }
        function refreshSelect($s) { if ($.fn.selectpicker && $s.data('selectpicker')) $s.selectpicker('refresh'); }

        // Stat cards = quick filters
        $('.cl-stat').on('click', function () {
            var f = $(this).data('filter');
            featuredOnly = (f === 'featured');
            $('#status_filter').val(f === 'active' ? '1' : (f === 'inactive' ? '0' : ''));
            refreshSelect($('#status_filter'));
            syncUi();
            table.draw();
        });

        $('#category_filter, #status_filter').on('change', function () {
            if (this.id === 'status_filter') featuredOnly = false;
            syncUi();
            table.draw();
        });
        $('.cl-search input').on('input', syncUi);

        $('#cl_reset').on('click', function () {
            featuredOnly = false;
            $('#category_filter, #status_filter').val('');
            refreshSelect($('#category_filter')); refreshSelect($('#status_filter'));
            $('.cl-search input').val('');
            table.search('');
            syncUi();
            table.draw();
        });
    });
</script>
