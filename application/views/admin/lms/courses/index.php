<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*Common Table View*/
?>

<!-- Quick Stats -->
<div class="row clearfix">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box-2 hover-zoom-effect">
            <div class="icon bg-gradient-cyan">
                <i class="material-icons col-white">import_contacts</i>
            </div>
            <div class="content">
                <div class="text">Total Courses</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_courses; ?>" data-speed="1000"
                    data-fresh-interval="20"><?php echo $total_courses; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box-2 hover-zoom-effect">
            <div class="icon bg-gradient-light-green">
                <i class="material-icons col-white">check_circle</i>
            </div>
            <div class="content">
                <div class="text">Active Courses</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $active_courses; ?>" data-speed="1000"
                    data-fresh-interval="20"><?php echo $active_courses; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box-2 hover-zoom-effect">
            <div class="icon bg-gradient-pink">
                <i class="material-icons col-white">star</i>
            </div>
            <div class="content">
                <div class="text">Featured Courses</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $featured_courses; ?>" data-speed="1000"
                    data-fresh-interval="20"><?php echo $featured_courses; ?></div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Quick Stats -->

<!-- Toolbar -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" style="box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
            <div class="body" style="padding: 15px 20px;">
                <div class="row clearfix" style="display: flex; align-items: center; flex-wrap: wrap;">
                    <!-- Category Filter -->
                    <div class="col-md-3 col-sm-6" style="margin-bottom: 0;">
                        <select id="category_filter" class="form-control show-tick" data-style="btn-default"
                            title="Select Category">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $cat) { ?>
                                <option value="<?php echo $cat->id; ?>"><?php echo $cat->title; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-3 col-sm-6" style="margin-bottom: 0;">
                        <select id="status_filter" class="form-control show-tick" data-style="btn-default"
                            title="Select Status">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- Custom Search and Add Button combined into a new header structure -->
                    <div class="col-md-6 col-sm-12" style="margin-bottom: 0;">
                        <div class="header"
                            style="background: #fff; padding: 0; border-bottom: none; display: flex; align-items: center; justify-content: flex-end;">
                            <div style="display: flex; align-items: center; gap: 20px;">
                                <!-- External Search Box -->
                                <div class="global-search-wrapper">
                                    <i class="material-icons">search</i>
                                    <input type="text" class="global-dt-search" placeholder="Search courses..."
                                        data-table="courses_table">
                                </div>

                                <div class="header-dropdown" style="position: static; margin: 0;">
                                    <a href="<?php echo site_url('admin/courses/form'); ?>"
                                        class="btn bg-indigo btn-circle waves-effect waves-circle waves-float"
                                        title="Add New Course">
                                        <i class="material-icons">add</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Toolbar -->

<div class="row clearfix index-page">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="">

            <div class="body table-responsive">
                <table id="courses_table" class="table table-striped table-hover dataTable">
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

<script>
    var table;
    $(document).ready(function () {
        table = $('#courses_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('admin/courses/ajax_list') ?>",
                "type": "POST",
                "data": function (d) {
                    d.category_id = $('#category_filter').val();
                    d.status = $('#status_filter').val();
                }
            },
            "columnDefs": [
                {
                    "targets": [0, 1, -1], // Disable sorting on first (ID), second (Image), and last (Action) columns
                    "orderable": false,
                },
            ],
        });

        // Filter Event Listeners
        $('#category_filter, #status_filter').change(function () {
            table.draw();
        });

        // Custom Search Listener
        $('#custom_search').keyup(function () {
            table.search($(this).val()).draw();
        });
    });
</script>

/* Gradient Colors */
.bg-gradient-pink {
background: linear-gradient(45deg, #FF5370, #ff869a) !important;
}

.bg-gradient-cyan {
background: linear-gradient(45deg, #00BCD4, #4dd6e7) !important;
}

.bg-gradient-light-green {
background: linear-gradient(45deg, #8BC34A, #aed581) !important;
}

.col-white {
color: #fff !important;
}

.info-box-2 .icon i {
color: #fff !important;
}
</style>