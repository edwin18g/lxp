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

                    <!-- Custom Search -->
                    <div class="col-md-4 col-sm-6" style="margin-bottom: 0;">
                        <div class="input-group" style="margin-bottom: 0;">
                            <span class="input-group-addon">
                                <i class="material-icons">search</i>
                            </span>
                            <div class="form-line">
                                <input type="text" id="custom_search" class="form-control"
                                    placeholder="Search courses..." style="padding-left: 10px;">
                            </div>
                        </div>
                    </div>

                    <!-- Add Button -->
                    <div class="col-md-2 col-sm-6" style="margin-bottom: 0; text-align: right;">
                        <?php if ($this->uri->segment(2) !== 'contacts') { ?>
                            <a href="<?php echo site_url() . 'admin/' . $this->uri->segment(2) . '/form'; ?>"
                                class="btn bg-<?php echo $this->settings->admin_theme ?> waves-effect btn-block"
                                style="padding: 10px 0; border-radius: 4px; font-weight: 600;">
                                <i class="material-icons" style="font-size: 18px; vertical-align: middle;">add</i>
                                <span style="vertical-align: middle;">ADD NEW</span>
                            </a>
                        <?php } ?>
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
            "dom": 'rtip', // Remove 'f' (search), 'l' (length), 'B' (export) from dom
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

<style>
    /* General Spacing */
    .row.clearfix {
        margin-bottom: 20px;
    }

    /* Filter Card */
    .card .header h2 {
        font-weight: 600;
        color: #555;
    }

    /* Table Styles */
    #courses_table {
        width: 100% !important;
        border-collapse: separate;
        border-spacing: 0 10px;
        /* Spacing between rows */
        margin-top: -10px;
    }

    #courses_table thead th {
        border-bottom: none;
        color: #777;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
        padding: 15px;
    }

    #courses_table tbody tr {
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        /* Subtle shadow for rows */
        transition: transform 0.2s, box-shadow 0.2s;
    }

    #courses_table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background-color: #fff !important;
        /* Override bootstrap striped */
    }

    #courses_table tbody td {
        border-top: none;
        vertical-align: middle;
        padding: 15px;
        color: #444;
        font-size: 14px;
    }

    #courses_table tbody td:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    #courses_table tbody td:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    /* Image Thumbnail */
    .img-thumbnail {
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border: none;
        padding: 0;
    }

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