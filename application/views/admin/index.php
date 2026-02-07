<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*Common Table View*/
?>

<div class="row clearfix index-page">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header"
                style="background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); color: white; padding: 20px;">
                <!-- Page Heading -->
                <h2 class="text-uppercase" style="margin: 0; font-weight: 500;">
                    <?php echo lang('action_listing'); ?>
                </h2>

                <div class="header-dropdown m-r--5">
                    <!-- Back Button -->
                    <a href="<?php echo site_url('admin') ?>"
                        class="btn btn-default btn-circle waves-effect waves-circle waves-float" title="Back"
                        style="margin-right: 10px;">
                        <i class="material-icons">arrow_back</i>
                    </a>

                    <!-- Add Button -->
                    <?php if ($this->uri->segment(2) !== 'contacts') { ?>
                        <a href="<?php echo site_url() . 'admin/' . $this->uri->segment(2) . '/form'; ?>"
                            class="btn btn-default btn-circle waves-effect waves-circle waves-float" title="Add New">
                            <i class="material-icons">add</i>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <div class="body table-responsive">
                <table id="table" class="table table-hover dataTable">
                    <thead>
                        <tr>
                            <?php foreach ($t_headers as $val) {
                                echo '<th>' . $val . '</th>';
                            } ?>
                        </tr>
                    </thead>
                    <tbody class="text-capitalize">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>