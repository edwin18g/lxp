<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    .sessions-page {
        padding: 40px 0;
    }
    .sessions-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .sessions-header h3 {
        margin: 0;
        font-weight: 600;
        color: #1a1a1a;
    }
    .session-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        transition: box-shadow 0.2s;
    }
    .session-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .session-card.current {
        border-left: 4px solid #28a745;
    }
    .session-info {
        display: flex;
        align-items: center;
        gap: 16px;
        flex: 1;
    }
    .session-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .session-icon.desktop {
        background: #e8f0fe;
        color: #1967d2;
    }
    .session-icon.mobile {
        background: #fce8e6;
        color: #d93025;
    }
    .session-icon.tablet {
        background: #e6f4ea;
        color: #137333;
    }
    .session-details h5 {
        margin: 0 0 4px;
        font-size: 15px;
        font-weight: 600;
        color: #1a1a1a;
    }
    .session-meta {
        font-size: 13px;
        color: #6c757d;
        margin: 0;
    }
    .session-meta span {
        margin-right: 16px;
    }
    .session-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .badge-current {
        display: inline-block;
        background: #28a745;
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-terminate {
        background: none;
        border: 1px solid #dc3545;
        color: #dc3545;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-terminate:hover {
        background: #dc3545;
        color: #fff;
    }
    .btn-terminate-all {
        background: #dc3545;
        border: 1px solid #dc3545;
        color: #fff;
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-terminate-all:hover {
        background: #c82333;
        border-color: #bd2130;
    }
    .no-sessions {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }
    .no-sessions i {
        font-size: 48px;
        margin-bottom: 16px;
        color: #dee2e6;
    }
</style>

<div class="page-default bg-grey">
    <div class="container">
        <div class="sessions-page">
            <div class="sessions-header">
                <h3><i class="fa fa-shield"></i> Active Sessions</h3>
                <?php if (count($sessions) > 1): ?>
                    <?php echo form_open('profile/sessions', array('style' => 'display:inline')); ?>
                        <input type="hidden" name="action" value="terminate_all">
                        <button type="submit" class="btn-terminate-all"
                            onclick="return confirm('This will log you out from all other devices. Continue?')">
                            <i class="fa fa-sign-out"></i> Terminate All Other Sessions
                        </button>
                    <?php echo form_close(); ?>
                <?php endif; ?>
            </div>

            <?php if (empty($sessions)): ?>
                <div class="no-sessions">
                    <i class="fa fa-desktop"></i>
                    <h4>No active sessions found</h4>
                    <p>You don't have any active sessions at the moment.</p>
                </div>
            <?php else: ?>
                <?php foreach ($sessions as $sess): ?>
                    <?php $is_current = ($sess['session_id'] === $current_session_id); ?>
                    <div class="session-card <?php echo $is_current ? 'current' : ''; ?>">
                        <div class="session-info">
                            <div class="session-icon <?php echo htmlspecialchars($sess['device_type']); ?>">
                                <?php if ($sess['device_type'] === 'mobile'): ?>
                                    <i class="fa fa-mobile"></i>
                                <?php elseif ($sess['device_type'] === 'tablet'): ?>
                                    <i class="fa fa-tablet"></i>
                                <?php else: ?>
                                    <i class="fa fa-desktop"></i>
                                <?php endif; ?>
                            </div>
                            <div class="session-details">
                                <h5>
                                    <?php echo htmlspecialchars($sess['browser']); ?>
                                    on <?php echo htmlspecialchars($sess['os']); ?>
                                </h5>
                                <p class="session-meta">
                                    <span><i class="fa fa-globe"></i> <?php echo htmlspecialchars($sess['ip_address']); ?></span>
                                    <span><i class="fa fa-clock-o"></i> <?php echo date('M d, Y g:i A', $sess['last_activity']); ?></span>
                                </p>
                            </div>
                        </div>
                        <div class="session-actions">
                            <?php if ($is_current): ?>
                                <span class="badge-current">Current Session</span>
                            <?php else: ?>
                                <?php echo form_open('profile/sessions', array('style' => 'display:inline')); ?>
                                    <input type="hidden" name="action" value="terminate">
                                    <input type="hidden" name="session_id" value="<?php echo $sess['id']; ?>">
                                    <button type="submit" class="btn-terminate"
                                        onclick="return confirm('Terminate this session?')">
                                        <i class="fa fa-times"></i> Terminate
                                    </button>
                                <?php echo form_close(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
