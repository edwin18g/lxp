<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*Common Table View*/
?>

<div class="row clearfix index-page">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header"
                style="background: #fff; padding: 15px 25px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
                <h2 class="text-uppercase"
                    style="margin: 0; font-weight: 700; color: #1e293b; font-size: 14px; letter-spacing: 0.05em;">
                    Lectures Listing
                </h2>

                <div style="display: flex; align-items: center; gap: 20px;">
                    <!-- External Search Box -->
                    <div class="global-search-wrapper">
                        <i class="material-icons">search</i>
                        <input type="text" class="global-dt-search" placeholder="Search lectures..."
                            data-table="lecture">
                    </div>

                    <div class="header-dropdown" style="position: static; margin: 0;">
                        <a href="<?php echo site_url('admin/lecture/form'); ?>"
                            class="btn bg-indigo btn-circle waves-effect waves-circle waves-float" title="Add New">
                            <i class="material-icons">add</i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="body table-responsive">
                <table id="lecture" class="table table-striped table-hover dataTable">
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