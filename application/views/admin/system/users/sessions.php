<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- User Sessions View (Admin) -->
<div class="row clearfix animate-up">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-premium">
            <div class="header header-premium">
                <div class="header-title-group">
                    <div class="header-icon bg-indigo-soft color-indigo">
                        <i class="material-icons">devices</i>
                    </div>
                    <div>
                        <h2>User Sessions Management</h2>
                        <span class="header-subtitle">Monitor and manage active device sessions across all admin and learner accounts.</span>
                    </div>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="body" style="padding-bottom: 0;">
                <div class="row clearfix" style="margin-bottom: 20px;">
                    <div class="col-md-3 col-sm-6">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; gap: 16px;">
                            <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(99, 102, 241, 0.1); color: #6366f1; display: flex; align-items: center; justify-content: center;">
                                <i class="material-icons">devices</i>
                            </div>
                            <div>
                                <div style="font-size: 1.4rem; font-weight: 800; color: #0f172a;"><?php echo isset($total_sessions) ? $total_sessions : 0; ?></div>
                                <div style="font-size: 0.8rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Total Sessions</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; gap: 16px;">
                            <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center;">
                                <i class="material-icons">wifi_tethering</i>
                            </div>
                            <div>
                                <div style="font-size: 1.4rem; font-weight: 800; color: #0f172a;"><?php echo isset($active_sessions) ? $active_sessions : 0; ?></div>
                                <div style="font-size: 0.8rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Active Connections</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="sessions_table" style="width: 100%;">
                        <thead>
                            <tr>
                                <?php foreach ($t_headers as $header): ?>
                                    <th><?php echo $header; ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#sessions_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('admin/users/ajax_sessions_list'); ?>",
            "type": "POST"
        },
        "columnDefs": [
            { "targets": [0, 8], "orderable": false }
        ],
        "order": [[7, "desc"]],
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search sessions by user, IP, OS...",
            "paginate": {
                "previous": "<i class='material-icons'>chevron_left</i>",
                "next": "<i class='material-icons'>chevron_right</i>"
            }
        }
    });
});
</script>
