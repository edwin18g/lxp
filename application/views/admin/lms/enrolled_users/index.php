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