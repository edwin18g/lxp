<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin Template
 */
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?php echo base_url('/upload/institute/') ?>/logo.png" />
  <meta name="theme-color" content="#9c27b0">

  <title><?php echo $page_title; ?> - <?php echo $this->settings->site_name; ?></title>

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">


  <?php // CSS files ?>
  <?php if (isset($css_files) && is_array($css_files)): ?>
    <?php foreach ($css_files as $css): ?>
      <?php if (!is_null($css)): ?>
        <link rel="stylesheet" href="<?php echo $css; ?>?v=<?php echo $this->settings->site_version; ?>"><?php echo "\n"; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endif; ?>
  <?php // Javascript files ?>
  <?php if (isset($js_files) && is_array($js_files)): ?>
    <?php foreach ($js_files as $js): ?>
      <?php if (!is_null($js)): ?>
        <?php echo "\n"; ?>
        <script type="text/javascript" src="<?php echo $js; ?>?v=<?php echo $this->settings->site_version; ?>"></script>
        <?php echo "\n"; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endif; ?>
  <?php if (isset($js_files_i18n) && is_array($js_files_i18n)): ?>
    <?php foreach ($js_files_i18n as $js): ?>
      <?php if (!is_null($js)): ?>
        <?php echo "\n"; ?>
        <script type="text/javascript"><?php echo "\n" . $js . "\n"; ?></script><?php echo "\n"; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endif; ?>

  <!-- Modern Admin CSS (Global Overrides) -->
  <link
    href="<?php echo base_url('themes/admin/css/modern_admin.css'); ?>?v=<?php echo $this->settings->site_version; ?>"
    rel="stylesheet" type="text/css">

  <!-- Admin Shared Components CSS -->
  <link
    href="<?php echo base_url('themes/admin/css/admin_components.css'); ?>?v=<?php echo $this->settings->site_version; ?>"
    rel="stylesheet" type="text/css">

  <!-- Admin Page-Specific CSS -->
  <link
    href="<?php echo base_url('themes/admin/css/admin_pages.css'); ?>?v=<?php echo $this->settings->site_version; ?>"
    rel="stylesheet" type="text/css">
</head>

<body class="theme-<?php echo $this->settings->admin_theme; ?>">
  <!-- Page Loader -->
  <div class="page-loader-wrapper">
    <div class="loader">
      <div class="preloader">
        <div class="spinner-layer pl-<?php echo $this->settings->admin_theme; ?>">
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
  <!-- #END# Page Loader -->
  <!-- Overlay For Sidebars -->
  <div class="overlay"></div>
  <!-- #END# Overlay For Sidebars -->
  <!-- Search Bar -->
  <div class="search-bar">
    <div class="search-icon">
      <i class="material-icons">search</i>
    </div>
    <input type="text" placeholder="<?php echo lang('action_search'); ?>">
    <div class="close-search">
      <i class="material-icons">close</i>
    </div>
  </div>
  <!-- #END# Search Bar -->
  <!-- Top Bar -->
  <nav class="navbar">
    <div class="container-fluid">
      <div style="display: flex; align-items: center; gap: 16px;">
        <button class="navbar-toggle-btn" id="sidebarToggleBtn" style="background: transparent; border: none; color: #475569; cursor: pointer; display: flex; align-items: center; padding: 4px;">
          <i class="material-icons" style="font-size: 26px;">menu</i>
        </button>
        <h3 style="margin: 0; font-weight: 800; font-size: 1.35rem; color: #0f172a; letter-spacing: -0.02em;"><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></h3>
      </div>

      <div style="display: flex; align-items: center; gap: 24px;">
        <!-- Search bar input -->
        <div style="position: relative; width: 340px;">
          <i class="material-icons" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 22px;">search</i>
          <input type="text" class="global-dt-search" placeholder="Search learners, courses, batches..." style="width: 100%; height: 44px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 12px; padding: 10px 14px 10px 46px; font-size: 0.95rem; font-weight: 500; color: #1e293b; outline: none; transition: all 0.2s;" data-table="table">
        </div>

        <!-- Icons right -->
        <ul class="nav navbar-nav navbar-right" style="display: flex; align-items: center; gap: 12px; margin: 0;">
          <li>
            <a href="javascript:void(0);" style="position: relative; padding: 10px !important;">
              <i class="material-icons" style="font-size: 24px; color: #475569;">notifications</i>
              <?php if (count($this->notifications)) { ?><span class="label-count" style="position: absolute; top: 2px; right: 2px; background: #ef4444; color: #fff; font-size: 11px; border-radius: 10px; padding: 2px 7px; font-weight: 700;"><?php echo count($this->notifications) ?></span><?php } ?>
            </a>
          </li>
          <li>
            <a href="<?php echo site_url(); ?>" target="_blank" title="Visit Site" style="padding: 10px !important;">
              <i class="material-icons" style="font-size: 24px; color: #475569;">public</i>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);" style="padding: 10px !important;">
              <i class="material-icons" style="font-size: 24px; color: #475569;">aspect_ratio</i>
            </a>
          </li>
          <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" style="padding: 4px !important; display: flex; align-items: center;">
              <img src="<?php echo !empty($_SESSION['logged_in']['image']) ? base_url('upload/users/images/' . $_SESSION['logged_in']['image']) : base_url('themes/admin/img/avatar2.png'); ?>" style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #cbd5e1;" onerror="this.onerror=null;this.src='<?php echo base_url('themes/admin/img/avatar2.png'); ?>';">
            </a>
            <ul class="dropdown-menu pull-right" style="border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); border: 1px solid #e2e8f0; padding: 8px 0;">
              <li><a href="<?php echo site_url('admin/users/form/') . $_SESSION['logged_in']['id']; ?>" style="font-size: 0.92rem; font-weight: 600; padding: 10px 18px;"><i class="material-icons" style="font-size: 20px;">person</i> Profile</a></li>
              <li><a href="<?php echo site_url('logout'); ?>" style="font-size: 0.92rem; font-weight: 600; padding: 10px 18px;"><i class="material-icons" style="font-size: 20px;">input</i> Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- #Top Bar -->

  <section>
    <!-- Full Left Sidebar -->
    <aside id="leftsidebar" class="sidebar full-sidebar">
      <!-- Brand Logo -->
      <div class="sidebar-brand">
        <div class="brand-logo-icon">
          <i class="material-icons" style="color: #ffffff; font-size: 22px;">bolt</i>
        </div>
        <span class="brand-name"><?php echo $this->settings->site_name; ?></span>
      </div>

      <!-- Navigation Links -->
      <div class="sidebar-nav-scroll">
        <!-- Dashboard Item -->
        <a href="<?php echo site_url('admin'); ?>" class="nav-item <?php echo (uri_string() == 'admin' || uri_string() == 'admin/dashboard') ? 'active' : ''; ?>">
          <i class="material-icons">dashboard</i>
          <span>Dashboard</span>
        </a>

        <!-- Category: LEARNING -->
        <div class="nav-category">LEARNING</div>
        <a href="<?php echo site_url('admin/categories'); ?>" class="nav-item <?php echo strstr(uri_string(), 'admin/categories') ? 'active' : ''; ?>">
          <i class="material-icons">schema</i>
          <span>Course Categories</span>
        </a>
        <a href="<?php echo site_url('admin/courses'); ?>" class="nav-item <?php echo strstr(uri_string(), 'admin/courses') ? 'active' : ''; ?>">
          <i class="material-icons">import_contacts</i>
          <span>Courses</span>
        </a>
        <a href="<?php echo site_url('admin/batches'); ?>" class="nav-item <?php echo strstr(uri_string(), 'admin/batches') ? 'active' : ''; ?>">
          <i class="material-icons">date_range</i>
          <span>Batches</span>
        </a>
        <a href="<?php echo site_url('admin/enrolled_users'); ?>" class="nav-item <?php echo strstr(uri_string(), 'admin/enrolled_users') ? 'active' : ''; ?>">
          <i class="material-icons">assignment_ind</i>
          <span>Enrolled Users</span>
        </a>

        <!-- Category: MANAGE -->
        <div class="nav-category">MANAGE</div>
        <a href="<?php echo site_url('admin/users'); ?>" class="nav-item <?php echo strstr(uri_string(), 'admin/users') ? 'active' : ''; ?>">
          <i class="material-icons">people_outline</i>
          <span>Learners</span>
        </a>
        <a href="<?php echo site_url('admin/groups'); ?>" class="nav-item <?php echo strstr(uri_string(), 'admin/groups') ? 'active' : ''; ?>">
          <i class="material-icons">badge</i>
          <span>Instructors / Roles</span>
        </a>
        <a href="<?php echo site_url('admin/manageacl'); ?>" class="nav-item <?php echo strstr(uri_string(), 'admin/manageacl') ? 'active' : ''; ?>">
          <i class="material-icons">analytics</i>
          <span>Permissions</span>
        </a>
        <a href="<?php echo site_url('admin/events'); ?>" class="nav-item <?php echo strstr(uri_string(), 'admin/events') ? 'active' : ''; ?>">
          <i class="material-icons">event</i>
          <span>Events</span>
        </a>

        <!-- Category: SYSTEM -->
        <div class="nav-category">SYSTEM</div>
        <a href="<?php echo site_url('admin/contacts'); ?>" class="nav-item <?php echo strstr(uri_string(), 'admin/contacts') ? 'active' : ''; ?>">
          <i class="material-icons">chat_bubble_outline</i>
          <span>CMS / Contacts</span>
        </a>
        <a href="<?php echo site_url('admin/settings'); ?>" class="nav-item <?php echo strstr(uri_string(), 'admin/settings') ? 'active' : ''; ?>">
          <i class="material-icons">settings</i>
          <span>Settings</span>
        </a>
      </div>

      <!-- User Profile Badge at Bottom -->
      <div class="sidebar-user-badge">
        <img src="<?php echo !empty($_SESSION['logged_in']['image']) ? base_url('upload/users/images/' . $_SESSION['logged_in']['image']) : base_url('themes/admin/img/avatar2.png'); ?>" alt="User" onerror="this.onerror=null;this.src='<?php echo base_url('themes/admin/img/avatar2.png'); ?>';">
        <div class="user-info-text">
          <span class="user-name"><?php echo isset($_SESSION['logged_in']['first_name']) ? $_SESSION['logged_in']['first_name'] . ' ' . $_SESSION['logged_in']['last_name'] : 'Admin User'; ?></span>
          <span class="user-email"><?php echo isset($_SESSION['logged_in']['email']) ? $_SESSION['logged_in']['email'] : 'admin@admin.com'; ?></span>
          <span class="online-status"><span class="dot"></span> Online</span>
        </div>
      </div>
    </aside>
    <!-- #END# Left Sidebar -->
  </section>

  <section class="content">
    <div class="container-fluid">

      <!-- Breadcrumbs -->
      <?php if (isset($breadcrumb) && !empty($breadcrumb)): ?>
        <ol class="breadcrumb">
          <?php foreach ($breadcrumb as $key => $crumb): ?>
            <?php if (isset($crumb['route_path'])): ?>
              <li>
                <a href="<?php echo $crumb['route_path']; ?>">
                  <?php if (isset($crumb['icon'])): ?>
                    <i class="material-icons"><?php echo $crumb['icon']; ?></i>
                  <?php endif; ?>
                  <?php echo $crumb['route_name']; ?>
                </a>
              </li>
            <?php else: ?>
              <li class="active"><?php echo $crumb['route_name']; ?></li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ol>
      <?php endif; ?>

      <!-- Ajax validation error -->
      <div class="alert alert-danger alert-dismissable" id="validation-error">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p></p>
      </div>

      <!--  page content -->
      <?php echo $content; ?>
      <!-- /.page content -->
    </div>
  </section>



  <script type="text/javascript">
    var admin_theme = "<?php echo $this->settings->admin_theme; ?>";
    var base_url = "<?php echo base_url(); ?>";
    var site_url = "<?php echo site_url(); ?>";
    var uri_seg_1 = "<?php echo $this->uri->segment(1); ?>";
    var uri_seg_2 = "<?php echo $this->uri->segment(2); ?>";
    var uri_seg_3 = "<?php echo $this->uri->segment(3); ?>";
    var uri_seg_4 = "<?php echo $this->uri->segment(4); ?>";
    var csrf_name = "<?php echo $this->security->get_csrf_token_name(); ?>";
    var csrf_token = "<?php echo $this->security->get_csrf_hash(); ?>";

    /* Global DataTable Defaults */
    if ($.fn.dataTable) {
      $.extend(true, $.fn.dataTable.defaults, {
        "dom": 'rt<"dt-bottom-actions"ipl>', // Removed f (search) from here
        "pageLength": 10,
        "language": {
          "lengthMenu": "_MENU_",
          "search": "",
          "searchPlaceholder": "Search..."
        }
      });

      // Global External Search Binding
      $(document).on('keyup', '.global-dt-search', function () {
        var tableId = $(this).data('table') || 'table';
        var table = $('#' + tableId).DataTable();
        table.search($(this).val()).draw();
      });
    }

    /*System Notification*/
    $(function () {
      var message = `<?php echo null !== $this->session->flashdata('message') ? $this->session->flashdata('message') : null ?>`;
      var error = `<?php echo null !== $this->session->flashdata('error') ? $this->session->flashdata('error') : null ?>`;
      var v_errors = `<?php echo null !== validation_errors() ? validation_errors() : null ?>`;
      var s_error = `<?php echo null !== $this->error ? $this->error : null ?>`;

      if (message != '') show_success(message);
      if (error != '') show_danger(error);
      if (v_errors != '') show_danger(v_errors);
      if (s_error != '') show_danger(s_error);
    });
  </script>


  <script>
    function switchProduct(productName) {
      $('.product-item').removeClass('active');

      // Logic to find active item better
      $('.product-item').each(function () {
        if ($(this).attr('onclick') && $(this).attr('onclick').includes("'" + productName + "'")) {
          $(this).addClass('active');
        }
      });

      // Target all menu lists
      var $allLists = $('.list');

      // First, Hide all lists AND their wrappers
      $allLists.each(function () {
        var $list = $(this);
        $list.hide(); // Hide the list itself
        if ($list.parent().hasClass('slimScrollDiv')) {
          $list.parent().hide(); // Hide the wrapper
        }
      });

      // Second, Show the selected menu list
      var $activeList = $('#menu-' + productName);
      $activeList.show(); // CRITICAL: Ensure the inner UL is visible

      // Third, Show its wrapper (if it has one) or the list itself
      var $activeContainer = $activeList.parent().hasClass('slimScrollDiv') ? $activeList.parent() : $activeList;

      $activeContainer.fadeIn(200, function () {
        if (typeof $.fn.slimScroll != 'undefined') {
          // Reset scroll position and trigger a refresh
          $activeList.slimscroll({ scrollTo: '0px' });
        }
      });

      // Sync page tab bar with active product section
      $('.page-tab-group').removeClass('active');
      $('#tabs-' + productName).addClass('active');

      if (typeof (Storage) !== "undefined") {
        localStorage.setItem("activeProduct", productName);
      }

      // Redirect to main page for each product section
      var productRoutes = {
        'lms': 'admin',
        'users': 'admin/users',
        'cms': 'admin/contacts',
        'system': 'admin/settings'
      };

      if (productRoutes[productName]) {
        var currentPath = window.location.pathname.replace(/\/+$/, '');
        var targetPath = site_url + productRoutes[productName];
        if (currentPath !== '/' + productRoutes[productName]) {
          window.location.href = targetPath;
        }
      }
    }

    $(function () {
      var activeProduct = localStorage.getItem("activeProduct");
      if (activeProduct) {
        switchProduct(activeProduct);
      } else {
        var url = window.location.href;
        if (url.includes('admin/users') || url.includes('admin/enrolled_users')) {
          switchProduct('users');
        } else if (url.includes('admin/contacts') || url.includes('admin/testimonials') || url.includes('admin/sliders') || url.includes('admin/pages') || url.includes('admin/menus') || url.includes('admin/faqs')) {
          switchProduct('cms');
        } else if (url.includes('admin/settings')) {
          switchProduct('system');
        } else {
          switchProduct('lms');
        }
      }
    });
  </script>

  <!-- Admin Shared JS -->
  <script type="text/javascript" src="<?php echo base_url('themes/admin/js/admin_shared.js'); ?>?v=<?php echo $this->settings->site_version; ?>"></script>

  <!-- User Details Offcanvas (Global) -->
  <div id="userSidebar" class="right-sidebar">
    <div class="sidebar-header">
      <h4 style="margin:0;"><span id="userSidebarTitle">User Details</span></h4>
      <button class="btn btn-link btn-circle waves-effect waves-circle waves-float close-sidebar"
        onclick="closeUserSidebar()">
        <i class="material-icons">close</i>
      </button>
    </div>
    <div class="offcanvas-body-premium" id="userSidebarBody">
      <!-- Content loaded via Ajax -->
    </div>
  </div>

</body>

</html>