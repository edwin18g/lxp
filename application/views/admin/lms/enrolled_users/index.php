<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Enrolled Users View */
?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="stats-bar-container animate-up">
            <div class="stats-bar-item premium-card bg-indigo-gradient shadow-vibrant" style="flex: 1;">
                <div class="item-icon-wrapper glass-icon">
                    <i class="material-icons">people</i>
                </div>
                <div class="item-content">
                    <span class="item-label text-indigo-lite">TOTAL ENROLLED</span>
                    <span class="item-number text-white" id="total_enrolled_count">
                        <?php echo $total_enrolled; ?>
                    </span>
                </div>
                <div class="card-bg-decoration"></div>
            </div>

            <div class="stats-bar-item premium-card bg-orange-gradient shadow-vibrant" style="flex: 1;">
                <div class="item-icon-wrapper glass-icon">
                    <i class="material-icons">lock_person</i>
                </div>
                <div class="item-content">
                    <span class="item-label text-orange-lite">LOCKED LEARNING</span>
                    <span class="item-number text-white" id="total_locked_learning_count">
                        <?php echo $total_locked_learning; ?>
                    </span>
                </div>
                <div class="card-bg-decoration"></div>
            </div>

            <!-- External Search Box -->
            <div class="stats-bar-item search-item premium-search-card" style="flex: 3; min-width: 300px;">
                <div class="global-search-wrapper" style="width: 100%; position: relative;">
                    <i class="material-icons search-icon-main">search</i>
                    <input type="text" class="global-dt-search premium-input"
                        placeholder="Search enrolled users (Press Enter or wait...)" data-table="enrolled_users_table">

                    <div id="search_inline_loader" class="search-inline-loader" style="display: none;">
                        <div class="spinner-sm"></div>
                    </div>

                    <button type="button" id="clear_enrolled_filters" class="btn-clear-all premium-clear-btn"
                        style="display: none;" title="Clear All Filters">
                        <i class="material-icons">filter_alt_off</i>
                        <span>Clear Filters</span>
                    </button>

                    <div id="search_results_status" class="search-results-status-v2"></div>
                </div>
            </div>

            <!-- Add Enrollment Action Card -->
            <button type="button" data-toggle="modal" data-target="#enrollmentModal"
                class="stats-bar-item action-item premium-card bg-indigo-gradient hover-scale shadow-vibrant text-decoration-none"
                style="flex: 0; min-width: 180px; border: none; cursor: pointer; text-align: left;">
                <div class="item-icon-wrapper glass-icon">
                    <i class="material-icons">person_add</i>
                </div>
                <div class="item-content">
                    <span class="item-label text-indigo-lite">ACTION</span>
                    <span class="item-number text-white">ADD ENROLLMENT</span>
                </div>
                <div class="card-bg-decoration"></div>
            </button>


        </div>
    </div>
</div>

<div class="row clearfix index-page">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card premium-table-card">
            <div class="body table-responsive">
                <table id="enrolled_users_table" class="table table-hover table-striped dataTable">
                    <thead>
                        <tr>
                            <?php
                            $col_idx = 0;
                            foreach ($t_headers as $val) {
                                echo '<th data-column-index="' . $col_idx . '">';
                                echo '<div class="header-content-wrapper">';
                                echo '<span class="header-label">' . $val . '</span>';
                                echo '</div>';
                                echo '</th>';
                                $col_idx++;
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


<!-- Offcanvas Sidebar -->
<div id="courseSidebar" class="right-sidebar-custom">
    <div class="sidebar-header-premium">
        <div class="header-main">
            <h3>Subscriber Dashboard</h3>
            <p>View user profile and course progression</p>
        </div>
        <button type="button" class="btn-close-sidebar" onclick="closeCourseSidebar()">
            <i class="material-icons">close</i>
        </button>
    </div>
    <div id="courseSidebarBody" class="offcanvas-body-premium">
        <!-- Content will be loaded here -->
    </div>
</div>

<!-- Overlay -->
<div id="sidebarOverlay" class="sidebar-overlay" onclick="closeCourseSidebar()"></div>

<!-- Sticky Bulk Action Bar -->
<div id="bulk_action_sticky_bar" class="bulk-sticky-bar">
    <div class="bulk-bar-content">
        <div class="selection-info">
            <div class="selection-count-badge">
                <span id="bulk_sticky_count">0</span>
            </div>
            <div class="selection-label">
                <strong>Users Selected</strong>
                <span>You can now perform bulk actions on selected subscribers.</span>
            </div>
        </div>

        <div class="bulk-actions-group">
            <button type="button" class="btn-bulk-action remove" onclick="processBulkAction('remove_enrollment')">
                <i class="material-icons">delete_sweep</i>
                <span>REMOVE ALL ENROLLMENTS</span>
            </button>
            <div class="bulk-divider"></div>
            <button type="button" class="btn-bulk-cancel" onclick="cancelBulkSelection()">
                <i class="material-icons">close</i>
                <span>CANCEL</span>
            </button>
        </div>
    </div>
</div>

<!-- Quick Enrollment Modal -->
<div class="modal fade premium-modal" id="enrollmentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-stepper">
                <div class="step active" id="step_indicator_1">
                    <div class="step-circle">1</div>
                    <span class="step-label">Select Course</span>
                </div>
                <div class="step-line"></div>
                <div class="step" id="step_indicator_2">
                    <div class="step-circle">2</div>
                    <span class="step-label">Select Users</span>
                </div>
                <div class="step-line"></div>
                <div class="step" id="step_indicator_3">
                    <div class="step-circle">3</div>
                    <span class="step-label">Confirm</span>
                </div>
            </div>

            <div class="modal-body p-0">
                <!-- STEP 1: SELECT COURSE -->
                <div id="enroll_step_1" class="p-30">
                    <div class="section-title">Step 1: Choose Course</div>
                    <div class="form-group mb-30">
                        <label class="form-label" for="enroll_course_id">Select a course to enroll users into</label>
                        <select id="enroll_course_id" class="form-control selectpicker" data-live-search="true"
                            data-size="5" title="Search and select course...">
                        </select>
                    </div>
                    <div class="text-right mt-20">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btn_next_to_users" class="btn btn-primary" disabled>
                            Next: Select Users <i class="material-icons">arrow_forward</i>
                        </button>
                    </div>
                </div>

                <!-- STEP 2: SELECT USERS -->
                <div id="enroll_step_2" class="p-30" style="display:none;">
                    <div class="section-title">Step 2: Choose Users</div>
                    <div class="form-group mb-30">
                        <label class="form-label" for="enroll_user_ids">Select users to enroll (Multi-select)</label>
                        <select id="enroll_user_ids" class="form-control selectpicker" multiple data-live-search="true"
                            data-actions-box="true" data-size="8" title="Search and select users...">
                        </select>
                        <small class="text-muted mt-5 d-block">Only users not already enrolled in this course will be
                            shown.</small>
                    </div>
                    <div class="text-right mt-20">
                        <button type="button" id="btn_back_to_course" class="btn btn-default">Back</button>
                        <button type="button" id="btn_next_to_confirm" class="btn btn-primary" disabled>
                            Next: Confirm <i class="material-icons">arrow_forward</i>
                        </button>
                    </div>
                </div>

                <!-- STEP 3: CONFIRMATION -->
                <div id="enroll_step_3" class="p-30" style="display:none;">
                    <div class="section-title">Step 3: Final Confirmation</div>
                    <div class="confirmation-summary bg-indigo-soft p-20 border-radius-15 mb-20">
                        <div class="d-flex align-items-center gap-15 mb-15">
                            <i class="material-icons color-indigo">school</i>
                            <div>
                                <small class="text-muted uppercase weight-800 fs-10 block">Selected Course</small>
                                <div id="summary_course_name" class="weight-800 color-indigo"></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-15">
                            <i class="material-icons color-indigo">people</i>
                            <div>
                                <small class="text-muted uppercase weight-800 fs-10 block">Target Users</small>
                                <div id="summary_user_count" class="weight-800 color-indigo"></div>
                            </div>
                        </div>
                    </div>
                    <div id="summary_user_list" class="mt-15 d-flex flex-wrap gap-5"></div>
                    <div class="alert alert-info border-radius-15 fs-13">
                        <i class="material-icons">info</i>
                        <span>Enrolling users will grant them immediate access to the course content.</span>
                    </div>
                    <div class="text-right mt-20">
                        <button type="button" id="btn_back_to_users" class="btn btn-default">Back</button>
                        <button type="button" id="btn_confirm_enrollment" class="btn btn-primary">
                            Complete Enrollment <i class="material-icons">check_circle</i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Loader -->
            <div id="enroll_loading" class="enroll-loader" style="display:none;">
                <div class="preloader pl-size-l">
                    <div class="spinner-layer pl-indigo">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <span>Syncing data...</span>
            </div>
        </div>
    </div>
</div>

<style>
    .img-circle {
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Premium Stats Cards */
    .bg-orange-gradient {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .bg-emerald-gradient {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .text-indigo-lite {
        color: rgba(199, 210, 254, 0.9);
    }

    .text-orange-lite {
        color: rgba(254, 215, 170, 0.9);
    }

    .text-emerald-lite {
        color: rgba(167, 243, 208, 0.9);
    }

    .bg-red-soft {
        background: rgba(239, 68, 68, 0.08);
    }

    .color-danger {
        color: #ef4444;
    }

    .bg-indigo-soft {
        background: rgba(99, 102, 241, 0.08);
    }

    .color-indigo {
        color: #6366f1;
    }

    .bg-emerald-soft {
        background: rgba(16, 185, 129, 0.08);
    }

    .color-emerald {
        color: #10b981;
    }

    .stats-bar-container {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .premium-card {
        position: relative;
        padding: 8px 15px !important;
        border-radius: 12px !important;
        overflow: hidden;
        border: none !important;
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
    }

    .glass-icon {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: #fff;
    }

    .glass-icon i {
        font-size: 18px;
    }

    .item-label {
        font-size: 9px !important;
        font-weight: 800 !important;
        letter-spacing: 0.05em !important;
        margin-bottom: 0px !important;
        display: block !important;
        line-height: 1 !important;
    }

    .item-number {
        font-size: 11px !important;
        font-weight: 800 !important;
        line-height: 1 !important;
        display: block !important;
    }

    .search-item {
        padding: 8px 15px !important;
    }

    .premium-search-card .premium-input {
        padding-left: 40px !important;
        height: 32px !important;
        font-size: 13px !important;
    }

    .action-item {
        padding: 6px 15px !important;
        min-width: 160px !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
    }

    .action-item .item-icon-wrapper {
        margin-bottom: 0 !important;
    }

    .card-bg-decoration {
        position: absolute;
        bottom: -15px;
        right: -15px;
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Modern Table Styling */
    .premium-table-card {
        border-radius: 24px !important;
        border: 1px solid #f1f5f9 !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
        overflow: hidden;
    }

    #enrolled_users_table thead th {
        padding: 0px 20px !important;
        background: #f8fafc !important;
        color: #475569 !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        font-size: 11px !important;
        letter-spacing: 0.05em !important;
        border-bottom: 2px solid #e2e8f0 !important;
        height: 32px !important;
        vertical-align: middle !important;
    }

    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc:after {
        bottom: 0.5em !important;
    }

    #enrolled_users_table tbody td {
        padding: 4px 20px !important;
        vertical-align: middle !important;
        color: #1e293b !important;
        font-size: 13px !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .btn-circle-sm {
        width: 30px;
        height: 30px;
        padding: 0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 30px;
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #64748b;
        transition: all 0.2s;
    }

    .btn-circle-sm:hover {
        background: #f1f5f9;
        color: #6366f1;
        border-color: #6366f1;
    }

    #enrolled_users_table_wrapper .dataTables_info {
        padding: 20px !important;
        color: #64748b !important;
        font-size: 12px !important;
    }

    /* Premium Search Bar */
    .premium-search-card {
        background: #fff !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    }

    .premium-input {
        background: transparent !important;
        border: none !important;
        font-size: 14px !important;
        padding-left: 50px !important;
        color: #1e293b !important;
        font-weight: 500 !important;
    }

    .search-icon-main {
        position: absolute;
        left: 20px;
        color: #94a3b8;
    }

    .search-results-status-v2 {
        position: absolute;
        bottom: -25px;
        left: 0;
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }

    .search-results-status-v2 strong {
        color: #6366f1;
    }

    /* Offcanvas Redesign */
    .right-sidebar-custom {
        width: 85%;
        position: fixed;
        top: 0;
        right: -85%;
        height: 100vh;
        background: #f8fafc;
        padding: 0;
        display: flex;
        flex-direction: column;
        z-index: 1100;
        box-shadow: -15px 0 50px rgba(0, 0, 0, 0.1);
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        overflow-y: auto;
    }

    .right-sidebar-custom.open {
        right: 0;
    }

    .premium-clear-btn {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: #f1f5f9;
        border: none;
        padding: 4px 10px;
        border-radius: 8px;
        color: #475569;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        z-index: 20;
    }

    .premium-clear-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(4px);
        z-index: 1040;
        display: none;
        transition: all 0.3s ease;
    }

    .sidebar-overlay.show {
        display: block;
    }

    .sidebar-header-premium {
        padding: 30px 40px;
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .sidebar-header-premium h3 {
        margin: 0;
        font-weight: 800;
        color: #0f172a;
        font-size: 22px;
    }

    .sidebar-header-premium p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .btn-close-sidebar {
        background: #f1f5f9;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-close-sidebar:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Offcanvas User Profile Card */
    .offcanvas-user-profile {
        background: #6366f1;
        padding: 40px;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 30px 40px 0;
        border-radius: 24px;
        box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.4);
    }

    .profile-main {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        border: 3px solid rgba(255, 255, 255, 0.2);
    }

    .profile-avatar-initial {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 800;
        background: rgba(255, 255, 255, 0.9);
    }

    .profile-details h3 {
        margin: 0;
        font-weight: 800;
        font-size: 20px;
    }

    .profile-details p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .profile-stats {
        display: flex;
        gap: 20px;
    }

    .stat-pill {
        background: rgba(255, 255, 255, 0.1);
        padding: 12px 20px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(4px);
        text-align: center;
    }

    .stat-pill .label {
        display: block;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 2px;
        opacity: 0.8;
    }

    .stat-pill .value {
        font-weight: 800;
        font-size: 18px;
    }

    .stat-pill .value.active {
        color: #86efac;
    }

    /* Course Grid in Offcanvas */
    .course-grid-modern {
        display: grid;
        grid-template_columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        padding-top: 20px;
    }

    .course-card-premium {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }

    .course-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        border-color: #e2e8f0;
    }

    .course-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.9);
        color: #475569;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        z-index: 2;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .course-image-wrapper {
        height: 160px;
        overflow: hidden;
    }

    .course-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .course-body {
        padding: 20px;
    }

    .course-body h5 {
        margin: 0;
        font-weight: 800;
        color: #1e293b;
        font-size: 16px;
        line-height: 1.4;
        height: 44px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .course-meta {
        margin-top: 15px;
        display: flex;
        gap: 15px;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    .course-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .course-meta i {
        font-size: 16px;
    }

    .course-actions {
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-card-action {
        color: #6366f1;
        font-weight: 800;
        font-size: 12px;
        text-decoration: none !important;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: gap 0.2s;
    }

    .btn-card-action:hover {
        gap: 12px;
    }

    .section-title {
        font-weight: 800;
        color: #0f172a;
        font-size: 18px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: #6366f1;
        border-radius: 4px;
    }

    .p-30 {
        padding: 40px;
    }

    /* Empty States Styling */
    .empty-state-sidebar {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 20px;
        border: 2px dashed #e2e8f0;
    }

    .empty-state-sidebar i {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 15px;
    }

    .empty-state-sidebar p {
        color: #64748b;
        font-weight: 600;
    }

    /* Animations */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-up {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    /* Modal Stepper Styles */
    .modal-stepper {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 30px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        gap: 15px;
    }

    .modal-stepper .step {
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0.4;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modal-stepper .step.active {
        opacity: 1;
        transform: scale(1.05);
    }

    .modal-stepper .step.completed {
        opacity: 0.8;
    }

    .modal-stepper .step.completed .step-circle {
        background: #10b981;
        color: #fff;
    }

    .modal-stepper .step-circle {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 11px;
        transition: all 0.3s ease;
    }

    .modal-stepper .step.active .step-circle {
        background: #6366f1;
        color: #fff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
    }

    /* Google Sheets Style Filtering CSS */
    .header-content-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 6px;
        position: relative;
        height: 100%;
        min-height: 24px;
    }

    .header-label {
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .header-filter-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        z-index: 10;
    }

    .btn-filter-toggle {
        background: transparent;
        border: none;
        padding: 4px;
        color: #94a3b8;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        transition: all 0.2s;
        opacity: 0;
        line-height: 1;
        position: relative;
        z-index: 11;
    }

    th:hover .btn-filter-toggle,
    .btn-filter-toggle.active {
        opacity: 1;
        color: #6366f1;
    }

    .btn-filter-toggle:hover {
        background: rgba(99, 102, 241, 0.1);
    }

    .btn-filter-toggle .material-icons {
        font-size: 14px;
    }

    .filter-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        width: 240px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        border: 1px solid #f1f5f9;
        z-index: 1000;
        padding: 12px;
        margin-top: 8px;
        display: none;
        /* Controlled by JS */
        text-align: left;
    }

    .filter-dropdown.show {
        display: block;
        animation: fadeUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .filter-sort-options {
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 12px;
    }

    .btn-sort {
        background: transparent;
        border: none;
        padding: 8px 12px;
        text-align: left;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-sort:hover {
        background: #f8fafc;
        color: #6366f1;
    }

    .btn-sort .material-icons {
        font-size: 18px;
    }

    .filter-search-section label {
        display: block;
        font-size: 11px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
    }

    .filter-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .filter-input-google {
        flex: 1;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 13px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s;
    }

    .filter-input-google:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.1);
    }

    .btn-apply-filter {
        background: #6366f1;
        border: none;
        color: #fff;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-apply-filter:hover {
        background: #4f46e5;
    }

    .btn-apply-filter i {
        font-size: 18px;
    }

    .btn-clear {
        background: transparent;
        border: none;
        padding: 4px 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.2s;
        width: 100%;
        text-align: center;
    }

    .btn-clear:hover {
        background: #f1f5f9;
    }

    .modal-stepper .step-label {
        font-weight: 800;
        font-size: 11px;
        color: #1e293b;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .modal-stepper .step-line {
        flex: 0;
        width: 40px;
        height: 2px;
        background: #e2e8f0;
        border-radius: 2px;
    }

    .enroll-summary-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 25px;
        border: 1px dashed #cbd5e1;
    }

    .summary-item label {
        display: block;
        font-size: 11px;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 5px;
        font-weight: 800;
    }

    .summary-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 15px 0;
    }

    .summary-chip-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .user-chip {
        background: #fff;
        border: 1px solid #e2e8f0;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        color: #475569;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    #enrollmentModal .btn-primary {
        background-color: #6366f1 !important;
        border-radius: 12px;
        padding: 10px 25px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    }

    #enrollmentModal .btn-link {
        color: #64748b;
        font-weight: 700;
        text-decoration: none;
    }

    #enrollmentModal .form-control {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 10px 15px;
        height: auto;
    }

    /* Bootstrap Select Overrides for Premium Look */
    #enrollmentModal .bootstrap-select.btn-group .dropdown-toggle .filter-option {
        padding-left: 0;
        font-weight: 600;
        color: #1e293b;
    }

    #enrollmentModal .bootstrap-select .btn {
        background-color: #fff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        padding: 12px 15px !important;
        box-shadow: none !important;
        outline: none !important;
    }

    #enrollmentModal .bootstrap-select .dropdown-menu {
        border-radius: 16px !important;
        border: 1px solid #f1f5f9 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        padding: 10px !important;
        margin-top: 5px !important;
    }

    #enrollmentModal .bootstrap-select .dropdown-menu li a {
        border-radius: 8px !important;
        margin: 2px 0 !important;
        padding: 8px 15px !important;
        font-weight: 600 !important;
        color: #475569 !important;
    }

    #enrollmentModal .bootstrap-select .dropdown-menu li.selected a {
        background-color: #f1f5f9 !important;
        color: #6366f1 !important;
    }

    #enrollmentModal .bootstrap-select .dropdown-menu li a:hover {
        background-color: #f8fafc !important;
    }

    #enrollmentModal .bootstrap-select .bs-searchbox .form-control {
        border-radius: 8px !important;
        padding: 8px 12px !important;
        margin-bottom: 10px !important;
    }

    #enrollmentModal .bootstrap-select .bs-actionsbox {
        padding: 10px 5px !important;
        border-bottom: 1px solid #f1f5f9 !important;
        margin-bottom: 5px !important;
    }

    #enrollmentModal .bootstrap-select .bs-actionsbox .btn-group button {
        background: #f1f5f9 !important;
        border: none !important;
        color: #475569 !important;
        font-weight: 700 !important;
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        border-radius: 6px !important;
        padding: 5px 10px !important;
    }

    #enrolled_users_table_wrapper.is-processing .dataTables_processing {
        display: block !important;
        position: absolute;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%);
        z-index: 1000;
        background: rgba(255, 255, 255, 0.95);
        padding: 2.5rem 4rem;
        border-radius: 24px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border: 1px solid #f1f5f9;
        font-weight: 700;
        color: #6366f1;
        backdrop-filter: blur(4px);
        width: auto;
        height: auto;
        margin: 0;
        text-align: center;
        min-width: 250px;
    }

    /* Hide by default or when not processing */
    #enrolled_users_table_wrapper:not(.is-processing) .dataTables_processing {
        display: none !important;
    }

    .dt-loader-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .dt-spinner {
        width: 32px;
        height: 32px;
        border: 3px solid rgba(99, 102, 241, 0.1);
        border-top: 3px solid #6366f1;
        border-radius: 50%;
        animation: dt-spin 0.8s linear infinite;
    }

    @keyframes dt-spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Inline Search Loader */
    .search-inline-loader {
        position: absolute;
        right: 50px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 5;
    }

    .spinner-sm {
        width: 18px;
        height: 18px;
        border: 2px solid rgba(99, 102, 241, 0.1);
        border-top: 2px solid #6366f1;
        border-radius: 50%;
        animation: dt-spin 0.6s linear infinite;
    }

    .search-results-status {
        position: absolute;
        bottom: -22px;
        left: 45px;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        pointer-events: none;
        transition: all 0.2s ease;
    }

    .search-results-status strong {
        color: #6366f1;
    }

    /* Sticky Bulk Bar Styles */
    .bulk-sticky-bar {
        position: fixed;
        bottom: -100px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        max-width: 900px;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 16px 24px;
        z-index: 1000;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.05);
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .bulk-sticky-bar.show {
        bottom: 30px;
    }

    .bulk-bar-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .selection-info {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .selection-count-badge {
        background: #6366f1;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        box-shadow: 0 8px 16px rgba(99, 102, 241, 0.3);
    }

    .selection-label {
        display: flex;
        flex-direction: column;
    }

    .selection-label strong {
        color: white;
        font-size: 15px;
        letter-spacing: 0.01em;
    }

    .selection-label span {
        color: rgba(255, 255, 255, 0.5);
        font-size: 12px;
    }

    .bulk-actions-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-bulk-action {
        background: rgba(225, 29, 72, 0.15);
        border: 1px solid rgba(225, 29, 72, 0.3);
        color: #fb7185;
        padding: 10px 20px;
        border-radius: 14px;
        font-weight: 600;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-bulk-action:hover {
        background: #e11d48;
        color: white;
        border-color: #e11d48;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(225, 29, 72, 0.2);
    }

    .btn-bulk-cancel {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.7);
        padding: 10px 16px;
        border-radius: 14px;
        font-weight: 600;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-bulk-cancel:hover {
        background: rgba(255, 255, 255, 0.05);
        color: white;
        border-color: rgba(255, 255, 255, 0.2);
    }

    .bulk-divider {
        width: 1px;
        height: 24px;
        background: rgba(255, 255, 255, 0.1);
        margin: 0 4px;
    }
</style>

<script>
    var table;
    $(document).ready(function () {
        table = $('#enrolled_users_table').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "ajax": {
                "url": "<?php echo site_url('admin/enrolled_users/ajax_list') ?>",
                "type": "POST",
                "data": function (d) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
                }
            },
            "language": {
                "processing": `
                    <div class="dt-loader-wrapper">
                        <div class="dt-spinner"></div>
                        <div style="font-size: 14px; letter-spacing: 0.02em;">SEARCHING DATA...</div>
                    </div>
                `
            },
            "columnDefs": [
                { "orderable": false, "targets": [0, 1, 2, 8, 9, 10] }
            ],
            "initComplete": function () {
                var api = this.api();

                // Add filter icons to headers
                $('#enrolled_users_table thead th').each(function (i) {
                    var title = $(this).text();
                    var searchable_cols = [3, 4, 5, 6, 7];

                    if (searchable_cols.includes(i)) {
                        var filterHtml = `
                                <div class="header-filter-wrapper">
                                    <button type="button" class="btn-filter-toggle">
                                        <i class="material-icons">filter_alt</i>
                                    </button>
                                    <div class="filter-dropdown">
                                        <div class="filter-dropdown-content">
                                            <div class="filter-sort-options">
                                                <button type="button" class="btn-sort-action" data-dir="asc">
                                                    <i class="material-icons">sort_by_alpha</i>
                                                    <span>Sort A → Z</span>
                                                </button>
                                                <button type="button" class="btn-sort-action" data-dir="desc">
                                                    <i class="material-icons">sort_by_alpha</i>
                                                    <span>Sort Z → A</span>
                                                </button>
                                            </div>
                                            <div class="filter-divider"></div>
                                            <h6>Filter by ${title}</h6>
                                            ${i === 7 ? `
                                                <select class="form-control filter-select-google">
                                                    <option value="">All Status</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            ` : `
                                                <input type="text" class="form-control filter-input-google" placeholder="Search ${title}...">
                                            `}
                                            <div class="filter-dropdown-actions">
                                                <button type="button" class="btn btn-link btn-xs btn-clear">Clear</button>
                                                <button type="button" class="btn btn-primary btn-xs btn-apply">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        $(this).find('.header-content-wrapper').append(filterHtml);
                    }
                });

                // Toggle dropdown - use direct listener to beat DataTables sorting breadcrumb
                $('.btn-filter-toggle', api.table().header()).on('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var wrapper = $(this).closest('.header-filter-wrapper');
                    $('.header-filter-wrapper').not(wrapper).find('.filter-dropdown').removeClass('show');
                    wrapper.find('.filter-dropdown').toggleClass('show');
                });

                // Close dropdown on outside click
                $(document).on('click', function (e) {
                    if (!$(e.target).closest('.header-filter-wrapper').length) {
                        $('.filter-dropdown').removeClass('show');
                    }
                });

                // Sort action
                $(document).on('click', '.btn-sort-action', function (e) {
                    e.stopPropagation();
                    var dir = $(this).data('dir');
                    var colIdx = $(this).closest('th').index();
                    api.order([colIdx, dir]).draw();
                    $('.filter-dropdown').removeClass('show');
                });

                // Apply filter
                function applyFilter(wrapper) {
                    var colIdx = wrapper.closest('th').index();
                    var value = wrapper.find('.filter-input-google, .filter-select-google').val();

                    if (api.column(colIdx).search() !== value) {
                        api.column(colIdx).search(value).draw();
                    }
                    wrapper.find('.filter-dropdown').removeClass('show');

                    if (value) {
                        wrapper.find('.btn-filter-toggle').addClass('active');
                    } else {
                        wrapper.find('.btn-filter-toggle').removeClass('active');
                    }
                    updateClearAllVisibility();
                }

                $(document).on('click', '.btn-apply', function (e) {
                    e.stopPropagation();
                    applyFilter($(this).closest('.header-filter-wrapper'));
                });

                // Bulk Selection Logic
                $(document).on('change', '#chk_all', function () {
                    $('.user-chk').prop('checked', this.checked);
                    updateBulkActionVisibility();
                });

                $(document).on('change', '.user-chk', function () {
                    if ($('.user-chk:checked').length == $('.user-chk').length) {
                        $('#chk_all').prop('checked', true);
                    } else {
                        $('#chk_all').prop('checked', false);
                    }
                    updateBulkActionVisibility();
                });

                function updateBulkActionVisibility() {
                    var count = $('.user-chk:checked').length;
                    if (count > 0) {
                        $('#bulk_sticky_count').text(count);
                        $('#bulk_action_sticky_bar').addClass('show');
                    } else {
                        $('#bulk_action_sticky_bar').removeClass('show');
                    }
                }

                window.cancelBulkSelection = function () {
                    $('.user-chk, #chk_all').prop('checked', false);
                    updateBulkActionVisibility();
                };

                // Enter key to apply
                $(document).on('keypress', '.filter-input-google', function (e) {
                    if (e.which == 13) {
                        applyFilter($(this).closest('.header-filter-wrapper'));
                    }
                });

                // Clear filter
                $(document).on('click', '.btn-clear', function (e) {
                    e.stopPropagation();
                    var wrapper = $(this).closest('.header-filter-wrapper');
                    var colIdx = wrapper.closest('th').index();
                    wrapper.find('.filter-input-google, .filter-select-google').val('');

                    if (api.column(colIdx).search() !== '') {
                        api.column(colIdx).search('').draw();
                    }
                    wrapper.find('.filter-dropdown').removeClass('show');
                    wrapper.find('.btn-filter-toggle').removeClass('active');
                    updateClearAllVisibility();
                });

                // Prevent click propagation from dropdown
                $(document).on('click', '.filter-dropdown', function (e) {
                    e.stopPropagation();
                });

                // Close dropdown on outside click
                $(document).on('click', function () {
                    $('.filter-dropdown').removeClass('show');
                });

                // Clear All Filters
                function updateClearAllVisibility() {
                    var hasActiveFilter = $('.btn-filter-toggle.active').length > 0;
                    if (hasActiveFilter) {
                        $('#clear_enrolled_filters').fadeIn();
                    } else {
                        $('#clear_enrolled_filters').fadeOut();
                    }
                }

                // Clear All Filters Functionality
                function updateClearAllVisibility() {
                    var hasActiveFilter = $('.btn-filter-toggle.active').length > 0;
                    if (hasActiveFilter) {
                        $('#clear_enrolled_filters').fadeIn();
                    } else {
                        $('#clear_enrolled_filters').fadeOut();
                    }
                }

                $('#clear_enrolled_filters').on('click', function () {
                    $('.filter-input-google, .filter-select-google').val('');
                    $('.btn-filter-toggle').removeClass('active');
                    api.columns().search('').order([]).draw(); // Clear search and order
                    $(this).fadeOut();
                });

                // Google Sheets Style Filter Logic
                $(document).on('click', '.btn-filter-toggle', function (e) {
                    e.stopPropagation();
                    $('.filter-dropdown').not($(this).next('.filter-dropdown')).removeClass('show');
                    $(this).next('.filter-dropdown').toggleClass('show');
                });

                // Apply filter on button click or Enter key
                function applyFilter(wrapper) {
                    var input = wrapper.find('.filter-input-google');
                    var val = input.val();
                    var colIdx = wrapper.closest('th').data('column-index');

                    if (val) {
                        wrapper.find('.btn-filter-toggle').addClass('active');
                    } else {
                        wrapper.find('.btn-filter-toggle').removeClass('active');
                    }

                    api.column(colIdx).search(val).draw();
                    wrapper.find('.filter-dropdown').removeClass('show');
                    updateClearAllVisibility();
                }

                $(document).on('click', '.btn-apply-filter', function (e) {
                    e.stopPropagation();
                    applyFilter($(this).closest('.header-filter-wrapper'));
                });

                $(document).on('keypress', '.filter-input-google', function (e) {
                    if (e.which == 13) {
                        e.stopPropagation();
                        applyFilter($(this).closest('.header-filter-wrapper'));
                    }
                });

                // Handle Sorting from Dropdown
                $(document).on('click', '.btn-sort', function (e) {
                    e.stopPropagation();
                    var order = $(this).data('order');
                    var colIdx = $(this).closest('th').data('column-index');

                    api.order([colIdx, order]).draw();
                    $(this).closest('.filter-dropdown').removeClass('show');
                });

                // Clear single column filter
                $(document).on('click', '.btn-clear', function (e) {
                    e.stopPropagation();
                    var wrapper = $(this).closest('.header-filter-wrapper');
                    var colIdx = wrapper.closest('th').data('column-index');

                    wrapper.find('.filter-input-google').val('');
                    wrapper.find('.btn-filter-toggle').removeClass('active');
                    api.column(colIdx).search('').draw();
                    wrapper.find('.filter-dropdown').removeClass('show');
                    updateClearAllVisibility();
                });

                // Close dropdown on outside click
                $(document).on('click', function (e) {
                    if (!$(e.target).closest('.filter-dropdown').length && !$(e.target).closest('.btn-filter-toggle').length) {
                        $('.filter-dropdown').removeClass('show');
                    }
                });

                // Prevent click propagation from inside dropdown
                $(document).on('click', '.filter-dropdown', function (e) {
                    e.stopPropagation();
                });
            },
            "drawCallback": function (settings) {
                var api = this.api();
                var rowCount = api.rows({ page: 'current' }).count();
                var tableBody = $('#enrolled_users_table tbody');
                var query = api.search();
                var statusElem = $('#search_results_status');
                var loaderElem = $('#search_inline_loader');

                // Hide loader
                loaderElem.fadeOut(300);

                if (query) {
                    var totalRecords = settings._iRecordsDisplay;
                    statusElem.html(`Analysis complete. Found <strong>${totalRecords}</strong> matches for <strong>"${query}"</strong>`);
                } else {
                    statusElem.empty();
                }

                if (rowCount === 0) {
                    var colCount = api.columns().count();
                    tableBody.html(`
                            <tr>
                                <td colspan="${colCount}" class="p-0">
                                    <div class="empty-state-sidebar animate-up" style="margin: 40px; border: none; background: transparent;">
                                        <i class="material-icons" style="font-size: 64px; color: #e2e8f0;">search_off</i>
                                        <h4 style="font-weight: 800; color: #1e293b; margin-top: 20px;">No exact matches found</h4>
                                        <p style="color: #64748b;">We couldn't find any results for "${query}".<br>Try refining your search or clearing filters.</p>
                                    </div>
                                </td>
                            </tr>
                        `);
                }
            }
        });

        // Toggle 'is-processing' class based on DataTable processing state
        table.on('processing.dt', function (e, settings, processing) {
            if (processing) {
                $('#enrolled_users_table_wrapper').addClass('is-processing');
            } else {
                $('#enrolled_users_table_wrapper').removeClass('is-processing');
            }
        });

        // Search Box Binding for Enrolled Users with Debounce and Enter key support
        let searchTimer;
        $(document).on('keyup', '.global-dt-search[data-table="enrolled_users_table"]', function (e) {
            var val = $(this).val();
            var tableInstance = table;
            var statusElem = $('#search_results_status');
            var loaderElem = $('#search_inline_loader');

            if (val.length > 0) {
                loaderElem.fadeIn(200);
            }

            if (e.keyCode === 13) {
                // Trigger immediately on Enter
                clearTimeout(searchTimer);
                statusElem.html(`Initiating search for <strong>"${val}"</strong>...`);
                tableInstance.search(val).draw();
            } else {
                // Debounce other key presses
                statusElem.html('<span class="animate-pulse">Analyzing input...</span>');
                clearTimeout(searchTimer);
                searchTimer = setTimeout(function () {
                    if (val.length > 0) {
                        statusElem.html(`Searching database for <strong>"${val}"</strong>...`);
                    } else {
                        statusElem.empty();
                    }
                    tableInstance.search(val).draw();
                }, 500); // 500ms delay
            }
        });

        // Trigger search on 'change' (e.g., when clearing the field)
        $(document).on('change', '.global-dt-search[data-table="enrolled_users_table"]', function () {
            if ($(this).val() === "") {
                clearTimeout(searchTimer);
                $('#search_results_status').empty();
                $('#search_inline_loader').fadeOut(200);
                table.search("").draw();
            }
        });

        // Bulk Action Function
        window.processBulkAction = function (action) {
            var userIds = [];
            $('.user-chk:checked').each(function () {
                userIds.push($(this).val());
            });

            if (userIds.length == 0) return;

            if (action === 'remove_enrollment') {
                swal({
                    title: "Bulk Remove Enrollments?",
                    text: "This will remove ALL course enrollments for the " + userIds.length + " selected users!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#f44336",
                    cancelButtonColor: "#94a3b8",
                    confirmButtonText: "Yes, Remove ALL!",
                    closeOnConfirm: false
                }, function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: "<?php echo site_url("admin/lms/enrolled_users/bulk_remove_enrollment_ajax"); ?>",
                            type: "POST",
                            data: {
                                user_ids: userIds,
                                "<?php echo $this->security->get_csrf_token_name(); ?>": "<?php echo $this->security->get_csrf_hash(); ?>"
                            },
                            dataType: "JSON",
                            success: function (data) {
                                if (data.flag == 1) {
                                    swal("Success", data.msg, "success");
                                    // Update total enrolled count
                                    $("#total_enrolled_count").text(data.total_enrolled);
                                    // Reset checkboxes
                                    cancelBulkSelection();
                                    // Reload table
                                    if (typeof table !== "undefined") table.ajax.reload(null, false);
                                } else {
                                    swal("Error", data.msg, "error");
                                }
                            },
                            error: function () {
                                swal("Error", "Something went wrong!", "error");
                            }
                        });
                    }
                });
            }
        };

        // Row Click Trigger for Subscriber Details
        $('#enrolled_users_table tbody').on('click', 'tr', function (e) {
            // Prevent trigger if clicking on interactive elements
            if ($(e.target).closest('.switch, .btn, a, input, select, label').length) return;

            var btn = $(this).find('button[onclick^="openCourseSidebar"]');
            if (btn.length) {
                var onclickAttr = btn.attr('onclick');
                var userIdMatch = onclickAttr.match(/\(([^)]+)\)/);
                if (userIdMatch && userIdMatch[1]) {
                    openCourseSidebar(userIdMatch[1]);
                }
            }
        });

        // Quick Enrollment Modal Logic
        $('#enrollmentModal').on('show.bs.modal', function () {
            resetEnrollModal();
            fetchCourses();
        });

        function resetEnrollModal() {
            $('#enroll_step_1').show();
            $('#enroll_step_2').hide();
            $('#enroll_step_3').hide();
            $('#enroll_course_id').val('').selectpicker('refresh');
            $('#enroll_user_ids').empty().selectpicker('refresh');
            $('#btn_next_to_users').prop('disabled', true);
            $('#btn_next_to_confirm').prop('disabled', true);

            updateStepper(1);
        }

        function updateStepper(step) {
            $('.modal-stepper .step').removeClass('active completed');
            for (var i = 1; i < step; i++) {
                $('#step_indicator_' + i).addClass('completed');
            }
            $('#step_indicator_' + step).addClass('active');
        }

        function fetchCourses() {
            $('#enroll_loading').css('display', 'flex');
            $.ajax({
                url: '<?php echo site_url("admin/lms/enrolled_users/get_active_courses_ajax"); ?>',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    var options = '<option value="">-- Select Course --</option>';
                    $.each(data, function (i, course) {
                        options += `<option value="${course.id}">${course.title}</option>`;
                    });
                    $('#enroll_course_id').html(options).selectpicker('refresh');
                },
                complete: function () {
                    $('#enroll_loading').hide();
                }
            });
        }

        $('#enroll_course_id').on('change', function () {
            $('#btn_next_to_users').prop('disabled', !$(this).val());
        });

        $('#btn_next_to_users').on('click', function () {
            var courseId = $('#enroll_course_id').val();
            if (!courseId) return;

            $('#enroll_loading').css('display', 'flex');
            $.ajax({
                url: '<?php echo site_url("admin/lms/enrolled_users/get_users_for_enrollment_ajax"); ?>',
                type: 'POST',
                data: {
                    course_id: courseId,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                success: function (data) {
                    var options = '';
                    $.each(data, function (i, user) {
                        options += `<option value="${user.id}" data-subtext="${user.email}">${user.first_name} ${user.last_name}</option>`;
                    });
                    $('#enroll_user_ids').html(options).selectpicker('refresh');
                    $('#enroll_step_1').hide();
                    $('#enroll_step_2').show();
                    updateStepper(2);
                },
                complete: function () {
                    $('#enroll_loading').hide();
                }
            });
        });

        $('#enroll_user_ids').on('change', function () {
            var selected = $(this).val();
            $('#btn_next_to_confirm').prop('disabled', !selected || selected.length === 0);
        });

        $('#btn_back_to_course').on('click', function () {
            $('#enroll_step_2').hide();
            $('#enroll_step_1').show();
            updateStepper(1);
        });

        $('#btn_next_to_confirm').on('click', function () {
            var courseName = $('#enroll_course_id option:selected').text();
            var selectedUsers = $('#enroll_user_ids option:selected');

            $('#summary_course_name').text(courseName);
            $('#summary_user_count').text(selectedUsers.length + ' users selected');

            var chips = '';
            selectedUsers.each(function () {
                chips += `<span class="user-chip">${$(this).text()}</span>`;
            });
            $('#summary_user_list').html(chips);

            $('#enroll_step_2').hide();
            $('#enroll_step_3').show();
            updateStepper(3);
        });

        $('#btn_back_to_users').on('click', function () {
            $('#enroll_step_3').hide();
            $('#enroll_step_2').show();
            updateStepper(2);
        });

        $('#btn_confirm_enrollment').on('click', function () {
            var courseId = $('#enroll_course_id').val();
            var userIds = $('#enroll_user_ids').val();

            if (!courseId || !userIds || userIds.length === 0) return;

            $('#enroll_loading').css('display', 'flex');
            $.ajax({
                url: '<?php echo site_url("admin/lms/enrolled_users/save_enrollment_ajax"); ?>',
                type: 'POST',
                data: {
                    course_id: courseId,
                    user_ids: userIds,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                success: function (data) {
                    if (data.flag) {
                        $.notify({ message: data.msg }, { type: 'success' });
                        $('#enrollmentModal').modal('hide');
                        table.draw();
                        // Ideally refresh counts here, but for now a simple refresh of the table is good
                    } else {
                        $.notify({ message: data.msg }, { type: 'danger' });
                    }
                },
                complete: function () {
                    $('#enroll_loading').hide();
                }
            });
        });
    });

    function openCourseSidebar(userId) {
        var sidebar = $('#courseSidebar');
        var overlay = $('#sidebarOverlay');
        var content = $('#courseSidebarBody');
        var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
        var csrf_name = '<?php echo $this->security->get_csrf_token_name(); ?>';

        // Show sidebar and overlay
        sidebar.addClass('open');
        overlay.addClass('show');

        // Show loader
        content.html('<div class="loader-container text-center" style="margin-top: 100px;"><div class="preloader pl-size-xl"><div class="spinner-layer pl-indigo"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div><p style="margin-top: 20px; font-weight: 600; color: #64748b;">Loading user details...</p></div>');

        // Prepare data with CSRF
        var postData = { user_id: userId };
        postData[csrf_name] = csrf_token;

        // Fetch data
        $.ajax({
            url: '<?php echo site_url("admin/lms/enrolled_users/ajax_get_courses"); ?>',
            type: 'POST',
            data: postData,
            success: function (response) {
                setTimeout(function () {
                    content.html(response);
                }, 300);
            },
            error: function () {
                content.html('<div class="alert alert-danger" style="margin: 20px;">Error loading data. Please try again.</div>');
            }
        });
    }

    function closeCourseSidebar() {
        $('#courseSidebar').removeClass('open');
        $('#sidebarOverlay').removeClass('show');
    }
    function toggleLearningLock(userId, status) {
        // Immediate feedback (optional: could show a spinner on the button)

        $.ajax({
            url: "<?php echo site_url("admin/lms/enrolled_users/toggle_lock_ajax"); ?>",
            type: "POST",
            data: {
                user_id: userId,
                status: status,
                "<?php echo $this->security->get_csrf_token_name(); ?>": "<?php echo $this->security->get_csrf_hash(); ?>"
            },
            dataType: "JSON",
            success: function (data) {
                if (data.flag == 1) {
                    $.notify({ message: data.msg }, { type: "success" });
                    // Update stats count
                    $("#total_locked_learning_count").text(data.new_count);
                    // Update table row without refresh
                    if (typeof table !== "undefined") {
                        table.ajax.reload(null, false);
                    }
                } else {
                    $.notify({ message: data.msg }, { type: "danger" });
                }
            },
            error: function () {
                $.notify({ message: "Something went wrong!" }, { type: "danger" });
            }
        });
    }
    function removeEnrollment(csId, userId) {
        swal({
            title: "Are you sure?",
            text: "This user will no longer have access to this course!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#6366f1",
            cancelButtonColor: "#94a3b8",
            confirmButtonText: "Yes, remove enrollment!",
            closeOnConfirm: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "<?php echo site_url("admin/lms/enrolled_users/remove_enrollment_ajax"); ?>",
                    type: "POST",
                    data: {
                        cs_id: csId,
                        "<?php echo $this->security->get_csrf_token_name(); ?>": "<?php echo $this->security->get_csrf_hash(); ?>"
                    },
                    dataType: "JSON",
                    success: function (data) {
                        if (data.flag == 1) {
                            $.notify({ message: data.msg }, { type: "success" });
                            // Refresh sidebar content
                            openCourseSidebar(userId);
                            // Refresh main table if it exists
                            if (typeof table !== "undefined") table.ajax.reload(null, false);
                        } else {
                            $.notify({ message: data.msg }, { type: "danger" });
                        }
                    },
                    error: function () {
                        $.notify({ message: "Something went wrong!" }, { type: "danger" });
                    }
                });
            }
        });
    }
    function removeAllUserEnrollments(userId) {
        swal({
            title: "Are you sure?",
            text: "This will remove ALL course enrollments for this user!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#f44336",
            cancelButtonColor: "#94a3b8",
            confirmButtonText: "Yes, remove ALL!",
            closeOnConfirm: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "<?php echo site_url("admin/lms/enrolled_users/remove_all_user_enrollments_ajax"); ?>",
                    type: "POST",
                    data: {
                        user_id: userId,
                        "<?php echo $this->security->get_csrf_token_name(); ?>": "<?php echo $this->security->get_csrf_hash(); ?>"
                    },
                    dataType: "JSON",
                    success: function (data) {
                        if (data.flag == 1) {
                            $.notify({ message: data.msg }, { type: "success" });
                            // Update total enrolled count
                            $("#total_enrolled_count").text(data.total_enrolled);
                            // Reload table
                            if (typeof table !== "undefined") table.ajax.reload(null, false);
                        } else {
                            $.notify({ message: data.msg }, { type: "danger" });
                        }
                    },
                    error: function () {
                        $.notify({ message: "Something went wrong!" }, { type: "danger" });
                    }
                });
            }
        });
    }
</script>