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
      <div class="navbar-header">
        <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
          data-target="#navbar-collapse" aria-expanded="false"></a>
        <a href="javascript:void(0);" class="bars"></a>
        <a class="navbar-brand" href="<?php echo site_url('admin'); ?>">
          <?php echo $this->settings->site_name; ?>

        </a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <!-- Access Website -->
          <li>
            <a href="<?php echo site_url(); ?>" target="_blank" title="<?php echo lang('menu_access_website'); ?>">
              <i class="material-icons">public</i>
            </a>
          </li>
          <!-- #END# Access Website -->
          <!-- Call Search -->
          <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a>
          </li>
          <!-- #END# Call Search -->
          <!-- Notifications -->
          <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
              <i class="material-icons">notifications</i>
              <?php if (count($this->notifications)) { ?><span
                  class="label-count"><?php echo count($this->notifications) ?></span><?php } ?>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><?php echo lang('notifications') ?></li>
              <li class="body">
                <ul class="menu">
                  <?php if (!empty($this->notifications)) {
                    foreach ($this->notifications as $key => $val) { ?>
                      <li>
                        <a href="javascript:read_notification(`<?php echo $val->n_type ?>`, `<?php echo $val->n_url ?>`);">
                          <div class="icon-circle bg-<?php echo $this->settings->admin_theme ?>">
                            <?php if ($val->n_type == 'users') { ?>
                              <i class="material-icons">person_add</i>
                            <?php } else if ($val->n_type == 'events' || $val->n_type == 'batches') { ?>
                                <i class="material-icons">loupe</i>
                            <?php } else if ($val->n_type == 'bbookings' || $val->n_type == 'ebookings') { ?>
                                  <i class="material-icons">monetization_on</i>
                            <?php } else if ($val->n_type == 'b_cancellation' || $val->n_type == 'e_cancellation') { ?>
                                    <i class="material-icons">money_off</i>
                            <?php } else if ($val->n_type == 'contacts') { ?>
                                      <i class="material-icons">email</i>
                            <?php } ?>
                          </div>
                          <div class="menu-info">
                            <h4>
                              <?php echo $val->total . ' ' . lang('noti_new') . ' ' . sprintf(lang('' . $val->n_content . ''), lang('menu_' . $val->n_type . '')); ?>
                            </h4>
                            <p><i class="material-icons">access_time</i>
                              <?php echo time_elapsed_string($val->date_added); ?></p>
                          </div>
                        </a>
                      </li>
                    <?php }
                  } else { ?>
                    <li><a href="#" class="text-center"><?php echo lang('noti_no'); ?></a></li>
                  <?php } ?>
                </ul>
              </li>
            </ul>
          </li>
          <!-- #END# Notifications -->

          <!-- Language Dropdown -->
          <li class="dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown" role="button">
              <i class="material-icons">language</i>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><?php echo lang('languages') ?></li>
              <li class="body">
                <ul class="menu" id="session-language-dropdown">
                  <?php foreach ($this->languages as $key => $name): ?>
                    <li>
                      <a href="#" rel="<?php echo $key; ?>">
                        <?php if ($key == $this->session->language): ?>
                          <i class="fa fa-check selected-session-language"></i>
                        <?php endif; ?>
                        <?php echo $name; ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </li>
            </ul>
          </li>
          <!-- #END# Language Dropdown -->

          <!-- User Menu -->
          <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
              <i class="material-icons">account_circle</i>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><?php echo lang('action_account'); ?></li>
              <li class="body">
                <ul class="menu">
                  <li>
                    <a href="<?php echo site_url('admin/users/form/') . $_SESSION['logged_in']['id']; ?>">
                      <i class="material-icons">person</i> <?php echo lang('action_profile'); ?>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo site_url('logout'); ?>">
                      <i class="material-icons">input</i> <?php echo lang('action_logout'); ?>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <!-- #END# User Menu -->
        </ul>
      </div>
    </div>
  </nav>
  <!-- #Top Bar -->
  <section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">

      <!-- Product Bar -->
      <div class="product-bar">
        <!-- Branding / Home -->
        <div class="product-item brand" onclick="window.location.href='<?php echo site_url(); ?>'"
          title="Visit Website">
          <div class="brand-content">
            <i class="material-icons">public</i>
          </div>
        </div>

        <div class="product-item active" onclick="switchProduct('lms')" data-toggle="tooltip" data-placement="right"
          title="LMS">
          <i class="material-icons">school</i>
          <span class="product-name">LMS</span>
        </div>
        <div class="product-item" onclick="switchProduct('users')" data-toggle="tooltip" data-placement="right"
          title="Administration">
          <i class="material-icons">people</i>
          <span class="product-name">Manage</span>
        </div>
        <div class="product-item" onclick="switchProduct('cms')" data-toggle="tooltip" data-placement="right"
          title="CMS">
          <i class="material-icons">web</i>
          <span class="product-name">CMS</span>
        </div>
        <div class="product-item" onclick="switchProduct('system')" data-toggle="tooltip" data-placement="right"
          title="System">
          <i class="material-icons">settings_applications</i>
          <span class="product-name">System</span>
        </div>
      </div>

      <!-- Menu -->
      <div class="menu">
        <ul class="list" id="menu-lms">
          <!-- LMS Section -->
          <li class="header">LMS</li>

          <!-- Dashboard -->
          <li class="<?php echo (uri_string() == 'admin' OR uri_string() == 'admin/dashboard') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('/admin'); ?>">
              <i class="material-icons">dashboard</i>
              <span><?php echo lang('menu_dashboard'); ?></span>
            </a>
          </li>

          <!-- Class_categories -->
          <li class="<?php echo (strstr(uri_string(), 'admin/categories')) ? ' active' : ''; ?>">
            <a href="<?php echo site_url('admin/categories'); ?>">
              <i class="material-icons">device_hub</i>
              <span><?php echo lang('menu_course_categories'); ?></span>
            </a>
          </li>

          <!-- Courses -->
          <li class="<?php echo (strstr(uri_string(), 'admin/courses')) ? ' active' : ''; ?>">
            <a href="<?php echo site_url('admin/courses'); ?>">
              <i class="material-icons">account_balance</i>
              <span><?php echo lang('menu_courses'); ?></span>
            </a>
          </li>

          <!-- Batches -->
          <li class="<?php echo (strstr(uri_string(), 'admin/batches')) ? ' active' : ''; ?>">
            <a href="<?php echo site_url('admin/batches'); ?>">
              <i class="material-icons">event_note</i>
              <span><?php echo lang('menu_batches'); ?></span>
            </a>
          </li>

          <!-- Enrolled Users (Moved to LMS) -->
          <li class="<?php echo (strstr(uri_string(), 'admin/enrolled_users')) ? ' active' : ''; ?>">
            <a href="<?php echo site_url('admin/enrolled_users'); ?>">
              <i class="material-icons">class</i>
              <span>Enrolled Users</span>
            </a>
          </li>
        </ul>

        <ul class="list" id="menu-users" style="display:none;">
          <!-- User Roles Management (Renamed) -->
          <li class="header">USER ROLES MANAGEMENT</li>

          <!-- Learners -->
          <li class="<?php echo (strstr(uri_string(), 'admin/users')) ? ' active' : ''; ?>">
            <a href="<?php echo site_url('admin/users'); ?>">
              <i class="material-icons">account_circle</i>
              <span>Users</span>
            </a>
          </li>

          <!-- User Roles (Groups) -->
          <li class="<?php echo (strstr(uri_string(), 'admin/groups')) ? ' active' : ''; ?>">
            <a href="<?php echo site_url('/admin/groups'); ?>">
              <i class="material-icons">group_work</i>
              <span>User Roles</span>
            </a>
          </li>

          <!-- Permissions (ACL) -->
          <li class="<?php echo (strstr(uri_string(), 'admin/manageacl')) ? ' active' : ''; ?>">
            <a href="<?php echo site_url('/admin/manageacl'); ?>">
              <i class="material-icons">security</i>
              <span>Permissions</span>
            </a>
          </li>
        </ul>

        <ul class="list" id="menu-cms" style="display:none;">
          <li class="header">CMS</li>
          <li class="<?php echo (strstr(uri_string(), 'admin/contacts')) ? ' active' : ''; ?>">
            <a href="<?php echo site_url('/admin/contacts'); ?>">
              <i class="material-icons">contacts</i>
              <span><?php echo lang('menu_contacts'); ?></span>
            </a>
          </li>
          <li class="<?php echo (strstr(uri_string(), 'admin/testimonials')) ? ' active' : ''; ?>">
            <a href="<?php echo site_url('/admin/testimonials'); ?>">
              <i class="material-icons">insert_comment</i>
              <span><?php echo lang('menu_testimonials'); ?></span>
            </a>
          </li>
          <li class="<?php echo (strstr(uri_string(), 'admin/sliders')) ? ' active' : ''; ?>">
            <a href="<?php echo site_url('/admin/sliders'); ?>">
              <i class="material-icons">view_carousel</i>
              <span>Sliders</span>
            </a>
          </li>
          <li
            class="<?php echo (strstr(uri_string(), 'admin/pages') || strstr(uri_string(), 'admin/menus') || strstr(uri_string(), 'admin/faqs')) ? ' active' : ''; ?>">
            <a href="#" class="menu-toggle">
              <i class="material-icons">developer_board</i>
              <span>Pages & Menus</span>
            </a>
            <ul class="ml-menu">
              <li class="<?php echo (strstr(uri_string(), 'admin/pages')) ? ' active' : ''; ?>">
                <a href="<?php echo site_url('/admin/pages'); ?>">
                  <?php echo lang('menu_pages'); ?>
                </a>
              </li>
              <li class="<?php echo (strstr(uri_string(), 'admin/menus')) ? ' active' : ''; ?>">
                <a href="<?php echo site_url('/admin/menus'); ?>">
                  <?php echo lang('menu_menus'); ?>
                </a>
              </li>
              <li class="<?php echo (strstr(uri_string(), 'admin/faqs')) ? ' active' : ''; ?>">
                <a href="<?php echo site_url('/admin/faqs'); ?>">
                  <?php echo lang('menu_faqs'); ?>
                </a>
              </li>
            </ul>
          </li>
        </ul>

        <ul class="list" id="menu-system" style="display:none;">
          <li class="header">SYSTEM</li>
          <li class="<?php echo (strstr(uri_string(), 'admin/settings')) ? ' active' : ''; ?>">
            <a href="<?php echo site_url('/admin/settings'); ?>">
              <i class="material-icons">settings</i>
              <span><?php echo lang('menu_settings'); ?></span>
            </a>
          </li>
        </ul>
      </div>
      <!-- #Menu -->
      <!-- Footer -->
      <div class="legal">
        <div class="version">
          <?php echo $this->settings->site_name; ?> v<?php echo $this->settings->site_version; ?>
        </div>
        <div class="copyright">&copy; 2019 <a href="https://edwin18g.com">edwin18g</a></div>
      </div>
      <!-- #Footer -->
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

      $('#menu-lms, #menu-users, #menu-cms, #menu-system').hide();
      $('#menu-' + productName).fadeIn(200); // Fade in for smoother transition

      if (typeof (Storage) !== "undefined") {
        localStorage.setItem("activeProduct", productName);
      }
    }

    $(function () {
      try {
        $('[data-toggle="tooltip"]').tooltip();
      } catch (e) { console.log("Tooltip init failed", e); }

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