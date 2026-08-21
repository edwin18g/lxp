<div class="row clearfix user-profile-premium">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card premium-view-card">
            <!-- Profile Header -->
            <div class="profile-header-premium">
                <div class="cover-area bg-indigo"></div>
                <div class="profile-info-content">
                    <div class="profile-avatar-wrapper">
                        <?php if (!empty($users->image)) { ?>
                            <img src="<?php echo base_url('upload/users/images/' . $users->image); ?>"
                                class="profile-avatar-big">
                        <?php } else { ?>
                            <div class="profile-avatar-big profile-avatar-placeholder bg-slate color-white">
                                <?php echo strtoupper(mb_substr($users->first_name, 0, 1) . mb_substr($users->last_name, 0, 1)); ?>
                            </div>
                        <?php } ?>
                        <span class="status-indicator <?php echo $users->active ? 'bg-emerald' : 'bg-slate'; ?>"></span>
                    </div>
                    <div class="profile-text-details">
                        <div class="name-section">
                            <h1 class="text-capitalize"><?php echo $users->first_name . ' ' . $users->last_name; ?></h1>
                            <span
                                class="badge-premium bg-indigo-soft color-indigo"><?php echo $users->group_name; ?></span>
                        </div>
                        <p class="text-muted">@<?php echo $users->username; ?> &bull; <?php echo $users->email; ?></p>
                    </div>
                    <div class="profile-actions">
                        <a href="<?php echo site_url('admin/users/form/' . $users->id) ?>"
                            class="btn-premium bg-indigo">
                            <i class="material-icons">edit</i> <span>Edit Profile</span>
                        </a>
                        <a href="<?php echo site_url('admin/users') ?>" class="btn-action bg-slate-soft">
                            <i class="material-icons">arrow_back</i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="body profile-body-premium">
                <div class="row">
                    <!-- Left Column: Details -->
                    <div class="col-md-7">
                        <div class="profile-section-card animate-up">
                            <h3 class="section-title-premium">User Information</h3>
                            <div class="details-grid">
                                <div class="detail-block">
                                    <label>Phone Number</label>
                                    <p><?php echo $users->mobile ? $users->mobile : 'Not provided'; ?></p>
                                </div>
                                <div class="detail-block">
                                    <label>Profession</label>
                                    <p><?php echo $users->profession ? $users->profession : 'N/A'; ?></p>
                                </div>
                                <div class="detail-block">
                                    <label>Experience</label>
                                    <p><?php echo $users->experience ? $users->experience . ' Years' : 'N/A'; ?></p>
                                </div>
                                <div class="detail-block">
                                    <label>Gender</label>
                                    <p><?php echo ucfirst($users->gender); ?></p>
                                </div>
                                <div class="detail-block">
                                    <label>Birthday</label>
                                    <p><?php echo $users->dob != '0000-00-00' ? date('d M Y', strtotime($users->dob)) : 'Not set'; ?>
                                    </p>
                                </div>
                                <div class="detail-block">
                                    <label>Language</label>
                                    <p><?php echo ucfirst($users->language); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="profile-section-card animate-up" style="animation-delay: 0.1s;">
                            <h3 class="section-title-premium">About Member</h3>
                            <p class="about-text">
                                <?php echo $users->about ? nl2br($users->about) : 'No bio information available for this user.'; ?>
                            </p>
                        </div>

                        <div class="profile-section-card animate-up" style="animation-delay: 0.2s;">
                            <h3 class="section-title-premium">Address</h3>
                            <p class="about-text font-italic">
                                <?php echo $users->address ? nl2br($users->address) : 'No address provided.'; ?></p>
                        </div>
                    </div>

                    <!-- Right Column: Stats & Meta -->
                    <div class="col-md-5">
                        <div class="profile-section-card stats-mini-card animate-up" style="animation-delay: 0.3s;">
                            <h3 class="section-title-premium">Account Activity</h3>
                            <div class="activity-item">
                                <i class="material-icons bg-indigo-soft color-indigo">event</i>
                                <div>
                                    <span>Joined System</span>
                                    <p><?php echo date("F j, Y g:i A ", strtotime($users->date_added)) ?></p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <i class="material-icons bg-emerald-soft color-emerald">update</i>
                                <div>
                                    <span>Last Updated</span>
                                    <p><?php echo date("F j, Y g:i A ", strtotime($users->date_updated)) ?></p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <i class="material-icons bg-amber-soft color-amber">security</i>
                                <div>
                                    <span>Login Security</span>
                                    <p><?php echo $users->active ? 'Account verified' : 'Access restricted'; ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Active Sessions -->
                        <div class="profile-section-card animate-up" style="animation-delay: 0.35s;">
                            <h3 class="section-title-premium">
                                <i class="material-icons" style="font-size:20px;">devices</i> Active Sessions
                                <?php if (!empty($user_sessions)): ?>
                                    <span class="badge-premium bg-indigo-soft color-indigo" style="margin-left:auto;"><?php echo count($user_sessions); ?> active</span>
                                <?php endif; ?>
                            </h3>

                            <?php if (empty($user_sessions)): ?>
                                <div style="text-align:center; padding:20px 0; color:#94a3b8;">
                                    <i class="material-icons" style="font-size:36px; display:block; margin-bottom:8px;">phonelink_off</i>
                                    <p style="margin:0; font-size:13px;">No active sessions</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($user_sessions as $sess): ?>
                                    <div class="admin-session-item">
                                        <div class="admin-session-info">
                                            <div class="admin-session-icon <?php echo htmlspecialchars($sess['device_type']); ?>">
                                                <?php if ($sess['device_type'] === 'mobile'): ?>
                                                    <i class="material-icons">smartphone</i>
                                                <?php elseif ($sess['device_type'] === 'tablet'): ?>
                                                    <i class="material-icons">tablet_mac</i>
                                                <?php else: ?>
                                                    <i class="material-icons">computer</i>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <p class="admin-session-name"><?php echo htmlspecialchars($sess['browser'] . ' on ' . $sess['os']); ?></p>
                                                <p class="admin-session-meta">
                                                    <i class="material-icons" style="font-size:13px;">language</i> <?php echo htmlspecialchars($sess['ip_address']); ?>
                                                    &bull;
                                                    <i class="material-icons" style="font-size:13px;">schedule</i> <?php echo date('M d, g:i A', $sess['last_activity']); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <a href="<?php echo site_url('admin/users/terminate_session/' . $users->id . '/' . $sess['id']); ?>"
                                            class="btn-table-action color-rose bg-rose-soft"
                                            title="Terminate Session"
                                            onclick="return confirm('Terminate this session?')">
                                            <i class="material-icons">remove_circle_outline</i>
                                        </a>
                                    </div>
                                <?php endforeach; ?>

                                <?php if (count($user_sessions) > 1): ?>
                                    <div style="margin-top:12px; text-align:center;">
                                        <a href="<?php echo site_url('admin/users/terminate_all_sessions/' . $users->id); ?>"
                                            class="btn-premium-danger-inline"
                                            onclick="return confirm('Terminate ALL sessions for this user?')">
                                            <i class="material-icons" style="font-size:16px;">block</i>
                                            Terminate All Sessions
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Dangerous Actions -->
                        <div class="profile-section-card animate-up" style="animation-delay: 0.4s;">
                            <h3 class="section-title-premium">Administrative Actions</h3>
                            <div class="btn-group-vertical w-100">
                                <button type="button" onclick="ajaxDelete(<?php echo $users->id; ?>, ``, `User`)"
                                    class="btn btn-block btn-outline-danger btn-premium-danger">
                                    <i class="material-icons">delete_forever</i>
                                    <span>Delete this user permanently</span>
                                </button>
                                <?php if ($users->device_locked) { ?>
                                    <a href="<?php echo site_url('admin/users/unlock_device/' . $users->id) ?>"
                                        class="btn btn-block btn-outline-warning btn-premium-warning">
                                        <i class="material-icons">phonelink_erase</i>
                                        <span>Reset Device Lock</span>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

