<div class="row clearfix users-form-premium">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card premium-form-card">
            <div class="header">
                <div class="title-section">
                    <h2 class="text-uppercase"><?php echo !empty($id) ? 'Edit User Profile' : 'Create New User'; ?></h2>
                    <p class="text-muted small">Update member information and account settings</p>
                </div>

                <div class="header-actions">
                    <!-- Back Button -->
                    <?php if (!$this->input->is_ajax_request()) { ?>
                        <a href="<?php echo site_url($this->uri->segment(1) . '/' . $this->uri->segment(2)) ?>"
                            class="btn-action bg-slate-soft" title="Back">
                            <i class="material-icons">arrow_back</i>
                        </a>
                    <?php } ?>

                    <!-- Delete Button -->
                    <?php if (!empty($id)) { ?>
                        <a role="button" onclick="ajaxDelete(<?php echo $id; ?>, ``, `User`)"
                            class="btn-action bg-rose-soft color-rose" title="Delete User">
                            <i class="material-icons">delete_outline</i>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <div class="body">
                <?php echo form_open_multipart(site_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . 'save'), array('class' => 'form-premium', 'id' => 'form-create', 'role' => "form")); ?>

                <?php if (!empty($id)) { ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                <?php } ?>

                <div class="row clearfix">
                    <!-- Profile Image Section -->
                    <div class="col-md-2">
                        <div class="section-title">Profile Picture</div>
                        <div class="picture-container-premium">
                            <div class="picture-premium">
                                <?php if (!empty($c_image)) { ?>
                                    <img id="c_image"
                                        src="<?php echo base_url('upload/users/images/' . image_to_thumb($c_image)); ?>"
                                        class="img-preview">
                                <?php } else { ?>
                                    <img id="c_image" src="<?php echo base_url('themes/admin/img/avatar2.png'); ?>"
                                        class="img-preview">
                                <?php } ?>
                                <div class="upload-overlay">
                                    <i class="material-icons">camera_alt</i>
                                    <span>Change PHOTO</span>
                                </div>
                                <?php echo form_input($image); ?>
                            </div>
                            <p class="help-text">Click image to upload</p>
                        </div>
                    </div>

                    <!-- Basic Info Section -->
                    <div class="col-md-10">
                        <div class="section-title">Basic Information</div>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label>First Name</label>
                                    <div class="form-line-premium">
                                        <?php echo form_input($first_name); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label>Last Name</label>
                                    <div class="form-line-premium">
                                        <?php echo form_input($last_name); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label>Username</label>
                                    <div class="form-line-premium">
                                        <?php echo form_input($username); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label>Email Address</label>
                                    <div class="form-line-premium">
                                        <?php echo form_input($email); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label>Mobile Number</label>
                                    <div class="form-line-premium">
                                        <?php echo form_input($mobile); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label>Date of Birth</label>
                                    <div class="form-line-premium">
                                        <?php echo form_input($dob); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="divider-premium"></div>

                <div class="row clearfix">
                    <!-- Professional Info -->
                    <div class="col-md-6">
                        <div class="section-title">Professional Details</div>
                        <div class="form-group-premium">
                            <label>Profession</label>
                            <div class="form-line-premium">
                                <?php echo form_input($profession); ?>
                            </div>
                        </div>
                        <div class="form-group-premium">
                            <label>Experience (Years)</label>
                            <div class="form-line-premium">
                                <?php echo form_input($experience); ?>
                            </div>
                        </div>
                        <div class="form-group-premium">
                            <label>Gender</label>
                            <div class="form-line-premium">
                                <?php echo form_dropdown($gender); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Account Security -->
                    <div class="col-md-6">
                        <div class="section-title">Account & Security</div>
                        <div class="form-group-premium">
                            <label>New Password (leave blank to keep current)</label>
                            <div class="form-line-premium">
                                <?php echo form_password($password); ?>
                            </div>
                        </div>
                        <div class="form-group-premium">
                            <label>Confirm Password</label>
                            <div class="form-line-premium">
                                <?php echo form_password($password_confirm); ?>
                            </div>
                        </div>
                        <?php if ($this->ion_auth->is_admin()) { ?>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group-premium">
                                        <label>User Role</label>
                                        <div class="form-line-premium">
                                            <?php echo form_dropdown($groups); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-premium">
                                        <label>Account Status</label>
                                        <div class="form-line-premium">
                                            <?php echo form_dropdown($status); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="form-group-premium">
                            <label>About User</label>
                            <div class="form-line-premium">
                                <?php echo form_textarea($about); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions-premium text-right">
                    <button type="submit" class="btn-premium bg-indigo">
                        <span><?php echo lang('action_submit') ?></span>
                        <i class="material-icons">send</i>
                    </button>
                    <span id="submit_loader"></span>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* Premium Form Styling */
    .premium-form-card {
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04) !important;
        overflow: hidden;
    }

    .premium-form-card .header {
        padding: 40px !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: flex-start !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .premium-form-card .header h2 {
        font-size: 24px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        letter-spacing: -0.02em !important;
    }

    .section-title {
        font-size: 14px;
        font-weight: 800;
        color: #6366f1;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #f1f5f9;
    }

    .form-group-premium {
        margin-bottom: 25px;
    }

    .form-group-premium label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
    }

    .form-line-premium input,
    .form-line-premium select,
    .form-line-premium textarea {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid #e2e8f0 !important;
        background: #f8fafc !important;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .form-line-premium input:focus,
    .form-line-premium select:focus,
    .form-line-premium textarea:focus {
        border-color: #6366f1 !important;
        background: #fff !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        outline: none;
    }

    /* Picture Container */
    .picture-container-premium {
        text-align: center;
        margin-bottom: 30px;
    }

    .picture-premium {
        width: 150px;
        height: 150px;
        background-color: #f1f5f9;
        border: 4px solid #fff;
        color: #fff;
        border-radius: 20%;
        margin: 0 auto;
        overflow: hidden;
        transition: all 0.2s;
        cursor: pointer;
        position: relative;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .picture-premium:hover {
        border-color: #6366f1;
        transform: scale(1.02);
    }

    .picture-premium input[type="file"] {
        cursor: pointer;
        display: block;
        height: 100%;
        left: 0;
        opacity: 0 !important;
        position: absolute;
        top: 0;
        width: 100%;
    }

    .img-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .upload-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.6);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .picture-premium:hover .upload-overlay {
        opacity: 1;
    }

    .upload-overlay span {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        margin-top: 5px;
    }

    .help-text {
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
        margin-top: 10px;
    }

    .divider-premium {
        height: 1px;
        background: #f1f5f9;
        margin: 40px 0;
    }

    /* Buttons */
    .btn-action {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none !important;
        transition: all 0.2s ease;
        margin-left: 10px;
        border: none;
        cursor: pointer;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        filter: brightness(0.95);
    }

    .btn-premium {
        padding: 14px 32px;
        border-radius: 14px;
        border: none;
        color: white;
        font-weight: 700;
        font-size: 15px;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
    }

    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px -5px rgba(99, 102, 241, 0.5);
    }

    /* Colors and Helpers */
    .bg-indigo {
        background: #6366f1;
    }

    .bg-slate-soft {
        background: #f1f5f9;
        color: #475569;
    }

    .bg-rose-soft {
        background: #fff1f2;
        color: #e11d48;
    }

    .color-rose {
        color: #e11d48;
    }

    .text-muted {
        color: #64748b !important;
    }

    @media (max-width: 768px) {
        .premium-form-card .header {
            padding: 25px !important;
        }

        .body {
            padding: 20px !important;
        }
    }
</style>