<?php defined('BASEPATH') OR exit('No direct script access allowed');


?>

<!-- Page Loader -->
<!-- ... -->

<!-- ChartJS -->
<script src="<?php echo base_url('themes/admin/plugins/chartjs/Chart.bundle.js'); ?>"></script>

<!-- Quick Actions -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>QUICK ACTIONS</h2>
            </div>
            <div class="body">
                <a href="<?php echo site_url('admin/users/form'); ?>" class="btn bg-pink waves-effect m-r-10">
                    <i class="material-icons">person_add</i> Add Learner
                </a>
                <a href="<?php echo site_url('admin/courses/form'); ?>" class="btn bg-light-green waves-effect m-r-10">
                    <i class="material-icons">library_add</i> Add Course
                </a>
                <a href="<?php echo site_url('admin/batches/form'); ?>" class="btn bg-cyan waves-effect m-r-10">
                    <i class="material-icons">add_to_queue</i> Add Batch
                </a>
                <a href="<?php echo site_url('admin/settings'); ?>" class="btn bg-orange waves-effect m-r-10">
                    <i class="material-icons">settings</i> Settings
                </a>
            </div>
        </div>
    </div>
</div>
<!-- #END# Quick Actions -->

<!-- Widgets -->
<!-- Widgets -->
<div class="row clearfix">
    <!-- Learners Widget -->
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box-2 hover-zoom-effect">
            <div class="icon bg-gradient-pink">
                <i class="material-icons col-white">face</i>
            </div>
            <div class="content">
                <div class="text">Learners</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_users; ?>" data-speed="1000"
                    data-fresh-interval="20"><?php echo $total_users; ?></div>
            </div>
        </div>
    </div>

    <!-- Batches Widget -->
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box-2 hover-zoom-effect">
            <div class="icon bg-gradient-cyan">
                <i class="material-icons col-white">devices_other</i>
            </div>
            <div class="content">
                <div class="text"><?php echo lang('menu_batches'); ?></div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_batches; ?>" data-speed="1000"
                    data-fresh-interval="20"><?php echo $total_batches; ?></div>
            </div>
        </div>
    </div>

    <!-- Courses Widget -->
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box-2 hover-zoom-effect">
            <div class="icon bg-gradient-light-green">
                <i class="material-icons col-white">import_contacts</i>
            </div>
            <div class="content">
                <div class="text"><?php echo lang('menu_courses'); ?></div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_courses; ?>" data-speed="1000"
                    data-fresh-interval="20"><?php echo $total_courses; ?></div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Widgets -->

<!-- User Growth Chart -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>USER GROWTH (Current Year)</h2>
            </div>
            <div class="body">
                <canvas id="user_growth_chart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- #END# User Growth Chart -->
<!-- #END# Widgets -->

<div class="row clearfix">
    <!-- Latest Batches -->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="header">
                <h2>LATEST BATCHES</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a
                                    href="<?php echo site_url('admin/batches'); ?>"><?php echo lang('action_view_all'); ?></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Fees</th>
                                <th>Start Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($top_batches)) {
                                foreach ($top_batches as $batch) { ?>
                                    <tr>
                                        <td><?php echo $batch->id ?></td>
                                        <td><?php echo $batch->title ?></td>
                                        <td><span class="label bg-green"><?php echo $batch->fees ?></span></td>
                                        <td><?php echo date('d M Y', strtotime($batch->start_date)); ?></td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="4" class="text-center">No Records Found</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Latest Batches -->

    <!-- Latest Events -->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="header">
                <h2>LATEST EVENTS</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a
                                    href="<?php echo site_url('admin/events'); ?>"><?php echo lang('action_view_all'); ?></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Start Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($top_events)) {
                                foreach ($top_events as $event) { ?>
                                    <tr>
                                        <td><?php echo $event->id ?></td>
                                        <td><?php echo $event->title ?></td>
                                        <td>
                                            <span class="label <?php echo ($event->status == 1) ? 'bg-green' : 'bg-red'; ?>">
                                                <?php echo ($event->status == 1) ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($event->start_date)); ?></td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="4" class="text-center">No Records Found</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Latest Events -->
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById("user_growth_chart").getContext("2d");
        var data = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "New Learners",
                data: <?php echo $user_growth_data; ?>,
                backgroundColor: "rgba(233, 30, 99, 0.2)",
                borderColor: "rgba(233, 30, 99, 1)",
                borderWidth: 1
            }]
        };

        var myChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
</script>

<style>
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