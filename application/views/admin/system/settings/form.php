<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
/* Modern Settings UI Enhancements */
.settings-container-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(226, 232, 240, 0.8);
    overflow: hidden;
    margin-bottom: 30px;
}

.settings-header-banner {
    padding: 24px 32px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: #ffffff;
}

.settings-header-banner h3 {
    margin: 0 0 6px 0;
    font-size: 1.4rem;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #ffffff;
}

.settings-header-banner p {
    margin: 0;
    opacity: 0.85;
    font-size: 0.9rem;
}

/* Custom Styled Tabs */
.settings-tabs-wrapper {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 12px 24px 0 24px;
    display: flex;
    gap: 8px;
    overflow-x: auto;
}

.settings-tabs-wrapper .nav-tabs {
    border-bottom: none;
    display: flex;
    gap: 8px;
    margin: 0;
}

.settings-tabs-wrapper .nav-tabs > li {
    margin-bottom: 0;
}

.settings-tabs-wrapper .nav-tabs > li > a {
    border: none !important;
    border-radius: 10px 10px 0 0 !important;
    padding: 12px 20px !important;
    font-weight: 600 !important;
    font-size: 0.9rem !important;
    color: #64748b !important;
    background: transparent !important;
    transition: all 0.25s ease !important;
    display: flex;
    align-items: center;
    gap: 8px;
}

.settings-tabs-wrapper .nav-tabs > li > a:hover {
    color: #4f46e5 !important;
    background: rgba(241, 245, 249, 0.8) !important;
}

.settings-tabs-wrapper .nav-tabs > li.active > a,
.settings-tabs-wrapper .nav-tabs > li.active > a:focus,
.settings-tabs-wrapper .nav-tabs > li.active > a:hover {
    color: #4f46e5 !important;
    background: #ffffff !important;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.03);
    border-top: 3px solid #4f46e5 !important;
}

/* Form Body Area */
.settings-form-body {
    padding: 32px;
}

.settings-field-group {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 20px;
    transition: all 0.2s ease;
}

.settings-field-group:focus-within,
.settings-field-group:hover {
    border-color: #cbd5e1;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
}

.settings-field-group label.control-label {
    font-weight: 600 !important;
    color: #1e293b !important;
    font-size: 0.95rem !important;
    margin-bottom: 8px !important;
    display: block;
}

.settings-field-group .required {
    color: #ef4444;
    font-weight: bold;
    margin-left: 4px;
}

/* Form Controls Improvement */
.settings-field-group .form-control {
    border: 1px solid #cbd5e1 !important;
    border-radius: 8px !important;
    padding: 10px 14px !important;
    height: auto !important;
    font-size: 0.95rem !important;
    color: #334155 !important;
    background-color: #f8fafc !important;
    transition: all 0.2s ease !important;
    box-shadow: none !important;
}

.settings-field-group .form-control:focus {
    border-color: #6366f1 !important;
    background-color: #ffffff !important;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15) !important;
}

.settings-field-group textarea.form-control {
    min-height: 100px;
    line-height: 1.6;
}

.settings-field-group .help-block {
    margin-top: 8px;
    font-size: 0.82rem;
    color: #64748b;
}

/* Picture Upload Styling */
.settings-field-group .picture-container {
    margin-top: 10px;
}

.settings-field-group .picture-container .picture {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 12px;
    background: #f8fafc;
    transition: all 0.2s;
}

.settings-field-group .picture-container .picture:hover {
    border-color: #6366f1;
    background: #eef2ff;
}

/* Action Buttons */
.settings-action-bar {
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    gap: 12px;
    align-items: center;
}

.btn-settings-save {
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    color: #ffffff !important;
    border: none;
    border-radius: 10px;
    padding: 12px 32px;
    font-weight: 600;
    font-size: 0.95rem;
    box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
    transition: all 0.25s ease;
    cursor: pointer;
}

.btn-settings-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
    color: #ffffff !important;
}

.btn-settings-cancel {
    background: #f1f5f9;
    color: #475569 !important;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    text-decoration: none !important;
}

.btn-settings-cancel:hover {
    background: #e2e8f0;
    color: #1e293b !important;
}
</style>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="settings-container-card">
            
            <!-- Header Banner -->
            <div class="settings-header-banner">
                <h3>System Settings</h3>
                <p>Manage site configurations, preferences, theme settings, and promotional popups.</p>
            </div>

            <!-- Settings Tabs Header -->
            <div class="settings-tabs-wrapper">
                <ul class="nav nav-tabs">
                <?php $t_count = 0; foreach($settings as $k => $v) { $t_count++; ?>
                    <li class="<?php echo $k == 'institute' ? 'active' : ''; ?>">
                        <a href="#tab_<?php echo $t_count; ?>" data-toggle="tab" class="text-capitalize">
                            <i class="material-icons" style="font-size: 18px;">
                                <?php 
                                    switch($k) {
                                        case 'institute': echo 'business'; break;
                                        case 'site': echo 'language'; break;
                                        case 'home': echo 'home'; break;
                                        case 'theme': echo 'palette'; break;
                                        case 'booking': echo 'event'; break;
                                        case 'email': echo 'email'; break;
                                        case 'social': echo 'share'; break;
                                        default: echo 'tune'; break;
                                    }
                                ?>
                            </i>
                            <?php echo str_replace("_", " ", $k); ?>
                        </a>
                    </li>
                <?php } ?>
                </ul>
            </div>

            <!-- Tab Contents -->
            <div class="tab-content settings-form-body">
            <?php $tab_count = 0; foreach($settings as $key => $val) { $tab_count++; ?>    
                <div class="tab-pane <?php echo $key == 'institute' ? 'active' : ''; ?>" id="tab_<?php echo $tab_count; ?>">
                <?php echo form_open_multipart('', array('role'=>'form')); ?>
                
                <div class="row clearfix">
                <?php foreach ($val as $setting) : ?>

                <?php 
                $field_data = array();

                if ($setting['is_numeric'])
                {
                    $field_data['type'] = "number";
                    $field_data['step'] = "any";
                }

                if ($setting['options'])
                {
                    $field_options = array();
                    if ($setting['input_type'] == "dropdown")
                    {
                        $field_options[''] = lang('admin input select');
                    }
                    $lines = explode("\n", $setting['options']);
                    foreach ($lines as $line)
                    {
                        $option = explode("|", $line);
                        $field_options[$option[0]] = $option[1];
                    }
                }

                switch ($setting['input_size'])
                {
                    case "small":
                        $col_size = "col-md-4 col-sm-6";
                        break;
                    case "medium":
                        $col_size = "col-md-6 col-sm-12";
                        break;
                    case "large":
                        $col_size = "col-md-12";
                        break;
                    default:
                        $col_size = "col-md-6 col-sm-12";
                }

                if ($setting['input_type'] == 'textarea')
                {
                    $col_size = "col-md-12";
                }
                ?>

                <?php 
                $field_data['name']  = $setting['name'];
                $field_data['id']    = $setting['name'];
                $field_data['class'] = "form-control" . (($setting['show_editor']) ? " tinymce" : "") . (($setting['input_type'] == 'dropdown') ? " show-tick" : "");
                $field_data['value'] = $setting['value'];
                ?>

                    <div class="<?php echo $col_size; ?> col-xs-12">
                        <div class="settings-field-group <?php echo form_error($setting['name']) ? 'has-error' : ''; ?>">
                            <?php echo form_label($setting['label'], $setting['name'], array('class'=>'control-label')); ?>
                            <?php if (strpos($setting['validation'], 'required') !== FALSE) : ?>
                                <span class="required">*</span>
                            <?php endif; ?>

                            <?php 
                            if ($setting['input_type'] == 'input')
                            {
                                echo '<div class="form-line">';
                                echo form_input($field_data);
                                echo '</div>';
                            }
                            elseif ($setting['input_type'] == 'file')
                            { ?>
                                <div class="picture-container">
                                    <div class="picture picture-square <?php echo $key == 'institute' ? 'width-72' : 'width-50' ?>">
                                        <img id="i_<?php echo $field_data['id'] ?>" src="<?php echo base_url('upload/'.$key.'/'.$field_data['value']); ?>" class="img-responsive" onerror="this.src='<?php echo base_url('upload/default_course_banner.png'); ?>';">
                                        <?php echo form_upload($field_data);?>
                                    </div>
                                </div>
                            <?php }
                            elseif ($setting['input_type'] == 'email')
                            {
                                echo '<div class="form-line">';
                                echo form_input_custom($field_data, 'email');
                                echo '</div>';
                            }
                            elseif ($setting['input_type'] == 'textarea')
                            {
                                echo '<div class="form-line">';
                                echo form_textarea($field_data);
                                echo '</div>';
                            }
                            elseif ($setting['input_type'] == 'radio')
                            {
                                echo '<div class="form-line">';
                                echo "<br />";
                                foreach ($field_options as $value=>$label)
                                {
                                    echo form_radio(array('name'=>$field_data['name'], 'id'=>$field_data['id'] . "-" . $value, 'value'=>$value, 'checked'=>(($value == $field_data['value']) ? 'checked' : FALSE)));
                                    echo $label;
                                }
                                echo '</div>';
                            }
                            elseif ($setting['input_type'] == 'dropdown')
                            {   
                                echo '<div class="form-line">';
                                echo form_dropdown($setting['name'], $field_options, $field_data['value'], 'id="' . $field_data['id'] . '" class="' . $field_data['class'] . '"');
                                echo '</div>';
                            }
                            elseif ($setting['input_type'] == 'timezones')
                            {
                                echo '<div class="form-line">';
                                echo "<br />";
                                echo timezone_menu($field_data['value'], 'show-tick');
                                echo '</div>';
                            }
                            elseif ($setting['input_type'] == 'currencies')
                            {
                                echo '<div class="form-line">';
                                echo "<br />";
                                echo currency_menu($field_data['value'], 'show-tick', $field_data['name']);
                                echo '</div>';
                            }
                            elseif ($setting['input_type'] == 'email_templates')
                            {
                                echo '<div class="form-line">';
                                echo "<br />";
                                echo email_template_menu($field_data['value'], 'show-tick', $field_data['name']);
                                echo '</div>';
                            }
                            elseif ($setting['input_type'] == 'languages')
                            {
                                echo '<div class="form-line">';
                                echo "<br />";
                                echo language_menu($field_data['value'], 'show-tick', $field_data['name']);
                                echo '</div>';
                            }
                            elseif ($setting['input_type'] == 'taxes')
                            {   
                                echo '<div class="form-line">';
                                echo "<br />";
                                echo tax_menu($field_data['value'], 'show-tick', $field_data['name']);
                                echo '</div>';
                            }
                            ?>

                            <?php if ($setting['help_text']) : ?>
                                <span class="help-block"><?php echo $setting['help_text']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php endforeach; ?>
                </div>

                <div class="settings-action-bar">
                    <button type="submit" name="submit" class="btn-settings-save text-capitalize">
                        <i class="material-icons" style="font-size: 18px; vertical-align: middle; margin-right: 4px;">save</i>
                        <?php echo lang('action_save').' ('.str_replace("_", " ", $key).')'; ?>
                    </button>
                    <a class="btn-settings-cancel" href="<?php echo site_url($this->uri->segment(1).'/'); ?>">
                        <?php echo lang('action_cancel'); ?>
                    </a>
                </div>
                
                <?php echo form_close(); ?>
                </div>
                <!-- /.tab-pane -->
            <?php } ?> <!-- End top most foreach loop -->
            </div>
            <!-- /.tab-content -->

        </div>
    </div>
</div>