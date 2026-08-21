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

