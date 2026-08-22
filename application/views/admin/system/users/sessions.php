<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- User Sessions View (Admin Premium Redesign) -->
<div class="row clearfix animate-up">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-premium" style="border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03); overflow: hidden; background: #ffffff;">
            
            <!-- Page Header -->
            <div class="header header-premium" style="padding: 24px 28px; background: linear-gradient(to right, #f8fafc, #ffffff); border-bottom: 1px solid #e2e8f0;">
                <div class="header-title-group" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div class="header-icon" style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #6366f1, #4f46e5); color: #ffffff; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);">
                            <i class="material-icons" style="font-size: 26px;">devices</i>
                        </div>
                        <div>
                            <h2 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">User Sessions Management</h2>
                            <span class="header-subtitle" style="font-size: 0.875rem; color: #64748b;">Monitor active logins, identify multi-device access, and manage security locks.</span>
                        </div>
                    </div>
                    <div>
                        <button type="button" id="btn_bulk_release_lock" class="btn btn-success" style="border-radius: 10px; font-weight: 700; padding: 10px 20px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25); display: inline-flex; align-items: center; gap: 8px;" disabled>
                            <i class="material-icons" style="font-size: 20px;">lock_open</i> Bulk Release Lock (<span id="selected_count">0</span>)
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats KPI Cards -->
            <div class="body" style="padding: 24px 28px 12px 28px;">
                <div class="row clearfix">
                    <!-- Total Recorded Sessions -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 16px;">
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px 20px; display: flex; align-items: center; gap: 16px; transition: transform 0.2s ease, box-shadow 0.2s ease;" class="kpi-card">
                            <div style="width: 46px; height: 46px; border-radius: 12px; background: rgba(99, 102, 241, 0.1); color: #6366f1; display: flex; align-items: center; justify-content: center;">
                                <i class="material-icons" style="font-size: 24px;">devices</i>
                            </div>
                            <div>
                                <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a; line-height: 1.1;"><?php echo isset($total_sessions) ? number_format($total_sessions) : 0; ?></div>
                                <div style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Total Sessions</div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Connections -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 16px;">
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px 20px; display: flex; align-items: center; gap: 16px; transition: transform 0.2s ease, box-shadow 0.2s ease;" class="kpi-card">
                            <div style="width: 46px; height: 46px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center;">
                                <i class="material-icons" style="font-size: 24px;">wifi_tethering</i>
                            </div>
                            <div>
                                <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a; line-height: 1.1;"><?php echo isset($active_sessions) ? number_format($active_sessions) : 0; ?></div>
                                <div style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Active Connections</div>
                            </div>
                        </div>
                    </div>

                    <!-- Multi-Device Users -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 16px;">
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px 20px; display: flex; align-items: center; gap: 16px; transition: transform 0.2s ease, box-shadow 0.2s ease;" class="kpi-card">
                            <div style="width: 46px; height: 46px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; display: flex; align-items: center; justify-content: center;">
                                <i class="material-icons" style="font-size: 24px;">phonelink_setup</i>
                            </div>
                            <div>
                                <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a; line-height: 1.1;"><?php echo isset($multidevice_users) ? number_format($multidevice_users) : 0; ?></div>
                                <div style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Multi-Device Users</div>
                            </div>
                        </div>
                    </div>

                    <!-- Locked Accounts -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 16px;">
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px 20px; display: flex; align-items: center; gap: 16px; transition: transform 0.2s ease, box-shadow 0.2s ease;" class="kpi-card">
                            <div style="width: 46px; height: 46px; border-radius: 12px; background: rgba(244, 63, 94, 0.1); color: #f43f5e; display: flex; align-items: center; justify-content: center;">
                                <i class="material-icons" style="font-size: 24px;">lock</i>
                            </div>
                            <div>
                                <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a; line-height: 1.1;"><?php echo isset($locked_users) ? number_format($locked_users) : 0; ?></div>
                                <div style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Locked Accounts</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter & Search Controls Bar -->
            <div class="body" style="padding: 0 28px 20px 28px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px 20px;">
                    <div class="row clearfix" style="display: flex; align-items: center; flex-wrap: wrap; margin: 0; gap: 12px;">
                        
                        <!-- Search Input -->
                        <div class="col-md-4 col-sm-6 col-xs-12" style="padding: 0;">
                            <label style="font-size: 11px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; display: block;">Search Learner / Email / IP</label>
                            <div style="position: relative;">
                                <i class="material-icons" style="position: absolute; left: 10px; top: 10px; font-size: 18px; color: #94a3b8;">search</i>
                                <input type="text" id="custom_search_input" class="form-control" placeholder="Search by name, email, IP..." style="border-radius: 8px; border: 1px solid #cbd5e1; height: 38px; padding-left: 36px; font-weight: 500; color: #1e293b; background: #ffffff;">
                            </div>
                        </div>

                        <!-- Filter by Connection Status -->
                        <div class="col-md-3 col-sm-6 col-xs-12" style="padding: 0;">
                            <label style="font-size: 11px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; display: block;">Connection Status</label>
                            <select id="filter_status" class="form-control" style="border-radius: 8px; border: 1px solid #cbd5e1; height: 38px; font-weight: 600; color: #1e293b; background: #ffffff;">
                                <option value="all">All Users & Sessions</option>
                                <option value="active">Active Sessions Only</option>
                                <option value="multidevice">Multi-Device Users (>1 Connection)</option>
                                <option value="locked">Locked Accounts Only</option>
                                <option value="inactive">Inactive / Logged Out</option>
                            </select>
                        </div>

                        <!-- Filter by User Role -->
                        <div class="col-md-3 col-sm-6 col-xs-12" style="padding: 0;">
                            <label style="font-size: 11px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; display: block;">User Role</label>
                            <select id="filter_role" class="form-control" style="border-radius: 8px; border: 1px solid #cbd5e1; height: 38px; font-weight: 600; color: #1e293b; background: #ffffff;">
                                <option value="all">All User Roles</option>
                                <option value="3">Learners</option>
                                <option value="2">Instructors</option>
                                <option value="1">Administrators</option>
                            </select>
                        </div>

                        <!-- Reset Filter Action -->
                        <div class="col-md-1 col-sm-12 col-xs-12 text-right" style="padding: 0; margin-left: auto; display: flex; align-items: flex-end; justify-content: flex-end;">
                            <button type="button" id="btn_reset_filters" class="btn btn-default" title="Reset Filters & Search" style="border-radius: 8px; font-weight: 600; height: 38px; color: #64748b; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; justify-content: center; width: 100%;">
                                <i class="material-icons" style="font-size: 18px;">refresh</i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>

<div class="row clearfix index-page">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card premium-table-card">
            <div class="body table-responsive">
                <table id="sessions_table" class="table table-hover table-striped dataTable">
                    <thead>
                        <tr>
                            <?php foreach ($t_headers as $val) {
                                echo '<th>' . $val . '</th>';
                            } ?>
                        </tr>
                    </thead>
                    <tbody class="text-capitalize">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</div>

<!-- User Sessions Details Modal -->
<div class="modal fade" id="userSessionsModal" tabindex="-1" role="dialog" aria-labelledby="userSessionsModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 840px;">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
            <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 18px 24px; display: flex; align-items: center; justify-content: space-between;">
                <h4 class="modal-title" id="userSessionsModalLabel" style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="material-icons" style="color: #6366f1;">devices</i> <span id="modalUserName">User Sessions Details</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; border: none; background: none; outline: none;">&times;</button>
            </div>
            <div class="modal-body" id="modalSessionsBody" style="padding: 24px;">
                <div class="text-center" style="padding: 40px;">
                    <div class="spinner-border text-primary" role="status" style="width: 40px; height: 40px;">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div style="margin-top: 12px; color: #64748b; font-weight: 600;">Fetching session records...</div>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 24px;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 6px 20px;">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.02);
}
</style>

<script type="text/javascript">
$(document).ready(function() {
    var table = $('#sessions_table').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('admin/users/ajax_sessions_list'); ?>",
            "type": "POST",
            "data": function(d) {
                d.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
                d.status_filter = $('#filter_status').val();
                d.role_filter = $('#filter_role').val();
            }
        },
        "columnDefs": [
            { "targets": [0, 1, 7], "orderable": false }
        ],
        "order": [[3, "desc"]],
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search user, email...",
            "paginate": {
                "previous": "<i class='material-icons'>chevron_left</i>",
                "next": "<i class='material-icons'>chevron_right</i>"
            }
        },
        "drawCallback": function() {
            updateBulkButtonState();
            $('#select_all_sessions').prop('checked', false);
        }
    });

    // Helper to update bulk action button state
    function updateBulkButtonState() {
        var selectedCount = $('.session-user-checkbox:checked').length;
        $('#selected_count').text(selectedCount);
        if (selectedCount > 0) {
            $('#btn_bulk_release_lock').prop('disabled', false);
        } else {
            $('#btn_bulk_release_lock').prop('disabled', true);
        }
    }

    // Select All Checkbox Handler
    $(document).on('change', '#select_all_sessions', function() {
        var isChecked = $(this).is(':checked');
        $('.session-user-checkbox').prop('checked', isChecked);
        updateBulkButtonState();
    });

    // Individual Checkbox Handler
    $(document).on('change', '.session-user-checkbox', function() {
        updateBulkButtonState();
        var allChecked = $('.session-user-checkbox').length > 0 && $('.session-user-checkbox:checked').length === $('.session-user-checkbox').length;
        $('#select_all_sessions').prop('checked', allChecked);
    });

    // Bulk Release Lock Action
    $('#btn_bulk_release_lock').on('click', function() {
        var selectedUserIds = [];
        $('.session-user-checkbox:checked').each(function() {
            selectedUserIds.push($(this).val());
        });

        if (selectedUserIds.length === 0) {
            if (typeof swal !== 'undefined') {
                swal("Notice", "Please select at least one user.", "info");
            } else {
                alert('Please select at least one user.');
            }
            return;
        }

        var doRelease = function() {
            var $btn = $('#btn_bulk_release_lock');
            $btn.prop('disabled', true).html('<i class="material-icons" style="font-size:20px;">hourglass_top</i> Processing...');

            var postData = {
                user_ids: selectedUserIds
            };
            postData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';

            $.ajax({
                url: "<?php echo site_url('admin/users/bulk_release_lock'); ?>",
                type: "POST",
                data: postData,
                dataType: "JSON",
                success: function(res) {
                    if (res.status) {
                        table.ajax.reload(null, false);
                        if (typeof show_success === 'function') {
                            show_success(res.msg);
                        } else if (typeof swal !== 'undefined') {
                            swal("Success!", res.msg, "success");
                        } else {
                            alert(res.msg);
                        }
                    } else {
                        if (typeof show_danger === 'function') {
                            show_danger(res.msg);
                        } else if (typeof swal !== 'undefined') {
                            swal("Error!", res.msg, "error");
                        } else {
                            alert('Error: ' + res.msg);
                        }
                    }
                },
                error: function() {
                    if (typeof show_danger === 'function') {
                        show_danger('An unexpected error occurred while processing bulk lock release.');
                    } else if (typeof swal !== 'undefined') {
                        swal("Error!", "An unexpected error occurred while processing bulk lock release.", "error");
                    } else {
                        alert('An unexpected error occurred while processing bulk lock release.');
                    }
                },
                complete: function() {
                    $btn.html('<i class="material-icons" style="font-size: 20px;">lock_open</i> Bulk Release Lock ( <span id="selected_count">0</span> )');
                    updateBulkButtonState();
                }
            });
        };

        if (typeof swal !== 'undefined') {
            swal({
                title: "Are you sure?",
                text: "Release locks and clear active sessions for " + selectedUserIds.length + " selected user(s)?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4f46e5",
                confirmButtonText: "Yes, release locks!",
                closeOnConfirm: true
            }, function() {
                doRelease();
            });
        } else {
            if (confirm('Are you sure you want to release locks and clear active sessions for ' + selectedUserIds.length + ' selected user(s)?')) {
                doRelease();
            }
        }
    });

    // Custom Search Input Event Binding
    $('#custom_search_input').on('keyup change', function() {
        table.search(this.value).draw();
    });

    // Trigger Table Reload on Filter Change
    $('#filter_status, #filter_role').on('change', function() {
        table.ajax.reload();
    });

    // Reset Filters Button
    $('#btn_reset_filters').on('click', function() {
        $('#custom_search_input').val('');
        $('#filter_status').val('all');
        $('#filter_role').val('all');
        table.search('').draw();
        table.ajax.reload();
    });

    // Handle View Sessions Modal Button Click
    $(document).on('click', '.view-sessions-btn', function() {
        var userId = $(this).data('userid');
        var userName = $(this).data('username');

        $('#modalUserName').text('Sessions Details: ' + userName);
        $('#modalSessionsBody').html(
            '<div class="text-center" style="padding: 40px;">' +
            '<div style="font-size: 15px; font-weight: 600; color: #6366f1;">Loading session records...</div>' +
            '</div>'
        );
        $('#userSessionsModal').modal('show');

        $.ajax({
            url: "<?php echo site_url('admin/users/ajax_user_sessions_modal/'); ?>" + userId,
            type: "GET",
            dataType: "JSON",
            success: function(res) {
                if (res.status && res.html) {
                    $('#modalSessionsBody').html(res.html);
                } else {
                    $('#modalSessionsBody').html('<div class="alert alert-danger">Failed to load session details.</div>');
                }
            },
            error: function() {
                $('#modalSessionsBody').html('<div class="alert alert-danger">Error connecting to server.</div>');
            }
        });
    });
});
</script>
