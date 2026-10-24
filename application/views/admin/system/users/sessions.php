<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card sess-card">

            <!-- Header + quick stats -->
            <div class="sess-head">
                <div>
                    <h2>Active Sessions</h2>
                    <p>See who is logged in and on how many devices. Lock a learner to block their course access.</p>
                </div>
                <div class="sess-stats">
                    <button type="button" class="sess-stat" data-filter="active">
                        <strong id="kpi_active_sessions"><?php echo number_format(isset($active_sessions) ? $active_sessions : 0); ?></strong> Online now
                    </button>
                    <button type="button" class="sess-stat is-amber" data-filter="multidevice">
                        <strong id="kpi_multidevice_users"><?php echo number_format(isset($multidevice_users) ? $multidevice_users : 0); ?></strong> Multi-device
                    </button>
                    <button type="button" class="sess-stat is-rose" data-filter="locked">
                        <strong id="kpi_locked_users"><?php echo number_format(isset($locked_users) ? $locked_users : 0); ?></strong> Locked
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="sess-filters">
                <div class="sess-search">
                    <i class="material-icons">search</i>
                    <input type="text" id="sess_search" class="form-control" placeholder="Search name, email or IP...">
                </div>
                <select id="sess_status" class="form-control">
                    <option value="all">All users</option>
                    <option value="active">Online now</option>
                    <option value="multidevice">Multi-device</option>
                    <option value="locked">Locked</option>
                </select>
            </div>

            <div class="body table-responsive" style="padding-top: 0;">
                <table id="sessions_table" class="table table-hover" style="width: 100%;">
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
</div>

<!-- User Devices Modal -->
<div class="modal fade" id="userSessionsModal" tabindex="-1" role="dialog" aria-labelledby="modalUserName">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header" style="display: flex; align-items: center; justify-content: space-between;">
                <h4 class="modal-title" id="modalUserName" style="font-weight: 700; margin: 0;">Devices</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body" id="modalSessionsBody"></div>
        </div>
    </div>
</div>

<style>
.sess-card { border-radius: 12px; overflow: hidden; }
.sess-head { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; padding: 22px 24px; border-bottom: 1px solid #e2e8f0; }
.sess-head h2 { font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0 0 4px; }
.sess-head p { margin: 0; font-size: 13px; color: #64748b; }
.sess-stats { display: flex; gap: 8px; flex-wrap: wrap; }
.sess-stat { border: 1px solid #a7f3d0; background: #ecfdf5; color: #047857; border-radius: 999px; padding: 6px 14px; font-size: 13px; cursor: pointer; }
.sess-stat strong { font-weight: 800; margin-right: 2px; }
.sess-stat.is-amber { border-color: #fde68a; background: #fffbeb; color: #b45309; }
.sess-stat.is-rose { border-color: #fecdd3; background: #fff1f2; color: #be123c; }
.sess-filters { display: flex; gap: 12px; flex-wrap: wrap; padding: 16px 24px; }
.sess-search { position: relative; flex: 1 1 280px; max-width: 420px; }
.sess-search i { position: absolute; left: 10px; top: 9px; font-size: 18px; color: #94a3b8; }
.sess-search input { padding-left: 34px; border-radius: 8px; height: 38px; }
#sess_status { width: 180px; border-radius: 8px; height: 38px; }
.sess-user { display: flex; align-items: center; gap: 10px; }
.sess-user img { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; }
.sess-user-name { font-weight: 700; color: #1e293b; }
.sess-user-email { font-size: 12px; color: #64748b; }
.sess-muted { font-size: 13px; color: #64748b; }
.sess-ico { font-size: 14px; vertical-align: middle; }
.sess-actions { display: flex; gap: 6px; white-space: nowrap; }
.sess-actions .btn { border-radius: 6px; font-weight: 600; }
#sessions_table td { vertical-align: middle; }
</style>

<script type="text/javascript">
$(document).ready(function() {
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    var currentModalUser = null;

    var table = $('#sessions_table').DataTable({
        "processing": true,
        "serverSide": true,
        "dom": "rtip",
        "pageLength": 25,
        "ajax": {
            "url": "<?php echo site_url('admin/users/ajax_sessions_list'); ?>",
            "type": "POST",
            "data": function(d) {
                d[csrfName] = csrfHash;
                d.status_filter = $('#sess_status').val();
            },
            "dataSrc": function(json) {
                $.each(json.stats || {}, function(key, val) {
                    $('#kpi_' + key).text(Number(val).toLocaleString());
                });
                return json.data;
            }
        },
        "columnDefs": [{ "targets": [4], "orderable": false }],
        "order": [[3, "desc"]],
        "language": {
            "emptyTable": "No users match the current filters.",
            "paginate": {
                "previous": "<i class='material-icons'>chevron_left</i>",
                "next": "<i class='material-icons'>chevron_right</i>"
            }
        }
    });

    function notify(ok, msg) {
        if (ok && typeof show_success === 'function') return show_success(msg);
        if (!ok && typeof show_danger === 'function') return show_danger(msg);
        alert(msg);
    }

    function postAction(url, data, $btn) {
        data = data || {};
        data[csrfName] = csrfHash;
        $btn.prop('disabled', true);
        $.post(url, data, null, 'json').done(function(res) {
            notify(res.status, res.msg);
            table.ajax.reload(null, false);
            if (currentModalUser && $('#userSessionsModal').is(':visible')) {
                loadModal(currentModalUser.id, currentModalUser.name);
            }
        }).fail(function() {
            notify(false, 'Something went wrong. Please try again.');
        }).always(function() {
            $btn.prop('disabled', false);
        });
    }

    // Lock / Unlock learning access (table + modal)
    $(document).on('click', '.lock-toggle-btn', function() {
        var $btn = $(this);
        var lock = String($btn.data('lock')) === '1';
        var text = lock
            ? 'Lock ' + $btn.data('username') + '? They will not be able to open courses until unlocked.'
            : 'Unlock ' + $btn.data('username') + '?';
        if (!confirm(text)) return;
        postAction("<?php echo site_url('admin/users/set_lock/'); ?>" + $btn.data('userid'), { status: lock ? 1 : 0 }, $btn);
    });

    // Log out all devices (modal)
    $(document).on('click', '.logout-devices-btn', function() {
        var $btn = $(this);
        if (!confirm('Log out ' + $btn.data('username') + ' from all devices?')) return;
        postAction("<?php echo site_url('admin/users/logout_devices/'); ?>" + $btn.data('userid'), {}, $btn);
    });

    // Log out a single device (modal)
    $(document).on('click', '.terminate-session-btn', function() {
        var $btn = $(this);
        if (!confirm('Log out this device?')) return;
        postAction("<?php echo site_url('admin/users/terminate_session/'); ?>" + $btn.data('userid') + '/' + $btn.data('sessid'), {}, $btn);
    });

    // Debounced search
    var searchTimer = null;
    $('#sess_search').on('input', function() {
        var val = $.trim(this.value);
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            if (table.search() !== val) table.search(val).draw();
        }, 350);
    });

    $('#sess_status').on('change', function() {
        table.ajax.reload();
    });

    // Stat pills act as quick filters (click again to clear)
    $('.sess-stat').on('click', function() {
        var f = $(this).data('filter');
        $('#sess_status').val($('#sess_status').val() === f ? 'all' : f).trigger('change');
    });

    function loadModal(userId, userName) {
        currentModalUser = { id: userId, name: userName };
        $('#modalUserName').text(userName + ' — Devices');
        $.getJSON("<?php echo site_url('admin/users/ajax_user_sessions_modal/'); ?>" + userId)
            .done(function(res) {
                $('#modalSessionsBody').html(res.status && res.html ? res.html : '<div class="alert alert-danger">Failed to load devices.</div>');
            })
            .fail(function() {
                $('#modalSessionsBody').html('<div class="alert alert-danger">Error connecting to server.</div>');
            });
    }

    $(document).on('click', '.view-sessions-btn', function() {
        $('#modalSessionsBody').html('<div class="text-center" style="padding: 32px; color: #64748b;">Loading...</div>');
        $('#userSessionsModal').modal('show');
        loadModal($(this).data('userid'), $(this).data('username'));
    });

    $('#userSessionsModal').on('hidden.bs.modal', function() {
        currentModalUser = null;
    });
});
</script>
