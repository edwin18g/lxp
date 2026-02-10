<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <!-- Page Heading -->
                <h2 class="text-uppercase p-l-3-em">
                    <?php echo !empty($id) ? lang('action_edit') : lang('action_create'); ?> Slider
                </h2>

                <!-- Back Button -->
                <a href="<?php echo site_url($this->uri->segment(1) . '/' . $this->uri->segment(2)) ?>"
                    class="btn btn-default btn-circle-wave-effect btn-tooltip-back">
                    <i class="material-icons">chevron_left</i>
                </a>
            </div>
            <div class="body">
                <?php echo form_open_multipart(site_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/save'), array('class' => 'form-horizontal', 'id' => 'form-create', 'role' => "form")); ?>

                <?php if (!empty($id)): ?> <!-- in case of update -->
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                <?php endif; ?>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="title">Title</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input($title); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="subtitle">Subtitle</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input($subtitle); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="button_text">Button Text</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input($button_text); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="button_link">Button Link</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input($button_link); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="order_index">Order</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input($order_index); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="image">
                            <?php echo lang('common_image'); ?>
                        </label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input($image); ?>
                            </div>
                            <?php if (!empty($c_image)): ?>
                                <br>
                                <img src="<?php echo base_url('upload/sliders/images/' . $c_image); ?>" class="img-responsive"
                                    width="200">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="status">
                            <?php echo lang('common_status'); ?>
                        </label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_dropdown($status['name'], $status['options'], $status['selected'], $status['attr']); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                        <div class="btn-group">
                            <button type="submit" class="btn bg-orange btn-lg waves-effect">
                                <?php echo lang('action_save'); ?>
                            </button>
                        </div>
                        <div class="btn-group">
                            <a href="<?php echo site_url($this->uri->segment(1) . '/' . $this->uri->segment(2)); ?>"
                                class="btn btn-default btn-lg waves-effect">
                                <?php echo lang('action_cancel'); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>