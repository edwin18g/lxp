<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$uid = $user ? (int) $user->id : 0;
$uname = htmlspecialchars($user ? trim($user->first_name . ' ' . $user->last_name) : 'this user', ENT_QUOTES);
$has_active = FALSE;
foreach ($sessions as $s) {
    if ($s['is_active']) { $has_active = TRUE; break; }
}
?>

<!-- Access status + actions -->
<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
    <div style="font-size: 13px; color: #64748b;">
        <?php echo htmlspecialchars($user ? $user->email : ''); ?>
        &nbsp;·&nbsp;
        <?php if (!empty($user->device_locked)): ?>
            <span class="badge-premium bg-rose-soft color-rose"><i class="material-icons" style="font-size: 14px; vertical-align: middle;">lock</i> Locked</span>
        <?php else: ?>
            <span class="badge-premium bg-emerald-soft color-emerald">Allowed</span>
        <?php endif; ?>
    </div>
    <div style="display: flex; gap: 6px;">
        <?php if ($has_active): ?>
            <button type="button" class="btn btn-sm btn-default logout-devices-btn" data-userid="<?php echo $uid; ?>" data-username="<?php echo $uname; ?>" style="border-radius: 6px; font-weight: 600;">Log out all devices</button>
        <?php endif; ?>
        <?php if (!empty($user->device_locked)): ?>
            <button type="button" class="btn btn-sm btn-success lock-toggle-btn" data-userid="<?php echo $uid; ?>" data-username="<?php echo $uname; ?>" data-lock="0" style="border-radius: 6px; font-weight: 600;">Unlock</button>
        <?php else: ?>
            <button type="button" class="btn btn-sm btn-danger lock-toggle-btn" data-userid="<?php echo $uid; ?>" data-username="<?php echo $uname; ?>" data-lock="1" style="border-radius: 6px; font-weight: 600;">Lock</button>
        <?php endif; ?>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover" style="margin-bottom: 0;">
        <thead>
            <tr>
                <th>Device</th>
                <th>IP Address</th>
                <th>Status</th>
                <th>Last Active</th>
                <th style="width: 90px;"></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($sessions)): ?>
                <?php foreach ($sessions as $sess): ?>
                    <?php
                    $dev_type = strtolower((string) $sess['device_type']);
                    $icon = ($dev_type === 'mobile') ? 'smartphone' : (($dev_type === 'tablet') ? 'tablet_mac' : 'desktop_windows');
                    ?>
                    <tr>
                        <td>
                            <i class="material-icons" style="font-size: 18px; vertical-align: middle; color: #4f46e5;"><?php echo $icon; ?></i>
                            <span style="font-weight: 600; color: #1e293b;">
                                <?php echo htmlspecialchars(($sess['browser'] ? $sess['browser'] : 'Browser') . ' on ' . ($sess['os'] ? $sess['os'] : 'Device')); ?>
                            </span>
                        </td>
                        <td style="font-family: monospace;"><?php echo htmlspecialchars($sess['ip_address']); ?></td>
                        <td>
                            <?php if ($sess['is_live']): ?>
                                <span class="badge-premium bg-emerald-soft color-emerald">Online</span>
                            <?php elseif ($sess['is_expired']): ?>
                                <span class="badge-premium bg-amber-soft color-amber" title="Idle beyond session lifetime without logging out">Expired</span>
                            <?php else: ?>
                                <span class="badge-premium bg-slate-soft color-slate">Logged out</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-size: 12px; color: #64748b;"><?php echo time_elapsed_string($sess['last_activity']); ?></td>
                        <td>
                            <?php if ($sess['is_active']): ?>
                                <button type="button" class="btn btn-xs btn-default terminate-session-btn" data-userid="<?php echo (int) $sess['user_id']; ?>" data-sessid="<?php echo (int) $sess['id']; ?>" style="border-radius: 6px;">Log out</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center" style="padding: 24px; color: #94a3b8;">No session records found for this user.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
