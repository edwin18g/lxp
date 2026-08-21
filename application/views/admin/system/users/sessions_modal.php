<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- User Session Details Modal Content -->
<div style="padding: 10px 0;">
    <!-- User Quick Info Header -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <?php $user_img = !empty($user->image) ? base_url('upload/users/images/' . $user->image) : base_url('themes/admin/img/avatar2.png'); ?>
            <img src="<?php echo $user_img; ?>" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0;" onerror="this.onerror=null;this.src='<?php echo base_url('themes/admin/img/avatar2.png'); ?>';">
            <div>
                <div style="font-size: 16px; font-weight: 700; color: #0f172a;"><?php echo htmlspecialchars(($user ? $user->first_name . ' ' . $user->last_name : 'User')); ?></div>
                <div style="font-size: 13px; color: #64748b;"><?php echo htmlspecialchars($user ? $user->email : ''); ?></div>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <?php if (!empty($user->device_locked)): ?>
                <span class="badge-premium bg-rose-soft color-rose" style="font-weight: 700;"><i class="material-icons" style="font-size: 14px; vertical-align: middle;">lock</i> Access Locked</span>
            <?php else: ?>
                <span class="badge-premium bg-emerald-soft color-emerald" style="font-weight: 700;"><i class="material-icons" style="font-size: 14px; vertical-align: middle;">lock_open</i> Access Unlocked</span>
            <?php endif; ?>

            <a href="<?php echo site_url('admin/users/release_lock/' . ($user ? $user->id : 0)); ?>" class="btn btn-xs btn-success" style="border-radius: 6px; font-weight: 700; margin-left: 4px;" onclick="return confirm('Release lock and clear all active sessions for this user?');">
                <i class="material-icons" style="font-size: 14px; vertical-align: middle;">lock_open</i> Release Lock & Clear Sessions
            </a>
        </div>
    </div>

    <!-- Sessions List Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover" style="margin-bottom: 0;">
            <thead>
                <tr style="background: #f1f5f9;">
                    <th style="width: 40px; text-align: center;">#</th>
                    <th>Device & Browser</th>
                    <th>IP Address</th>
                    <th>Status</th>
                    <th>Last Active</th>
                    <th style="width: 110px; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($sessions)): ?>
                    <?php $count = 0; foreach ($sessions as $sess): $count++; ?>
                        <?php 
                        $dev_type = strtolower($sess['device_type']);
                        $icon = ($dev_type === 'mobile') ? 'smartphone' : (($dev_type === 'tablet') ? 'tablet_mac' : 'desktop_windows');
                        ?>
                        <tr>
                            <td style="text-align: center; font-weight: 600; color: #64748b;"><?php echo $count; ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #eef2ff; color: #4f46e5; display: flex; align-items: center; justify-content: center;">
                                        <i class="material-icons" style="font-size: 18px;"><?php echo $icon; ?></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: #1e293b; font-size: 13px;">
                                            <?php echo htmlspecialchars(($sess['browser'] ? $sess['browser'] : 'Browser') . ' on ' . ($sess['os'] ? $sess['os'] : 'Device')); ?>
                                        </div>
                                        <div style="font-size: 11px; color: #94a3b8; text-transform: capitalize;">
                                            Type: <?php echo htmlspecialchars($sess['device_type'] ? $sess['device_type'] : 'desktop'); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-family: monospace; font-weight: 600; color: #334155; font-size: 13px;">
                                    <?php echo htmlspecialchars($sess['ip_address']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($sess['is_active']): ?>
                                    <span class="badge-premium bg-emerald-soft color-emerald" style="font-weight: 700;">
                                        <i class="material-icons" style="font-size: 12px; vertical-align: middle;">fiber_manual_record</i> Active
                                    </span>
                                <?php else: ?>
                                    <span class="badge-premium bg-slate-soft color-slate">
                                        Logged Out
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span style="font-size: 12px; color: #64748b;">
                                    <?php echo time_elapsed_string($sess['last_activity']); ?>
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <?php if ($sess['is_active']): ?>
                                    <a href="<?php echo site_url('admin/users/terminate_session/' . $sess['user_id'] . '/' . $sess['id']); ?>" class="btn btn-xs btn-danger" style="border-radius: 6px; font-weight: 600;" onclick="return confirm('Terminate this active session?');">
                                        <i class="material-icons" style="font-size: 14px; vertical-align: middle;">power_settings_new</i> Terminate
                                    </a>
                                <?php else: ?>
                                    <span style="color: #94a3b8; font-size: 12px;">--</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 24px; color: #94a3b8;">
                            No active session records found for this user.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
