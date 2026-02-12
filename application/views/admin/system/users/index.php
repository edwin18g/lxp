<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* User Management View */
?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="stats-bar-container animate-up">
            <div class="stats-bar-item">
                <div class="item-icon bg-indigo-soft color-indigo">
                    <i class="material-icons">people</i>
                </div>
                <div class="item-content">
                    <span class="item-label">TOTAL USERS</span>
                    <span class="item-number"><?php echo $total_users; ?></span>
                </div>
            </div>

            <div class="stats-bar-item">
                <div class="item-icon bg-emerald-soft color-emerald">
                    <i class="material-icons">person_add_alt</i>
                </div>
                <div class="item-content">
                    <span class="item-label">ACTIVE</span>
                    <span class="item-number"><?php echo $active_users; ?></span>
                </div>
            </div>

            <div class="stats-bar-item">
                <div class="item-icon bg-rose-soft color-rose">
                    <i class="material-icons">person_off</i>
                </div>
                <div class="item-content">
                    <span class="item-label">INACTIVE</span>
                    <span class="item-number"><?php echo $total_users - $active_users; ?></span>
                </div>
            </div>

            <!-- External Search Box -->
            <div class="stats-bar-item search-item" style="flex: 2; min-width: 300px;">
                <div class="global-search-wrapper" style="width: 100%;">
                    <i class="material-icons">search</i>
                    <input type="text" class="global-dt-search" placeholder="Search by name, email or phone..."
                        data-table="table">
                    <button type="button" id="clearAllFilters" class="btn-clear-all" style="display: none;"
                        title="Clear All Filters">
                        <i class="material-icons">filter_alt_off</i>
                        <span>Clear Filters</span>
                    </button>
                </div>
            </div>

            <!-- Add New User Action Card -->
            <button onclick="openUserFormSidebar()"
                class="stats-bar-item action-item bg-indigo color-white text-decoration-none"
                style="flex: 0; min-width: 180px; border: none; cursor: pointer; text-align: left;">
                <div class="item-icon" style="background: rgba(255,255,255,0.2);">
                    <i class="material-icons">add</i>
                </div>
                <div class="item-content">
                    <span class="item-label" style="color: rgba(255,255,255,0.8);">ACTION</span>
                    <span class="item-number" style="color: #fff; font-size: 14px;">ADD NEW USER</span>
                </div>
            </button>
        </div>
    </div>
</div>

<div class="row clearfix index-page">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card premium-table-card">

            <div class="body table-responsive">
                <table id="table" class="table table-hover table-striped dataTable">
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
        // Initialize DataTable
        table = $('#table').DataTable({
            "destroy": true, // Fix for Cannot reinitialise DataTable
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "ajax": {
                "url": "<?php echo site_url('admin/users/ajax_list') ?>",
                "type": "POST",
                "data": { <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' }
            },
            "columnDefs": [
                { "orderable": false, "targets": [0, 1, 9] } // Disable sorting on ID, Image and actions columns
            ],
            "initComplete": function () {
                var api = this.api();

                // Add filter icons to headers
                $('#table thead th').each(function (i) {
                    var title = $(this).text();
                    var searchable_cols = [2, 3, 4, 5, 6, 7, 8];

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
                                                <option value="">All Groups</option>
                                                <option value="admin">Admin</option>
                                                <option value="manager">Manager</option>
                                                <option value="user">User</option>
                                            </select>
                                        ` : i === 8 ? `
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
                        $(this).append(filterHtml);
                    }
                });

                // Toggle dropdown
                $(document).on('click', '.btn-filter-toggle', function (e) {
                    e.stopPropagation();
                    var wrapper = $(this).closest('.header-filter-wrapper');
                    $('.header-filter-wrapper').not(wrapper).find('.filter-dropdown').removeClass('show');
                    wrapper.find('.filter-dropdown').toggleClass('show');
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
                        $('#clearAllFilters').fadeIn();
                    } else {
                        $('#clearAllFilters').fadeOut();
                    }
                }

                $('#clearAllFilters').on('click', function () {
                    $('.filter-input-google, .filter-select-google').val('');
                    $('.btn-filter-toggle').removeClass('active');
                    api.columns().search('').draw();
                    $(this).fadeOut();
                });
            },
            "drawCallback": function (settings) {
                var api = this.api();
                var rowCount = api.rows({ page: 'current' }).count();
                var tableBody = $('#table tbody');

                if (rowCount === 0) {
                    var colCount = api.columns().count();
                    tableBody.html(`
                        <tr>
                            <td colspan="${colCount}" class="p-0">
                                <div class="table-empty-state animate-up">
                                    <i class="material-icons">search_off</i>
                                    <h4>No matches found</h4>
                                    <p>Try adjusting your filters or search terms to find what you're looking for.</p>
                                </div>
                            </td>
                        </tr>
                    `);
                }
            },
            "order": [[2, "asc"]] // Default sort by First Name
        });
    });

    function openUserSidebar(id) {
        $('#userSidebarTitle').text('User Details');
        $('#userSidebar').addClass('open');
        $('#userSidebarBody').html('<div class="text-center" style="margin-top:100px;"><div class="preloader pl-size-xl"><div class="spinner-layer pl-indigo"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div><p style="margin-top:20px; color:#94a3b8; font-weight:500;">Fetching Details...</p></div>');

        $.ajax({
            url: "<?php echo site_url('admin/users/get_user_details/') ?>" + id,
            type: "GET",
            success: function (data) {
                $('#userSidebarBody').html(data);
            },
            error: function () {
                $('#userSidebarBody').html('<p class="text-danger">Error fetching data.</p>');
            }
        });
    }

    function closeUserSidebar() {
        $('#userSidebar').removeClass('open');
    }
    function openUserFormSidebar(id = null) {
        var url = site_url + 'admin/users/form';
        if (id) {
            url += '/' + id;
        }

        $('#userSidebarBody').html(`<div class="text-center" style="padding:100px 50px;">
            <div class="preloader pl-size-xl">
                <div class="spinner-layer pl-indigo">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p style="margin-top:20px; color:#64748b; font-weight:600;">Loading Form...</p>
        </div>`);
        $('#userSidebar').addClass('open');

        $.get(url, function (data) {
            $('#userSidebarBody').html(data);

            // Re-initialize Datepicker
            if ($.fn.datepicker) {
                $('#dob').datepicker({
                    autoclose: true,
                    format: 'dd-mm-yyyy'
                });
            }

            // Image Preview logic
            $('#image').on('change', function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#c_image').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Handle form submission
            $('#userSidebarBody form').on('submit', function (e) {
                e.preventDefault();
                var $form = $(this);
                var $btn = $form.find('button[type="submit"]');
                var originalBtnContent = $btn.html();

                $btn.prop('disabled', true).html('<i class="material-icons rotating">sync</i> PROCESSING...');

                var formData = new FormData(this);
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.flag == 1) {
                            show_success(response.msg);
                            closeUserSidebar();
                            if (typeof table !== 'undefined') {
                                table.ajax.reload(null, false);
                            }
                        } else {
                            show_danger(response.msg);
                            // Highlight error fields if any
                            if (response.error_fields) {
                                try {
                                    var fields = JSON.parse(response.error_fields);
                                    $('.form-line-premium').removeClass('error');
                                    $.each(fields, function (i, field) {
                                        $('[name="' + field + '"]').closest('.form-line-premium').addClass('error');
                                    });
                                } catch (e) { }
                            }
                            $btn.prop('disabled', false).html(originalBtnContent);
                        }
                    },
                    error: function () {
                        show_danger('A server error occurred. Please try again.');
                        $btn.prop('disabled', false).html(originalBtnContent);
                    }
                });
            });
        });
    }
</script>

<style>
    .rotating {
        animation: rotate 2s linear infinite;
        display: inline-block;
        vertical-align: middle;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .form-line-premium.error {
        border-color: #e11d48 !important;
        box-shadow: 0 0 0 4px rgba(225, 29, 72, 0.1) !important;
    }
</style>