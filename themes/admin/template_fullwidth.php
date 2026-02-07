<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin Template - Full Width
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

    <title>
        <?php echo $page_title; ?> -
        <?php echo $this->settings->site_name; ?>
    </title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
        type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Modern Admin CSS -->
    <link
        href="<?php echo base_url('themes/admin/css/modern_admin.css'); ?>?v=<?php echo $this->settings->site_version; ?>"
        rel="stylesheet" type="text/css">


    <?php // CSS files ?>
    <?php if (isset($css_files) && is_array($css_files)): ?>
        <?php foreach ($css_files as $css): ?>
            <?php if (!is_null($css)): ?>
                <link rel="stylesheet" href="<?php echo $css; ?>?v=<?php echo $this->settings->site_version; ?>">
                <?php echo "\n"; ?>
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
                <script type="text/javascript"><?php echo "\n" . $js . "\n"; ?></script>
                <?php echo "\n"; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <style>
        .navbar-nav>li>a>i {
            color: #160404 !important;
        }

        /* Full Width Overrides */
        section.content {
            margin-left: 0 !important;
            /* Remove sidebar margin */
        }

        .bars {
            display: none !important;
        }

        /* Hide hamburger */
        .overlay {
            display: none !important;
        }

        /* Back button */
        .back-to-dashboard {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>
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
                <a class="navbar-brand" href="<?php echo site_url('admin/courses'); ?>">
                    <i class="material-icons" style="vertical-align: middle; margin-right: 5px;">chevron_left</i>
                    BACK TO COURSES
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- User Menu -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">account_circle</i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('admin/dashboard'); ?>">
                                    <i class="material-icons">dashboard</i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('logout'); ?>">
                                    <i class="material-icons">input</i>
                                    <?php echo lang('action_logout'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->

    <!-- Content Section (No Sidebar) -->
    <section class="content">
        <div class="container-fluid">

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

</body>

</html>
<?php die(' '); ?>