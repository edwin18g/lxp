<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- ChartJS -->
<script src="<?php echo base_url('themes/admin/plugins/chartjs/Chart.bundle.js'); ?>"></script>

<style>
/* Modern Dashboard Premium Overhaul */
.dashboard-quick-actions {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
}

.dashboard-quick-actions .title {
    font-size: 0.85rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    color: #64748b;
    text-transform: uppercase;
    margin-bottom: 16px;
}

.quick-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    color: #ffffff !important;
    text-decoration: none !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    margin-right: 10px;
    margin-bottom: 8px;
}

.quick-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.btn-action-learner { background: linear-gradient(135deg, #ec4899 0%, #d946ef 100%); }
.btn-action-course { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
.btn-action-batch { background: linear-gradient(135deg, #06b6d4 0%, #0284c7 100%); }
.btn-action-settings { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }

/* Modern Stat Widgets */
.stat-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    transition: all 0.25s ease;
    margin-bottom: 24px;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
    border-color: #cbd5e1;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.stat-icon i { font-size: 26px; }

.stat-icon.indigo { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
.stat-icon.emerald { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
.stat-icon.cyan { background: linear-gradient(135deg, #06b6d4 0%, #0284c7 100%); }
.stat-icon.amber { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }

.stat-details .text {
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    color: #64748b;
    text-transform: uppercase;
}

.stat-details .number {
    font-size: 1.8rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.2;
}

/* Section Cards */
.dash-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    margin-bottom: 24px;
    overflow: hidden;
}

.dash-card .header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #ffffff;
}

.dash-card .header h2 {
    font-size: 0.95rem !important;
    font-weight: 800 !important;
    letter-spacing: 0.04em !important;
    color: #0f172a !important;
    margin: 0 !important;
    text-transform: uppercase;
}

.dash-card .body {
    padding: 24px;
}

/* Recent Learners List */
.recent-learners-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.recent-learners-list li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f8fafc;
}

.recent-learners-list li:last-child {
    border-bottom: none;
}

.recent-learners-list .user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.recent-learners-list .user-info img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2e8f0;
}

.recent-learners-list .user-details .name {
    display: block;
    font-weight: 700;
    font-size: 0.9rem;
    color: #1e293b;
}

.recent-learners-list .user-details .email {
    display: block;
    font-size: 0.78rem;
    color: #64748b;
}

.recent-learners-list .date {
    font-size: 0.75rem;
    font-weight: 600;
    color: #94a3b8;
    background: #f1f5f9;
    padding: 4px 10px;
    border-radius: 20px;
}

/* Dashboard Tables */
.dash-table {
    margin: 0;
}

.dash-table th {
    font-size: 0.75rem !important;
    font-weight: 800 !important;
    text-transform: uppercase !important;
    color: #64748b !important;
    background: #f8fafc !important;
    border-bottom: 1px solid #e2e8f0 !important;
    padding: 12px 16px !important;
}

.dash-table td {
    padding: 14px 16px !important;
    font-size: 0.88rem !important;
    color: #334155 !important;
    border-bottom: 1px solid #f1f5f9 !important;
}

.badge-pill {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
}

.badge-green { background: #dcfce7; color: #15803d; }
.badge-red { background: #fee2e2; color: #b91c1c; }
</style>

<!-- Welcome Banner -->
<div class="row clearfix">
    <div class="col-lg-12">
        <div style="background: linear-gradient(135deg, #f0f3ff 0%, #e8edff 100%); border-radius: 20px; padding: 32px 40px; margin-bottom: 28px; display: flex; align-items: center; justify-content: space-between; border: 1px solid #e0e7ff; position: relative; overflow: hidden;">
            <div style="z-index: 2;">
                <h2 style="font-size: 1.6rem; font-weight: 800; color: #1e1b4b; margin: 0 0 8px 0;">Welcome back, Admin! 👋</h2>
                <p style="color: #6366f1; font-weight: 500; font-size: 0.95rem; margin: 0;">Here's what's happening with your learning platform today.</p>
            </div>
            <div style="z-index: 2; display: flex; align-items: center; gap: 16px;">
                <div style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(8px); padding: 16px 24px; border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.9); display: flex; align-items: center; gap: 12px; box-shadow: 0 10px 25px rgba(99, 102, 241, 0.08);">
                    <i class="material-icons" style="color: #4f46e5; font-size: 32px;">trending_up</i>
                    <div>
                        <div style="font-size: 0.72rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Growth Rate</div>
                        <div style="font-size: 1.1rem; font-weight: 800; color: #0f172a;">+14.2% <span style="font-size: 0.75rem; color: #10b981; font-weight: 700;">↑</span></div>
                    </div>
                </div>
            </div>
            <!-- Decorative circle -->
            <div style="position: absolute; right: -40px; top: -40px; width: 220px; height: 220px; border-radius: 50%; background: rgba(99, 102, 241, 0.08); pointer-events: none;"></div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div style="margin-bottom: 28px;">
            <h3 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin: 0 0 16px 0;">Quick Actions</h3>
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="<?php echo site_url('admin/users/form'); ?>" style="display: flex; align-items: center; gap: 16px; padding: 20px; border-radius: 16px; background: linear-gradient(135deg, #ff2a6d 0%, #d91b5c 100%); color: #fff; text-decoration: none; box-shadow: 0 8px 20px rgba(255, 42, 109, 0.25); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                            <i class="material-icons" style="font-size: 24px; color: #fff;">person_add</i>
                        </div>
                        <div>
                            <div style="font-weight: 800; font-size: 0.95rem;">Add Learner</div>
                            <div style="font-size: 0.75rem; opacity: 0.85;">Enroll new learner</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="<?php echo site_url('admin/courses/form'); ?>" style="display: flex; align-items: center; gap: 16px; padding: 20px; border-radius: 16px; background: linear-gradient(135deg, #74b816 0%, #5c940e 100%); color: #fff; text-decoration: none; box-shadow: 0 8px 20px rgba(116, 184, 22, 0.25); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                            <i class="material-icons" style="font-size: 24px; color: #fff;">library_add</i>
                        </div>
                        <div>
                            <div style="font-weight: 800; font-size: 0.95rem;">Add Course</div>
                            <div style="font-size: 0.75rem; opacity: 0.85;">Create new course</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="<?php echo site_url('admin/batches/form'); ?>" style="display: flex; align-items: center; gap: 16px; padding: 20px; border-radius: 16px; background: linear-gradient(135deg, #00b4d8 0%, #0077b6 100%); color: #fff; text-decoration: none; box-shadow: 0 8px 20px rgba(0, 180, 216, 0.25); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                            <i class="material-icons" style="font-size: 24px; color: #fff;">groups</i>
                        </div>
                        <div>
                            <div style="font-weight: 800; font-size: 0.95rem;">Add Batch</div>
                            <div style="font-size: 0.75rem; opacity: 0.85;">Create new batch</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="<?php echo site_url('admin/settings'); ?>" style="display: flex; align-items: center; gap: 16px; padding: 20px; border-radius: 16px; background: linear-gradient(135deg, #ff922b 0%, #f59f00 100%); color: #fff; text-decoration: none; box-shadow: 0 8px 20px rgba(255, 146, 43, 0.25); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                            <i class="material-icons" style="font-size: 24px; color: #fff;">settings</i>
                        </div>
                        <div>
                            <div style="font-weight: 800; font-size: 0.95rem;">Settings</div>
                            <div style="font-size: 0.75rem; opacity: 0.85;">Manage platform</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Quick Actions -->

<!-- Widgets -->
<div class="row clearfix">
    <!-- Learners Widget -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="stat-card">
            <div class="stat-icon indigo">
                <i class="material-icons">people</i>
            </div>
            <div class="stat-details">
                <div class="text">Total Learners</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_users; ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total_users; ?></div>
            </div>
        </div>
    </div>

    <!-- Courses Widget -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="stat-card">
            <div class="stat-icon emerald">
                <i class="material-icons">school</i>
            </div>
            <div class="stat-details">
                <div class="text">Courses</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_courses; ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total_courses; ?></div>
            </div>
        </div>
    </div>

    <!-- Batches Widget -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="stat-card">
            <div class="stat-icon cyan">
                <i class="material-icons">class</i>
            </div>
            <div class="stat-details">
                <div class="text">Active Batches</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $total_batches; ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total_batches; ?></div>
            </div>
        </div>
    </div>

    <!-- Today's Events Widget -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="stat-card">
            <div class="stat-icon amber">
                <i class="material-icons">event</i>
            </div>
            <div class="stat-details">
                <div class="text">Today's Events</div>
                <div class="number count-to" data-from="0" data-to="<?php echo count($todays_b_e); ?>" data-speed="1000" data-fresh-interval="20"><?php echo count($todays_b_e); ?></div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Widgets -->

<!-- User Growth Chart & Recent Learners -->
<div class="row clearfix">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="dash-card">
            <div class="header">
                <h2>User Growth</h2>
            </div>
            <div class="body">
                <canvas id="user_growth_chart" height="150"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Recent Users -->
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="dash-card">
            <div class="header">
                <h2>Recent Learners</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons" style="color: #64748b;">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?php echo site_url('admin/users'); ?>">View All</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <ul class="recent-learners-list">
                    <?php if (!empty($recent_users)) {
                        foreach ($recent_users as $user) { ?>
                            <li>
                                <div class="user-info">
                                    <img src="<?php echo !empty($user->image) ? base_url('upload/users/images/' . $user->image) : base_url('themes/admin/img/avatar2.png'); ?>" alt="User" onerror="this.onerror=null;this.src='<?php echo base_url('themes/admin/img/avatar2.png'); ?>';">
                                    <div class="user-details">
                                        <span class="name"><?php echo $user->first_name . ' ' . $user->last_name; ?></span>
                                        <span class="email"><?php echo $user->email; ?></span>
                                    </div>
                                </div>
                                <span class="date"><?php echo time_elapsed_string($user->date_added); ?></span>
                            </li>
                        <?php }
                    } else { ?>
                        <li class="text-center" style="color: #94a3b8; padding: 20px;">No recent learners</li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <!-- Latest Batches -->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="dash-card">
            <div class="header">
                <h2>Latest Batches</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons" style="color: #64748b;">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?php echo site_url('admin/batches'); ?>"><?php echo lang('action_view_all'); ?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body table-responsive" style="padding: 0;">
                <table class="table table-hover dash-table">
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
                                    <td><strong><?php echo $batch->id ?></strong></td>
                                    <td style="font-weight: 600; color: #1e293b;"><?php echo $batch->title ?></td>
                                    <td><span class="badge-pill badge-green"><?php echo $batch->fees ?></span></td>
                                    <td style="color: #64748b;"><?php echo date('d M Y', strtotime($batch->start_date)); ?></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4" class="text-center" style="color: #94a3b8; padding: 20px;">No Records Found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- #END# Latest Batches -->

    <!-- Latest Events -->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="dash-card">
            <div class="header">
                <h2>Latest Events</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons" style="color: #64748b;">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?php echo site_url('admin/events'); ?>"><?php echo lang('action_view_all'); ?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body table-responsive" style="padding: 0;">
                <table class="table table-hover dash-table">
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
                                    <td><strong><?php echo $event->id ?></strong></td>
                                    <td style="font-weight: 600; color: #1e293b;"><?php echo $event->title ?></td>
                                    <td>
                                        <span class="badge-pill <?php echo ($event->status == 1) ? 'badge-green' : 'badge-red'; ?>">
                                            <?php echo ($event->status == 1) ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td style="color: #64748b;"><?php echo date('d M Y', strtotime($event->start_date)); ?></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4" class="text-center" style="color: #94a3b8; padding: 20px;">No Records Found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- #END# Latest Events -->
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById("user_growth_chart").getContext("2d");

        // Smooth Gradient for chart
        var gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.25)');
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

        var data = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "New Learners",
                data: <?php echo $user_growth_data; ?>,
                backgroundColor: gradient,
                borderColor: "#6366f1",
                borderWidth: 3,
                pointBackgroundColor: "#ffffff",
                pointBorderColor: "#6366f1",
                pointBorderWidth: 3,
                pointRadius: 5,
                pointHoverRadius: 7,
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
                            color: "rgba(226, 232, 240, 0.6)",
                            zeroLineColor: "rgba(226, 232, 240, 0.8)"
                        },
                        ticks: {
                            beginAtZero: true,
                            padding: 10,
                            fontColor: "#94a3b8",
                            fontSize: 12
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            padding: 10,
                            fontColor: "#94a3b8",
                            fontSize: 12
                        }
                    }]
                },
                tooltips: {
                    backgroundColor: '#0f172a',
                    titleFontColor: '#fff',
                    bodyFontColor: '#fff',
                    cornerRadius: 10,
                    padding: 12,
                    displayColors: false,
                    titleFontSize: 13,
                    bodyFontSize: 13
                }
            }
        });
    });
</script>


