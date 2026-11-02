<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Learners / user management */
?>
<div class="cl-page">

    <div class="cl-head">
        <div>
            <h1>Learners &amp; Users</h1>
            <p>Find people, manage access and see what they're enrolled in.</p>
        </div>
        <button type="button" class="cl-btn cl-btn-primary cl-btn-lg" onclick="openUserFormSidebar()">
            <i class="material-icons">person_add</i><span>Add user</span>
        </button>
    </div>

    <!-- Stat cards double as quick filters -->
    <div class="cl-stats" aria-label="Filter users">
        <button type="button" class="cl-stat is-active" data-filter="all">
            <span class="cl-stat-icon is-indigo"><i class="material-icons">people</i></span>
            <span><strong id="stat_all"><?php echo number_format($stats['all']); ?></strong><small>All users</small></span>
        </button>
        <button type="button" class="cl-stat" data-filter="active">
            <span class="cl-stat-icon is-green"><i class="material-icons">how_to_reg</i></span>
            <span><strong id="stat_active"><?php echo number_format($stats['active']); ?></strong><small>Active</small></span>
        </button>
        <button type="button" class="cl-stat" data-filter="inactive">
            <span class="cl-stat-icon is-slate"><i class="material-icons">person_off</i></span>
            <span><strong id="stat_inactive"><?php echo number_format($stats['inactive']); ?></strong><small>Inactive</small></span>
        </button>
        <button type="button" class="cl-stat" data-filter="admins">
            <span class="cl-stat-icon is-amber"><i class="material-icons">admin_panel_settings</i></span>
            <span><strong id="stat_admins"><?php echo number_format($stats['admins']); ?></strong><small>Administrators</small></span>
        </button>
    </div>

    <div class="cl-card">
        <div class="cl-toolbar">
            <div class="cl-search">
                <i class="material-icons">search</i>
                <input type="text" class="global-dt-search" data-table="users_table" placeholder="Search name, email, username or phone…" aria-label="Search users">
            </div>
            <select id="role_filter" class="form-control" title="All roles">
                <option value="">All roles</option>
                <?php foreach ($roles as $r) { ?>
                    <option value="<?php echo (int) $r->id; ?>"><?php echo htmlspecialchars(isset($role_labels[(int) $r->id]) ? $role_labels[(int) $r->id] : $r->name); ?></option>
                <?php } ?>
            </select>
            <select id="status_filter" class="form-control" title="Any status">
                <option value="">Any status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            <button type="button" class="cl-reset" id="ul_reset" style="display:none;">
                <i class="material-icons">close</i> Clear filters
            </button>
        </div>

        <div class="table-responsive">
            <table id="users_table" class="table cl-table" style="width:100%">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Contact</th>
                        <th>Role</th>
                        <th>Courses</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th></th>
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
        table = $('#users_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[5, 'desc']], // newest first
            pageLength: 25,
            lengthMenu: [10, 25, 50, 100],
            dom: 'rt<"cl-foot"lip>',
            autoWidth: false,
            searchDelay: 400,
            ajax: {
                url: "<?php echo site_url('admin/users/ajax_list') ?>",
                type: "POST",
                data: function (d) {
                    d.role = $('#role_filter').val();
                    d.status = $('#status_filter').val();
                },
                dataSrc: function (json) {
                    if (json.stats) {
                        $.each(json.stats, function (k, v) { $('#stat_' + k).text(Number(v).toLocaleString()); });
                    }
                    return json.data;
                }
            },
            // "name" tells the server which column to sort by. One entry per column (className isn't merged).
            columns: [
                { name: 'name' },
                { name: 'email', className: 'cl-hide-xs' },
                { name: 'role', className: 'cl-hide-sm' },
                { name: 'courses', className: 'cl-col-num cl-hide-sm' },
                { name: 'status' },
                { name: 'joined', className: 'ul-hide-lg' },
                { name: 'actions', orderable: false, className: 'text-right' }
            ],
            language: {
                processing: '<div class="cl-loading"><i class="material-icons">sync</i> Loading…</div>',
                emptyTable: 'No users yet. Click “Add user” to create one.',
                zeroRecords: 'No users match your search or filters.',
                info: 'Showing _START_–_END_ of _TOTAL_',
                infoEmpty: 'No users',
                infoFiltered: '(filtered from _MAX_)',
                lengthMenu: 'Show _MENU_',
                paginate: { previous: '<i class="material-icons">chevron_left</i>', next: '<i class="material-icons">chevron_right</i>' }
            }
        });

        function refreshSelect($s) { if ($.fn.selectpicker && $s.data('selectpicker')) $s.selectpicker('refresh'); }
        function syncUi() {
            var role = $('#role_filter').val(), status = $('#status_filter').val();
            var key = (role === '1' && !status) ? 'admins' : (!role && status === 'active') ? 'active' : (!role && status === 'inactive') ? 'inactive' : (!role && !status) ? 'all' : '';
            $('.cl-stat').removeClass('is-active');
            if (key) $('.cl-stat[data-filter="' + key + '"]').addClass('is-active');
            $('#ul_reset').toggle(!!(role || status || $.trim($('.cl-search input').val())));
        }

        $('.cl-stat').on('click', function () {
            var f = $(this).data('filter');
            $('#role_filter').val(f === 'admins' ? '1' : '');
            $('#status_filter').val(f === 'active' || f === 'inactive' ? f : '');
            refreshSelect($('#role_filter')); refreshSelect($('#status_filter'));
            syncUi(); table.draw();
        });
        $('#role_filter, #status_filter').on('change', function () { syncUi(); table.draw(); });
        $('.cl-search input').on('input', syncUi);
        $('#ul_reset').on('click', function () {
            $('#role_filter, #status_filter').val('');
            refreshSelect($('#role_filter')); refreshSelect($('#status_filter'));
            $('.cl-search input').val(''); table.search('');
            syncUi(); table.draw();
        });
    });

    // Inline status switch: confirm, save via AJAX, update the row in place
    function toggleUserStatus(id, input) {
        var $in = $(input), active = input.checked ? 1 : 0;
        var name = $in.data('name') || 'this user';
        var msg = active ? 'Activate ' + name + '? They will be able to log in.'
                         : 'Deactivate ' + name + '? They will be signed out and won\'t be able to log in.';
        if (!confirm(msg)) { input.checked = !input.checked; return; }

        var $label = $in.closest('.ul-switch');
        $in.prop('disabled', true);
        $label.addClass('is-saving').find('.ul-switch-label').text(active ? 'Active' : 'Inactive');
        $.post("<?php echo site_url('admin/users/set_status') ?>", { id: id, active: active, csrf_token: csrf_token }, null, 'json')
            .done(function (res) {
                if (res.flag == 1) {
                    show_success(res.msg);
                    table.ajax.reload(null, false); // refresh counts + row
                } else {
                    show_danger(res.msg);
                    input.checked = !active;
                    $label.find('.ul-switch-label').text(active ? 'Inactive' : 'Active');
                }
            })
            .fail(function () {
                show_danger('Could not update the status. Please try again.');
                input.checked = !active;
                $label.find('.ul-switch-label').text(active ? 'Inactive' : 'Active');
            })
            .always(function () { $in.prop('disabled', false); $label.removeClass('is-saving'); });
    }

    // openUserSidebar() / closeUserSidebar() live in themes/admin/js/admin_shared.js (loaded globally)
    function openUserFormSidebar(id = null) {
        var url = site_url + 'admin/users/form';
        if (id) {
            url += '/' + id;
        }

        $('#userSidebarBody').html(`<div class="text-center" style="padding:100px 50px;">
            <div class="preloader pl-size-xl">
                <div class="spinner-layer pl-indigo">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p style="margin-top:20px; color:#64748b; font-weight:600;">Loading Form...</p>
        </div>`);
        $('#userSidebar').addClass('open');

        $.get(url, function (data) {
            $('#userSidebarBody').html(data);

            // Re-initialize Datepicker
            if ($.fn.datepicker) {
                $('#dob').datepicker({
                    autoclose: true,
                    format: 'dd-mm-yyyy'
                });
            }

            // Image Preview logic
            $('#image').on('change', function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#c_image').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Handle form submission
            $('#userSidebarBody form').on('submit', function (e) {
                e.preventDefault();
                var $form = $(this);
                var $btn = $form.find('button[type="submit"]');
                var originalBtnContent = $btn.html();

                $btn.prop('disabled', true).html('<i class="material-icons rotating">sync</i> PROCESSING...');

                var formData = new FormData(this);
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.flag == 1) {
                            show_success(response.msg);
                            closeUserSidebar();
                            if (typeof table !== 'undefined') {
                                table.ajax.reload(null, false);
                            }
                        } else {
                            show_danger(response.msg);
                            // Highlight error fields if any
                            if (response.error_fields) {
                                try {
                                    var fields = JSON.parse(response.error_fields);
                                    $('.form-line-premium').removeClass('error');
                                    $.each(fields, function (i, field) {
                                        $('[name="' + field + '"]').closest('.form-line-premium').addClass('error');
                                    });
                                } catch (e) { }
                            }
                            $btn.prop('disabled', false).html(originalBtnContent);
                        }
                    },
                    error: function () {
                        show_danger('A server error occurred. Please try again.');
                        $btn.prop('disabled', false).html(originalBtnContent);
                    }
                });
            });
        });
    }
</script>
