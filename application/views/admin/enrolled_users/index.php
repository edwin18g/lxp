<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Enrolled Users View */
?>

<div class="row clearfix index-page">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header"
                style="background: linear-gradient(45deg, #009688, #4DB6AC); color: white; padding: 20px;">
                <!-- Page Heading -->
                <h2 class="text-uppercase" style="margin: 0; font-weight: 500;">
                    <i class="material-icons" style="vertical-align: middle; margin-right: 10px;">class</i>
                    Enrolled Users
                </h2>

                <div class="header-dropdown m-r--5">
                    <!-- Back Button -->
                    <a href="<?php echo site_url('admin') ?>"
                        class="btn btn-default btn-circle waves-effect waves-circle waves-float" title="Back"
                        style="margin-right: 10px; color: #333;">
                        <i class="material-icons">arrow_back</i>
                    </a>
                </div>
            </div>
            <div class="body table-responsive">
                <table id="enrolled_users_table" class="table table-hover table-striped">
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

<!-- Offcanvas Sidebar -->
<div id="courseSidebar" class="right-sidebar-custom">
    <div class="sidebar-header">
        <h4>User Courses <button type="button" class="close" onclick="closeCourseSidebar()">&times;</button></h4>
    </div>
    <div class="sidebar-body" id="sidebarContent">
        <div class="loader-container text-center">
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
            <p>Loading...</p>
        </div>
    </div>
</div>

<!-- Overlay -->
<div id="sidebarOverlay" class="sidebar-overlay" onclick="closeCourseSidebar()"></div>

<style>
    .img-circle {
        border-radius: 50%;
        object-fit: cover;
    }
    
    /* Offcanvas Styles */
    .right-sidebar-custom {
        position: fixed;
        top: 0;
        right: -350px; /* Hidden */
        width: 350px;
        height: 100%;
        background: #fff;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        z-index: 1050; /* Above modal backdrop */
        transition: right 0.3s ease-in-out;
        overflow-y: auto;
    }
    .right-sidebar-custom.open {
        right: 0;
    }
    .sidebar-header {
        padding: 15px;
        border-bottom: 1px solid #eee;
        background: #f8f8f8;
    }
    .sidebar-header h4 {
        margin: 0;
        font-size: 18px;
    }
    .sidebar-body {
        padding: 15px;
    }
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1040;
        display: none;
    }
    .sidebar-overlay.show {
        display: block;
    }
</style>

<script>
    $(document).ready(function() {
        $('#enrolled_users_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('admin/enrolled_users/ajax_list')?>",
                "type": "POST",
                "data": {csrf_token: csrf_token}
            },
            "columnDefs": [
                { "orderable": false, "targets": [0, 1] } 
            ]
        });
    });

    function openCourseSidebar(userId) {
        var sidebar = $('#courseSidebar');
        var overlay = $('#sidebarOverlay');
        var content = $('#sidebarContent');
        
        // Show sidebar and overlay
        sidebar.addClass('open');
        overlay.addClass('show');
        
        // Show loader
        content.html('<div class="loader-container text-center" style="margin-top: 50px;"><div class="preloader pl-size-xl"><div class="spinner-layer pl-teal"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div><p>Loading...</p></div>');
        
        // Fetch data
        $.ajax({
            url: '<?php echo site_url("admin/enrolled_users/ajax_get_courses"); ?>',
            type: 'POST',
            data: {user_id: userId, csrf_token: csrf_token}, 
            success: function(response) {
                setTimeout(function() { // simulated delay for smooth feel
                    content.html(response);
                }, 300);
            },
            error: function() {
                content.html('<p class="text-center text-danger">Error loading data.</p>');
            }
        });
    }
    
    function closeCourseSidebar() {
        $('#courseSidebar').removeClass('open');
        $('#sidebarOverlay').removeClass('show');
    }
</script>