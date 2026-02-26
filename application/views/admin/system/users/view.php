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

<style>
    /* Premium User View Styling */
    .user-profile-premium {
        padding: 10px;
    }

    .premium-view-card {
        border-radius: 24px !important;
        border: none !important;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04) !important;
        overflow: hidden;
    }

    .cover-area {
        height: 140px;
        background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
    }

    .profile-info-content {
        padding: 0 40px 30px;
        display: flex;
        align-items: flex-end;
        margin-top: -50px;
        gap: 30px;
        flex-wrap: wrap;
    }

    .profile-avatar-wrapper {
        position: relative;
    }

    .profile-avatar-big {
        width: 140px;
        height: 140px;
        border-radius: 20%;
        border: 6px solid #fff;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        object-fit: cover;
    }

    .profile-avatar-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 800;
        background: #1e293b;
    }

    .status-indicator {
        position: absolute;
        bottom: 12px;
        right: -5px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 4px solid #fff;
    }

    .profile-text-details {
        flex: 1;
        min-width: 250px;
    }

    .name-section {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 5px;
    }

    .name-section h1 {
        font-size: 28px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        margin: 0 !important;
        letter-spacing: -0.03em !important;
    }

    .profile-actions {
        display: flex;
        gap: 12px;
        margin-bottom: 10px;
    }

    .profile-body-premium {
        padding: 40px !important;
        background: #f8fafc;
    }

    .profile-section-card {
        background: #fff;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    }

    .section-title-premium {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 20px !important;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 25px;
    }

    .detail-block label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 5px;
    }

    .detail-block p {
        font-size: 15px;
        font-weight: 600;
        color: #334155;
        margin: 0;
    }

    .about-text {
        font-size: 15px;
        line-height: 1.6;
        color: #475569;
    }

    .activity-item {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .activity-item i {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .activity-item span {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #94a3b8;
    }

    .activity-item p {
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        margin: 0;
    }

    .btn-premium-danger {
        color: #e11d48 !important;
        border: 1px solid #fee2e2 !important;
        background: #fff !important;
        padding: 12px !important;
        border-radius: 12px !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        transition: all 0.2s !important;
    }

    .btn-premium-danger:hover {
        background: #fff1f2 !important;
        border-color: #e11d48 !important;
    }

    /* Reuse from other pages */
    .bg-indigo {
        background: #6366f1;
    }

    .bg-emerald {
        background: #10b981;
    }

    .bg-slate {
        background: #64748b;
    }

    .bg-indigo-soft {
        background: rgba(99, 102, 241, 0.1);
    }

    .color-indigo {
        color: #6366f1;
    }

    .badge-premium {
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }

    .btn-premium {
        padding: 12px 24px;
        border-radius: 12px;
        border: none;
        color: white;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none !important;
    }

    .btn-action {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .animate-up {
        animation: animateUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) backwards;
    }

    @keyframes animateUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 600px) {
        .profile-info-content {
            padding: 0 20px 20px;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-top: -70px;
        }

        .name-section {
            justify-content: center;
        }

        .profile-actions {
            width: 100%;
            justify-content: center;
        }
    }
</style>