<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*Common Table View*/
?>

<div class="row clearfix index-page">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header"
                style="background: #fff; padding: 15px 25px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
                <!-- Page Heading -->
                <h2 class="text-uppercase"
                    style="margin: 0; font-weight: 700; color: #1e293b; font-size: 14px; letter-spacing: 0.05em;">
                    <?php echo lang('action_listing'); ?>
                </h2>

                <div style="display: flex; align-items: center; gap: 20px;">
                    <!-- External Search Box -->
                    <div class="global-search-wrapper">
                        <i class="material-icons">search</i>
                        <input type="text" class="global-dt-search" placeholder="Search listing..." data-table="table">
                    </div>

                    <div class="header-dropdown" style="position: static; margin: 0;">
                        <!-- Back Button -->
                        <a href="<?php echo site_url('admin') ?>"
                            class="btn btn-default btn-circle waves-effect waves-circle waves-float" title="Back"
                            style="margin-right: 5px;">
                            <i class="material-icons">arrow_back</i>
                        </a>

                        <!-- Add Button -->
                        <?php if ($this->uri->segment(2) !== 'contacts') { ?>
                            <a href="<?php echo site_url() . 'admin/' . $this->uri->segment(2) . '/form'; ?>"
                                class="btn bg-indigo btn-circle waves-effect waves-circle waves-float" title="Add New">
                                <i class="material-icons">add</i>
                            </a>
                        <?php } ?>
                    </div>
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