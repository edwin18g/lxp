<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="cl-page">

    <div class="cl-head">
        <div>
            <h1>Active Sessions</h1>
            <p>See who is signed in and on how many devices. Lock a learner to block their course access.</p>
        </div>
    </div>

    <div class="cl-card">
        <!-- Filter tabs -->
        <div class="cl-stats" role="tablist" aria-label="Filter sessions">
            <button type="button" class="cl-stat is-active" data-filter="all">
                <span class="cl-stat-icon is-indigo"><i class="material-icons">people</i></span>
                <span><strong id="ss_users"><?php echo number_format(isset($users) ? $users : 0); ?></strong><small>All users</small></span>
            </button>
            <button type="button" class="cl-stat" data-filter="active">
                <span class="cl-stat-icon is-green"><i class="material-icons">wifi</i></span>
                <span><strong id="ss_online_users"><?php echo number_format(isset($online_users) ? $online_users : 0); ?></strong><small>Online now</small></span>
            </button>
            <button type="button" class="cl-stat" data-filter="multidevice">
                <span class="cl-stat-icon is-amber"><i class="material-icons">devices</i></span>
                <span><strong id="ss_multidevice_users"><?php echo number_format(isset($multidevice_users) ? $multidevice_users : 0); ?></strong><small>Multi-device</small></span>
            </button>
            <button type="button" class="cl-stat" data-filter="locked">
                <span class="cl-stat-icon is-rose"><i class="material-icons">lock</i></span>
                <span><strong id="ss_locked_users"><?php echo number_format(isset($locked_users) ? $locked_users : 0); ?></strong><small>Locked</small></span>
            </button>
        </div>

        <div class="cl-toolbar">
            <div class="cl-search">
                <i class="material-icons">search</i>
                <input type="text" id="sess_search" placeholder="Search name, email or IP address…" aria-label="Search sessions">
            </div>
            <span class="ss-note"><i class="material-icons">info_outline</i> Online = active in the last session window. Locked learners can't open courses.</span>
        </div>

        <div class="table-responsive">
            <table id="sessions_table" class="table cl-table" style="width:100%">
                <thead>
                    <tr>
                        <th style="width:36px"><label class="curr-check" title="Select all on this page"><input type="checkbox" id="ss_check_all"><span class="curr-check-box"></span></label></th>
                        <th>User</th>
                        <th>Devices</th>
                        <th>Last active</th>
                        <th>Course access</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bulk bar -->
<div class="bulk-bar" id="ssBulkBar" hidden role="toolbar" aria-label="Bulk actions for selected users">
    <div class="bulk-bar-count"><strong id="ssBulkCount">0</strong> selected</div>
    <div class="bulk-bar-actions">
        <button type="button" class="bulk-btn" data-ss-bulk="lock"><i class="material-icons">lock</i><span>Lock</span></button>
        <button type="button" class="bulk-btn" data-ss-bulk="unlock"><i class="material-icons">lock_open</i><span>Unlock</span></button>
        <button type="button" class="bulk-btn is-danger" data-ss-bulk="logout"><i class="material-icons">logout</i><span>Log out devices</span></button>
    </div>
    <button type="button" class="bulk-clear" id="ssBulkClear" title="Clear selection"><i class="material-icons">close</i></button>
</div>

<!-- User Devices Modal -->
<div class="modal fade" id="userSessionsModal" tabindex="-1" role="dialog" aria-labelledby="modalUserName">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ss-modal">
            <div class="modal-header">
                <h4 class="modal-title" id="modalUserName">Devices</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body" id="modalSessionsBody"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    var currentModalUser = null, filter = 'all', sel = {};

    function notify(ok, msg) {
        if (ok && typeof show_success === 'function') return show_success(msg);
        if (!ok && typeof show_danger === 'function') return show_danger(msg);
        alert(msg);
    }

    var table = $('#sessions_table').DataTable({
        processing: true,
        serverSide: true,
        dom: 'rt<"cl-foot"lip>',
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100],
        autoWidth: false,
        order: [[3, 'desc']],
        ajax: {
            url: "<?php echo site_url('admin/users/ajax_sessions_list'); ?>",
            type: 'POST',
            data: function (d) { d[csrf_name] = csrf_token; d.status_filter = filter; },
            dataSrc: function (json) {
                $.each(json.stats || {}, function (k, v) { $('#ss_' + k).text(Number(v).toLocaleString()); });
                return json.data;
            }
        },
        columns: [
            { orderable: false },
            null,
            { className: 'cl-hide-xs' },
            { className: 'cl-hide-sm' },
            null,
            { orderable: false, className: 'text-right' }
        ],
        language: {
            processing: '<div class="cl-loading"><i class="material-icons">sync</i> Loading…</div>',
            emptyTable: 'No sessions recorded yet.',
            zeroRecords: 'No users match the current filter or search.',
            info: 'Showing _START_–_END_ of _TOTAL_', infoEmpty: 'No users', infoFiltered: '(filtered from _MAX_)', lengthMenu: 'Show _MENU_',
            paginate: { previous: '<i class="material-icons">chevron_left</i>', next: '<i class="material-icons">chevron_right</i>' }
        },
        // Keep the pager outside the scrolling table area
        initComplete: function () {
            var $wrap = $(this.api().table().container());
            $wrap.find('.cl-foot').insertAfter($wrap.closest('.table-responsive'));
        },
        drawCallback: syncSelection
    });

    /* ---------- Filters + search ---------- */
    $('.cl-stat').on('click', function () {
        filter = $(this).data('filter');
        $('.cl-stat').removeClass('is-active'); $(this).addClass('is-active');
        table.draw();
    });
    var searchTimer = null;
    $('#sess_search').on('input', function () {
        var val = $.trim(this.value);
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () { if (table.search() !== val) table.search(val).draw(); }, 350);
    });

    /* ---------- Selection + bulk ---------- */
    function ids() { return Object.keys(sel); }
    function syncSelection() {
        var boxes = $('#sessions_table .js-sess-check');
        boxes.each(function () { this.checked = !!sel[this.value]; $(this).closest('tr').toggleClass('is-selected', this.checked); });
        var on = boxes.filter(':checked').length, all = document.getElementById('ss_check_all');
        all.checked = boxes.length > 0 && on === boxes.length; all.indeterminate = on > 0 && on < boxes.length;
        $('#ssBulkCount').text(ids().length);
        $('#ssBulkBar').prop('hidden', ids().length === 0);
        $('body').toggleClass('has-bulk-bar', ids().length > 0);
    }
    $(document).on('change', '.js-sess-check', function () { if (this.checked) sel[this.value] = true; else delete sel[this.value]; syncSelection(); });
    $('#ss_check_all').on('change', function () {
        var on = this.checked;
        $('#sessions_table .js-sess-check').each(function () { if (on) sel[this.value] = true; else delete sel[this.value]; });
        syncSelection();
    });
    $('#ssBulkClear').on('click', function () { sel = {}; syncSelection(); });
    $('#ssBulkBar').on('click', '[data-ss-bulk]', function () {
        var action = $(this).data('ss-bulk'), n = ids().length;
        var q = { lock: 'Lock course access for ' + n + ' user(s)?', unlock: 'Unlock course access for ' + n + ' user(s)?', logout: 'Log ' + n + ' user(s) out of all their devices?' };
        if (!confirm(q[action])) return;
        var data = { action: action, user_ids: ids() }; data[csrf_name] = csrf_token;
        $('#ssBulkBar').addClass('is-busy');
        $.post("<?php echo site_url('admin/users/sessions_bulk'); ?>", data, null, 'json')
            .done(function (res) { notify(res.status, res.msg); if (res.status && action === 'logout') { sel = {}; } table.ajax.reload(null, false); })
            .fail(function (xhr) { notify(false, 'Server error (HTTP ' + xhr.status + ').'); })
            .always(function () { $('#ssBulkBar').removeClass('is-busy'); });
    });

    /* ---------- Row + modal actions ---------- */
    function postAction(url, data, $btn) {
        data = data || {}; data[csrf_name] = csrf_token;
        if ($btn) $btn.prop('disabled', true);
        return $.post(url, data, null, 'json').done(function (res) {
            notify(res.status, res.msg);
            table.ajax.reload(null, false);
            if (currentModalUser && $('#userSessionsModal').is(':visible')) loadModal(currentModalUser.id, currentModalUser.name);
        }).fail(function () {
            notify(false, 'Something went wrong. Please try again.');
            table.ajax.reload(null, false);
        }).always(function () { if ($btn) $btn.prop('disabled', false); });
    }

    // Lock switch in the table
    window.sessLockToggle = function (userId, input) {
        var lock = input.checked, name = $(input).data('name');
        var text = lock ? 'Lock ' + name + '? They will not be able to open courses until unlocked.' : 'Unlock ' + name + '?';
        if (!confirm(text)) { input.checked = !lock; return; }
        $(input).closest('.ul-switch').find('.ul-switch-label').text(lock ? 'Locked' : 'Allowed');
        postAction("<?php echo site_url('admin/users/set_lock/'); ?>" + userId, { status: lock ? 1 : 0 });
    };
    // Lock / Unlock buttons inside the Devices dialog
    $(document).on('click', '.lock-toggle-btn', function () {
        var $btn = $(this), lock = String($btn.data('lock')) === '1';
        if (!confirm(lock ? 'Lock ' + $btn.data('username') + '? They will not be able to open courses until unlocked.' : 'Unlock ' + $btn.data('username') + '?')) return;
        postAction("<?php echo site_url('admin/users/set_lock/'); ?>" + $btn.data('userid'), { status: lock ? 1 : 0 }, $btn);
    });
    $(document).on('click', '.logout-devices-btn', function () {
        var $btn = $(this);
        if (!confirm('Log ' + $btn.data('username') + ' out of all devices?')) return;
        postAction("<?php echo site_url('admin/users/logout_devices/'); ?>" + $btn.data('userid'), {}, $btn);
    });
    $(document).on('click', '.terminate-session-btn', function () {
        var $btn = $(this);
        if (!confirm('Log out this device?')) return;
        postAction("<?php echo site_url('admin/users/terminate_session/'); ?>" + $btn.data('userid') + '/' + $btn.data('sessid'), {}, $btn);
    });

    function loadModal(userId, userName) {
        currentModalUser = { id: userId, name: userName };
        $('#modalUserName').text(userName + ' — Devices');
        $.getJSON("<?php echo site_url('admin/users/ajax_user_sessions_modal/'); ?>" + userId)
            .done(function (res) { $('#modalSessionsBody').html(res.status && res.html ? res.html : '<div class="alert alert-danger">Failed to load devices.</div>'); })
            .fail(function () { $('#modalSessionsBody').html('<div class="alert alert-danger">Error connecting to server.</div>'); });
    }
    $(document).on('click', '.view-sessions-btn', function () {
        $('#modalSessionsBody').html('<div class="text-center" style="padding: 32px; color: #64748b;">Loading…</div>');
        $('#userSessionsModal').modal('show');
        loadModal($(this).data('userid'), $(this).data('username'));
    });
    $('#userSessionsModal').on('hidden.bs.modal', function () { currentModalUser = null; });
});
</script>
