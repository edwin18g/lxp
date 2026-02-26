<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <!-- Page Heading -->
                <h2 class="text-uppercase p-l-1-em" style="font-weight: 700; color: #1e293b;">
                    <?php echo !empty($id) ? lang('action_edit') : lang('action_create'); ?> Slider
                </h2>

                <!-- Back Button -->
                <a href="<?php echo site_url($this->uri->segment(1) . '/' . $this->uri->segment(2)) ?>"
                    class="btn btn-default btn-circle waves-effect waves-circle waves-float"
                    style="position: absolute; right: 20px; top: 15px;">
                    <i class="material-icons">close</i>
                </a>
            </div>
            <div class="body p-t-40">
                <?php echo form_open_multipart(site_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/save'), array('class' => 'form-horizontal', 'id' => 'form-create', 'role' => "form")); ?>

                <?php if (!empty($id)): ?> <!-- in case of update -->
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                <?php endif; ?>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 form-control-label">
                        <label for="title" style="color: #475569; font-weight: 600;">Title <span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input($title); ?>
                            </div>
                            <small class="text-muted">Main headline for the slider.</small>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 form-control-label">
                        <label for="subtitle" style="color: #475569; font-weight: 600;">Subtitle <span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input($subtitle); ?>
                            </div>
                            <small class="text-muted">Secondary text displayed below the title.</small>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 form-control-label">
                        <label for="button_text" style="color: #475569; font-weight: 600;">Button Text</label>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input($button_text); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 form-control-label">
                        <label for="button_link" style="color: #475569; font-weight: 600;">Button Link</label>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input($button_link); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 form-control-label">
                        <label for="order_index" style="color: #475569; font-weight: 600;">Display Order</label>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input($order_index); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 form-control-label">
                        <label for="status" style="color: #475569; font-weight: 600;">Status</label>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_dropdown($status['name'], $status['options'], $status['selected'], $status['attr']); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 form-control-label">
                        <label for="image" style="color: #475569; font-weight: 600;">
                            Slider Image <span class="text-danger">*</span>
                        </label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input($image); ?>
                            </div>
                            <small class="text-muted">Recommended size: 1920x600px or similar aspect ratio.</small>
                            <?php if (!empty($c_image)): ?>
                                <div class="m-t-20">
                                    <p style="font-weight: 600; color: #64748b;">Current Image:</p>
                                    <img src="<?php echo base_url('upload/sliders/images/' . $c_image); ?>"
                                        class="img-responsive img-thumbnail shadow-sm"
                                        style="max-width: 400px; border-radius: 8px;">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row clearfix m-t-30">
                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-12">
                        <button type="submit" class="btn bg-indigo btn-lg waves-effect shadow">
                            <i class="material-icons">save</i>
                            <span><?php echo lang('action_save'); ?> SLIDER</span>
                        </button>
                        <a href="<?php echo site_url($this->uri->segment(1) . '/' . $this->uri->segment(2)); ?>"
                            class="btn btn-default btn-lg waves-effect m-l-10">
                            <?php echo lang('action_cancel'); ?>
                        </a>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>