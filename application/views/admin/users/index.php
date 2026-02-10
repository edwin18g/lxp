<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* User Management View */
?>

<div class="row clearfix">
    <!-- Stats Cards -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon">
                <i class="material-icons">people</i>
            </div>
            <div class="content">
                <div class="text">TOTAL USERS</div>
                <div class="number">
                    <?php echo $total_users; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-light-green hover-expand-effect">
            <div class="icon">
                <i class="material-icons">check_circle</i>
            </div>
            <div class="content">
                <div class="text">ACTIVE USERS</div>
                <div class="number">
                    <?php echo $active_users; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-orange hover-expand-effect">
            <div class="icon">
                <i class="material-icons">block</i>
            </div>
            <div class="content">
                <div class="text">INACTIVE USERS</div>
                <div class="number">
                    <?php echo $inactive_users; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue-grey hover-expand-effect">
            <div class="icon">
                <i class="material-icons">person_add</i>
            </div>
            <div class="content">
                <div class="text">NEW TODAY</div>
                <div class="number">
                    <?php
                    // Simple logic to count users added today if date_added is available 
                    // Since it wasn't passed from controller, we strictly rely on what's available or simple text for now.
                    // Actually, we can just show a button or link here, but let's leave it as a placeholder or remove it.
                    // Let's use it for "Groups" count or something else if we had it. For now, let's keep it consistent.
                    echo $this->db->like('date_added', date('Y-m-d'))->count_all_results('users');
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix index-page">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header"
                style="background: linear-gradient(45deg, #009688, #4DB6AC); color: white; padding: 20px;">
                <!-- Page Heading -->
                <h2 class="text-uppercase" style="margin: 0; font-weight: 500;">
                    <i class="material-icons" style="vertical-align: middle; margin-right: 10px;">manage_accounts</i>
                    <?php echo lang('menu_users'); ?>
                </h2>

                <div class="header-dropdown m-r--5">
                    <!-- Back Button -->
                    <a href="<?php echo site_url('admin') ?>"
                        class="btn btn-default btn-circle waves-effect waves-circle waves-float" title="Back"
                        style="margin-right: 10px; color: #333;">
                        <i class="material-icons">arrow_back</i>
                    </a>

                    <!-- Add Button -->
                    <a href="<?php echo site_url('admin/users/form'); ?>"
                        class="btn btn-default btn-circle waves-effect waves-circle waves-float" title="Add New User"
                        style="color: #333;">
                        <i class="material-icons">add</i>
                    </a>
                </div>
            </div>
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

<!-- User Details Offcanvas -->
<div id="userSidebar" class="right-sidebar">
    <div class="sidebar-header">
        <h4 style="margin:0;">User Details</h4>
        <button class="btn btn-link btn-circle waves-effect waves-circle waves-float close-sidebar"
            onclick="closeUserSidebar()">
            <i class="material-icons">close</i>
        </button>
    </div>
    <div class="sidebar-body" id="userSidebarBody">
        <div class="loader-container text-center" style="padding: 20px;">
            <div class="preloader pl-size-xl">
                <div class="spinner-layer pl-teal">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Sidebar Styles */
    .right-sidebar {
        position: fixed;
        top: 0;
        right: -400px;
        width: 400px;
        height: 100%;
        background: #fff;
        z-index: 9999;
        transition: right 0.3s ease;
        box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
    }

    .right-sidebar.open {
        right: 0;
    }

    .sidebar-header {
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8f9fa;
    }

    .sidebar-body {
        padding: 20px;
    }

    /* Custom styles for this view */
    .info-box {
        cursor: pointer;
    }

    .img-circle {
        border-radius: 50%;
        object-fit: cover;
    }
</style>

<script>
    var table;
    $(document).ready(function () {
        // Initialize DataTable
        table = $('#table').DataTable({
            "destroy": true, // Fix for Cannot reinitialise DataTable
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('admin/users/ajax_list') ?>",
                "type": "POST",
                "data": { <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' }
            },
            "columnDefs": [
                { "orderable": false, "targets": [0, 1] } // Disable sorting on ID and Image columns
            ],
            "order": [[2, "asc"]] // Default sort by First Name
        });
    });

    function openUserSidebar(id) {
        $('#userSidebar').addClass('open');
        $('#userSidebarBody').html('<div class="text-center" style="margin-top:50px;"><div class="preloader pl-size-xl"><div class="spinner-layer pl-teal"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></div>');

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
</script>