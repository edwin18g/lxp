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
<div class="row clearfix">
    <!-- Learners Widget -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-2 hover-zoom-effect">
            <div class="icon bg-indigo">
                <i class="material-icons">people</i>
            </div>
            <div class="content">
                <div class="text">TOTAL LEARNERS</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_users; ?>" data-speed="1000"
                    data-fresh-interval="20"><?php echo $total_users; ?></div>
            </div>
        </div>
    </div>

    <!-- Courses Widget -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-2 hover-zoom-effect">
            <div class="icon bg-emerald">
                <i class="material-icons">school</i>
            </div>
            <div class="content">
                <div class="text">COURSES</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_courses; ?>" data-speed="1000"
                    data-fresh-interval="20"><?php echo $total_courses; ?></div>
            </div>
        </div>
    </div>

    <!-- Batches Widget -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-2 hover-zoom-effect">
            <div class="icon bg-cyan">
                <i class="material-icons">class</i>
            </div>
            <div class="content">
                <div class="text">ACTIVE BATCHES</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_batches; ?>" data-speed="1000"
                    data-fresh-interval="20"><?php echo $total_batches; ?></div>
            </div>
        </div>
    </div>

    <!-- Today's Events Widget -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-2 hover-zoom-effect">
            <div class="icon bg-orange">
                <i class="material-icons">event</i>
            </div>
            <div class="content">
                <div class="text">TODAY'S EVENTS</div>
                <div class="number count-to" data-from="0" data-to="<?php echo count($todays_b_e); ?>" data-speed="1000"
                    data-fresh-interval="20"><?php echo count($todays_b_e); ?></div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Widgets -->

<!-- User Growth Chart -->
<div class="row clearfix">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>USER GROWTH</h2>
            </div>
            <div class="body">
                <canvas id="user_growth_chart" height="150"></canvas>
            </div>
        </div>
    </div>
    <!-- Recent Users -->
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>RECENT LEARNERS</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?php echo site_url('admin/users'); ?>">View All</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <ul class="recent-users-list">
                    <?php if (!empty($recent_users)) {
                        foreach ($recent_users as $user) { ?>
                            <li>
                                <div class="user-info">
                                    <img src="<?php echo !empty($user->image) ? base_url('upload/users/images/' . $user->image) : base_url('themes/admin/img/user.png'); ?>"
                                        alt="User">
                                    <div class="user-details">
                                        <span class="name"><?php echo $user->first_name . ' ' . $user->last_name; ?></span>
                                        <span class="email"><?php echo $user->email; ?></span>
                                    </div>
                                </div>
                                <span class="date"><?php echo time_elapsed_string($user->date_added); ?></span>
                            </li>
                        <?php }
                    } else { ?>
                        <li class="text-center">No recent learners</li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

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

        // Gradient for chart
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

        var data = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "New Learners",
                data: <?php echo $user_growth_data; ?>,
                backgroundColor: gradient,
                borderColor: "#6366f1",
                borderWidth: 3,
                pointBackgroundColor: "#fff",
                pointBorderColor: "#6366f1",
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                lineTension: 0.4
            }]
        };

        var myChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: true,
                            color: "rgba(0, 0, 0, 0.03)",
                            zeroLineColor: "rgba(0, 0, 0, 0.05)"
                        },
                        ticks: {
                            beginAtZero: true,
                            padding: 10,
                            fontColor: "#94a3b8"
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            padding: 10,
                            fontColor: "#94a3b8"
                        }
                    }]
                },
                tooltips: {
                    backgroundColor: '#1e293b',
                    titleFontColor: '#fff',
                    bodyFontColor: '#fff',
                    cornerRadius: 8,
                    padding: 12,
                    displayColors: false
                }
            }
        });
    });
</script>

<style>
    .bg-indigo {
        background-color: #6366f1 !important;
        color: #fff !important;
    }

    .bg-emerald {
        background-color: #10b981 !important;
        color: #fff !important;
    }

    .bg-cyan {
        background-color: #06b6d4 !important;
        color: #fff !important;
    }

    .bg-orange {
        background-color: #f59e0b !important;
        color: #fff !important;
    }

    .info-box-2 {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
    }

    .info-box-2 .icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .info-box-2 .icon i {
        font-size: 24px;
        color: #fff;
    }

    .info-box-2 .content .text {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .info-box-2 .content .number {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
    }

    /* Recent Users List */
    .recent-users-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .recent-users-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .recent-users-list li:last-child {
        border-bottom: none;
    }

    .recent-users-list .user-info {
        display: flex;
        align-items: center;
    }

    .recent-users-list .user-info img {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        margin-right: 12px;
        object-fit: cover;
    }

    .recent-users-list .user-details {
        display: flex;
        flex-direction: column;
    }

    .recent-users-list .user-details .name {
        font-weight: 600;
        font-size: 14px;
        color: #1e293b;
    }

    .recent-users-list .user-details .email {
        font-size: 12px;
        color: #64748b;
    }

    .recent-users-list .date {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
    }
</style>