<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Default Public Template -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $page_title; ?> -
        <?php echo $this->settings->site_name; ?>
    </title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo base_url('/upload/institute/logo.png') ?>" />
    <meta name="theme-color" content="#1a237e">

    <!-- Premium Typography Upgrade -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- SEO Meta -->
    <meta name="description" content="<?php echo $this->meta_description; ?>">
    <meta name="keywords" content="<?php echo $this->meta_tags; ?>">

    <?php if (isset($css_files) && is_array($css_files)): ?>
        <?php foreach ($css_files as $css): ?>
            <?php if ($css): ?>
                <link rel="stylesheet" href="<?php echo $css; ?>?v=<?php echo $this->settings->site_version; ?>">
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
        var site_url = "<?php echo site_url(); ?>";
        var csrf_name = "<?php echo $this->security->get_csrf_token_name(); ?>";
        var csrf_token = "<?php echo $this->security->get_csrf_hash(); ?>";
    </script>
</head>

<?php   // RTL or not 
$is_rtl = FALSE;
if (
    stripos($this->config->item('language'), 'Persian') !== FALSE ||
    stripos($this->config->item('language'), 'Hebrew') !== FALSE ||
    stripos($this->config->item('language'), 'Arabic') !== FALSE ||
    stripos($this->config->item('language'), 'Malay') !== FALSE ||
    stripos($this->config->item('language'), 'Uyghur') !== FALSE ||
    stripos($this->config->item('language'), 'Urdu') !== FALSE ||
    stripos($this->config->item('language'), 'Malayalam') !== FALSE
)
    $is_rtl = TRUE;
?>

<body class="one-page sticky-menu-active" data-target=".single-menu" data-spy="scroll" data-offset="200" <?php echo $is_rtl ? 'dir="rtl"' : ''; ?>>

    <!-- Page Loader -->
    <!-- <div id="pageloader">
    <div class="loader-inner">
        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
    </div>
</div> -->
    <!-- Page Loader -->

    <style>
        /* ============================================
           GLOBAL DESIGN SYSTEM
           ============================================ */
        :root {
            /* Legacy compat vars */
            --coursera-blue: #4F46E5;
            --coursera-hover: #4338CA;
            --text-dark: #1F2937;
            --text-muted: #6B7280;
            --border-color: #E5E7EB;
            --shadow: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -1px rgba(0,0,0,0.04);
            --transition: all 0.3s cubic-bezier(0.165,0.84,0.44,1);
            /* Modern palette */
            --lp-primary: #4F46E5;
            --lp-secondary: #7C3AED;
            --lp-accent: #06B6D4;
            --lp-gradient: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #06B6D4 100%);
            --glass-bg: rgba(255,255,255,0.85);
            --glass-border: rgba(255,255,255,0.4);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            background: #fff;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            margin: 0;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* ============================================
           HEADER — GLASSMORPHISM STICKY
           ============================================ */
        #header {
            background: #fff;
            border-bottom: 1px solid rgba(229,231,235,0.9);
            box-shadow: 0 1px 0 rgba(0,0,0,0.04), 0 4px 20px rgba(79,70,229,0.06);
            height: 70px;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 100;
            padding: 0;
            overflow: visible !important;
        }
        /* Ensure header is never taller than 70px even with legacy padding overrides */
        #header > * { flex-shrink: 0; }
        #header .container { width: 100%; min-width: 0; }

        /* Gradient accent line at top of header */
        #header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #4F46E5, #7C3AED, #06B6D4);
        }

        #header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 24px;
            flex-grow: 1;
        }

        .logo img {
            height: 32px;
            width: auto;
            vertical-align: middle;
        }

        .header-links {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .header-links a {
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            padding: 6px 14px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .header-links a:hover {
            background: rgba(79,70,229,0.07);
            color: var(--lp-primary);
        }

        .header-search {
            position: relative;
            flex-grow: 1;
            max-width: 500px;
            display: flex;
            align-items: center;
        }

        .header-search input {
            width: 100%;
            padding: 9px 48px 9px 18px;
            border: 1.5px solid #E5E7EB;
            border-radius: 50px;
            font-size: 13.5px;
            background: #F9FAFB;
            transition: all 0.3s ease;
            outline: none;
            color: var(--text-dark);
        }
        .header-search input:focus {
            border-color: var(--lp-primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .header-search input::placeholder { color: #9CA3AF; }

        .header-search button {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--lp-gradient);
            color: #fff;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 13px;
        }
        .header-search button:hover {
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 4px 12px rgba(79,70,229,0.4);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: 16px;
            flex-shrink: 0;
        }

        .btn-login {
            color: var(--lp-primary) !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            font-size: 14px;
            padding: 7px 16px;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .btn-login:hover { background: rgba(79,70,229,0.07); }

        .btn-join {
            background: var(--lp-gradient);
            color: #fff !important;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none !important;
            font-size: 13.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(79,70,229,0.3);
            border: none;
        }
        .btn-join:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(79,70,229,0.4);
            color: #fff !important;
        }

        .user-nav .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            padding: 5px 12px;
            border-radius: 50px;
            transition: background 0.2s;
            border: 1.5px solid transparent;
        }
        .user-nav .dropdown-toggle:hover {
            background: rgba(79,70,229,0.07);
            border-color: rgba(79,70,229,0.15);
            text-decoration: none;
        }

        .header-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(79,70,229,0.3);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .avatar-placeholder {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4F46E5, #7C3AED);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        /* Dropdown polish */
        .user-nav {
            position: relative;
        }
        .user-nav .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            left: auto;
            z-index: 1050;
            min-width: 200px;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            padding: 8px;
            margin-top: 8px;
            background: #ffffff;
        }
        .user-nav.open .dropdown-menu,
        .user-nav.show .dropdown-menu,
        .user-nav .dropdown-menu.show {
            display: block !important;
        }
        .dropdown-menu > li > a {
            border-radius: 8px;
            padding: 9px 14px;
            font-size: 14px;
            color: var(--text-dark);
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dropdown-menu > li > a:hover {
            background: rgba(79,70,229,0.07);
            color: var(--lp-primary);
        }

        /* Mobile nav hamburger */
        .mobile-toggle {
            display: none;
            background: none;
            border: 1.5px solid #E5E7EB;
            border-radius: 8px;
            padding: 6px 10px;
            cursor: pointer;
            color: var(--text-dark);
            font-size: 16px;
            transition: all 0.2s;
        }
        .mobile-toggle:hover {
            border-color: var(--lp-primary);
            color: var(--lp-primary);
        }

        /* ============================================
           FOOTER — MODERN DARK
           ============================================ */
        .footer-modern {
            background: #0F0C29;
            border-top: 3px solid transparent;
            border-image: linear-gradient(90deg, #4F46E5, #7C3AED, #06B6D4) 1;
            padding: 72px 0 32px;
            color: rgba(255,255,255,0.7);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2.2fr 1fr 1fr;
            gap: 56px;
            margin-bottom: 56px;
        }

        .footer-brand img {
            height: 34px; width: auto;
            margin-bottom: 16px;
            filter: brightness(0) invert(1);
        }
        .footer-brand h5 {
            font-weight: 800;
            color: #fff;
            font-size: 1.2rem;
            margin-bottom: 12px;
        }
        .footer-brand p {
            font-size: 14px;
            line-height: 1.7;
            color: rgba(255,255,255,0.55);
            margin-bottom: 20px;
            max-width: 300px;
        }
        .footer-contact span {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            color: rgba(255,255,255,0.6);
            margin-bottom: 10px;
        }
        .footer-contact i {
            width: 28px; height: 28px;
            background: rgba(79,70,229,0.3);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            color: #a5b4fc;
            font-size: 12px;
            flex-shrink: 0;
        }

        .footer-links h6, .footer-social h6 {
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 2px;
            color: rgba(255,255,255,0.4);
        }

        .footer-links ul {
            list-style: none;
            padding: 0; margin: 0;
        }
        .footer-links li { margin-bottom: 14px; }
        .footer-links a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .footer-links a:hover {
            color: #a5b4fc;
            transform: translateX(4px);
        }

        .social-icons {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .social-icons a {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
        }
        .social-icons a .s-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: rgba(255,255,255,0.08);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            transition: all 0.3s;
        }
        .social-icons a:hover { color: #fff; }
        .social-icons a:hover .s-icon {
            background: linear-gradient(135deg, #4F46E5, #7C3AED);
            transform: scale(1.1);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        .footer-bottom p {
            color: rgba(255,255,255,0.35);
            font-size: 13px;
            margin: 0;
        }
        .footer-bottom-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(79,70,229,0.2);
            border: 1px solid rgba(79,70,229,0.3);
            color: #a5b4fc;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 14px;
            border-radius: 50px;
        }

        /* ============================================
           RESPONSIVE HEADER
           ============================================ */
        @media (max-width: 991px) {
            .header-search { max-width: 300px; }
        }
        @media (max-width: 768px) {
            #header { height: auto; padding: 12px 0; }
            .header-left { gap: 12px; }
            .header-links { display: none; }
            .header-search { display: none; }
            .mobile-toggle { display: flex; }
            .footer-grid { grid-template-columns: 1fr; gap: 36px; }
            .footer-bottom { flex-direction: column; text-align: center; }
        }
        @media (max-width: 480px) {
            .header-right .btn-login { display: none; }
        }

        /* ============================================
           SECTION UTILITY
           ============================================ */
        .section-padding { padding: 80px 0; }
    </style>

    <?php if (!empty($_SESSION['impersonator'])): ?>
    <div style="background: linear-gradient(90deg, #f59e0b, #d97706); color: #ffffff; padding: 10px 24px; font-weight: 600; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 99999; box-shadow: 0 2px 10px rgba(0,0,0,0.15); font-family: 'Plus Jakarta Sans', sans-serif;">
      <div style="display: flex; align-items: center; gap: 10px; font-size: 14px;">
        <i class="fa fa-user-secret" style="font-size: 18px;"></i>
        <span>You are currently logged in as <strong><?php echo isset($_SESSION['logged_in']['first_name']) ? htmlspecialchars($_SESSION['logged_in']['first_name'] . ' ' . $_SESSION['logged_in']['last_name']) : 'User'; ?></strong> (<?php echo isset($_SESSION['logged_in']['email']) ? htmlspecialchars($_SESSION['logged_in']['email']) : ''; ?>)</span>
      </div>
      <div style="display: flex; align-items: center; gap: 10px;">
        <a href="<?php echo site_url('auth/switch_back'); ?>" style="background: #ffffff; color: #b45309; border-radius: 8px; padding: 6px 14px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
          <i class="fa fa-exchange"></i> Switch Back to Admin
        </a>
        <a href="<?php echo site_url('logout'); ?>" style="background: rgba(255,255,255,0.25); color: #ffffff; border: 1px solid rgba(255,255,255,0.4); border-radius: 8px; padding: 6px 14px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fa fa-sign-out"></i> Logout
        </a>
      </div>
    </div>
    <?php endif; ?>

    <!-- Header Begins -->
    <?php if (!isset($hide_header)): ?>
        <header id="header">
            <div class="container">
                <div class="header-left">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="<?php echo site_url(); ?>">
                            <img src="<?php echo base_url('/upload/institute/logo.png') ?>" alt="<?php echo $this->settings->site_name; ?> Logo">
                        </a>
                    </div>

                    <!-- Nav Links -->
                    <nav class="header-links" aria-label="Main navigation">
                        <a href="<?php echo site_url('courses') ?>"><i class="fa fa-graduation-cap"></i> Courses</a>
                        <?php if (!empty($this->settings->events_enabled)): ?>
                        <a href="<?php echo site_url('events') ?>">Events</a>
                        <?php endif; ?>
                        <a href="<?php echo site_url('cms/about-us') ?>">About</a>
                        <a href="<?php echo site_url('contact') ?>">Contact</a>
                    </nav>

                    <!-- Search -->
                    <form class="header-search" action="<?php echo site_url('courses') ?>" method="get" role="search">
                        <input type="text" name="search" placeholder="Search courses..." aria-label="Search courses">
                        <button type="submit" aria-label="Search">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Mobile Toggle -->
                <button class="mobile-toggle" id="mobileMenuToggle" aria-label="Toggle menu" aria-expanded="false">
                    <i class="fa fa-bars"></i>
                </button>

                <div class="header-right">
                    <?php if (!$this->ion_auth->logged_in()): ?>
                        <a href="<?php echo site_url('auth/login') ?>" class="btn-login">Log In</a>
                        <a href="<?php echo site_url('auth/register') ?>" class="btn-join">Get Started</a>
                    <?php else: ?>
                        <div class="dropdown user-nav">
                            <a class="dropdown-toggle" id="userMenu" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" style="cursor: pointer; text-decoration:none; display:flex; align-items:center; gap:10px;">
                                <?php if (!empty($this->session->userdata('logged_in')['image'])): ?>
                                    <img class="header-avatar"
                                        src="<?php echo base_url('upload/users/images/' . $this->session->userdata('logged_in')['image']); ?>"
                                        alt="Profile">
                                <?php else: ?>
                                    <div class="avatar-placeholder">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <?php endif; ?>
                                <span style="font-size:13.5px; font-weight:600; color:var(--text-dark);">
                                    <?php echo $this->session->userdata('logged_in')['username'] ?? ''; ?>
                                </span>
                                <i class="fa fa-chevron-down" style="font-size:10px; color:var(--text-muted);"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
                                <li><a href="<?php echo site_url('profile') ?>"><i class="fa fa-user-circle"></i> My Profile</a></li>
                                <li><a href="<?php echo site_url('my_courses') ?>"><i class="fa fa-book"></i> My Learning</a></li>
                                <li><a href="<?php echo site_url('profile/sessions') ?>"><i class="fa fa-shield"></i> Active Sessions</a></li>
                                <li role="separator" class="divider" style="border-color:#F3F4F6;"></li>
                                <li><a href="<?php echo site_url('auth/logout') ?>" style="color:#EF4444 !important;"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>
    <?php endif; ?>



    <!-- Page Header -->
    <?php if (uri_string() !== '') { ?>
        <div class="alert-container <?php echo isset($this->hide_footer_and_header) ? 'hidden' : ''; ?>"
            style="margin-top: 20px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($this->session->flashdata('message')): ?>
                            <div class="alert-success alert alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $this->session->flashdata('message'); ?>
                            </div>
                        <?php elseif ($this->session->flashdata('error')): ?>
                            <div class="alert-danger alert alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php elseif (validation_errors()): ?>
                            <div class="alert-danger alert alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo validation_errors(); ?>
                            </div>
                        <?php elseif ($this->error): ?>
                            <div class="alert-danger alert alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $this->error; ?>
                            </div>
                        <?php endif; ?>
                        <!-- Ajax validation error -->
                        <div class="alert-danger alert alert-dismissable" id="validation-error" style="display:none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <p></p>
                        </div>
                        <div class="alert-success alert alert-dismissable" id="validation-success" style="display:none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Page Header -->
    <?php } ?>
    <!-- Page Main -->
    <div role="main" class="main">
        <!-- Main Content -->
        <?php echo $content; ?>
        <!-- End Main Content -->
    </div><!-- Page Main -->

    <!-- Footer -->
    <?php if (!isset($hide_header)): ?>
        <footer id="footer" class="footer-modern">
            <div class="container">
                <div class="footer-grid">
                    <!-- Brand Column -->
                    <div class="footer-brand">
                        <img src="<?php echo base_url('/upload/institute/logo.png') ?>" alt="<?php echo $this->settings->site_name; ?>">
                        <h5><?php echo $this->settings->site_name ?></h5>
                        <p><?php echo !empty($this->settings->institute_address) ? $this->settings->institute_address : 'Empowering learners with world-class education and flexible learning paths.'; ?></p>
                        <div class="footer-contact">
                            <?php if (!empty($this->settings->institute_phone)): ?>
                            <span>
                                <i class="fa fa-phone"></i>
                                <?php echo $this->settings->institute_phone; ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!empty($this->settings->site_email)): ?>
                            <span>
                                <i class="fa fa-envelope"></i>
                                <?php echo $this->settings->site_email; ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="footer-links">
                        <h6>Explore</h6>
                        <ul>
                            <li><a href="<?php echo site_url('courses'); ?>"><i class="fa fa-chevron-right" style="font-size:10px;"></i> Browse Courses</a></li>
                            <li><a href="<?php echo site_url('cms/about-us'); ?>"><i class="fa fa-chevron-right" style="font-size:10px;"></i> About Us</a></li>
                            <li><a href="<?php echo site_url('contact'); ?>"><i class="fa fa-chevron-right" style="font-size:10px;"></i> Contact Support</a></li>
                            <li><a href="<?php echo site_url('auth/register'); ?>"><i class="fa fa-chevron-right" style="font-size:10px;"></i> Get Started Free</a></li>
                        </ul>
                    </div>

                    <!-- Social -->
                    <div class="footer-social">
                        <h6>Follow Us</h6>
                        <div class="social-icons">
                            <?php if (!empty($this->settings->social_facebook)): ?>
                            <a href="<?php echo $this->settings->social_facebook ?>" target="_blank" rel="noopener">
                                <span class="s-icon"><i class="fa fa-facebook"></i></span>
                                <span>Facebook</span>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($this->settings->social_twitter)): ?>
                            <a href="<?php echo $this->settings->social_twitter ?>" target="_blank" rel="noopener">
                                <span class="s-icon"><i class="fa fa-twitter"></i></span>
                                <span>Twitter / X</span>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($this->settings->social_linkedin)): ?>
                            <a href="<?php echo $this->settings->social_linkedin ?>" target="_blank" rel="noopener">
                                <span class="s-icon"><i class="fa fa-linkedin"></i></span>
                                <span>LinkedIn</span>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo $this->settings->site_name; ?>. All rights reserved.</p>
                    <div class="footer-bottom-badge">
                        <i class="fa fa-heart" style="color:#F472B6;"></i>
                        Built for Learners
                    </div>
                </div>
            </div>
        </footer>
    <?php endif; ?>
    <!-- Footer -->

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

    <!-- Modal -->
    <div id="secureDevice" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title" id="device-content">Make Sure It's your secure content access device ?
                    </h6>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="success-lab">No</button>
                    <button type="button" class="btn btn-default" id="makeItSecureDevice">Yes! process</button>
                </div>
            </div>

        </div>
    </div>

    <?php
    function rand_chars($c, $l, $u = FALSE)
    {
        if (!$u)
            for ($s = '', $i = 0, $z = strlen($c) - 1; $i < $l; $x = rand(0, $z), $s .= $c[$x], $i++)
                ;
        else
            for ($i = 0, $z = strlen($c) - 1, $s = $c[rand(0, $z)], $i = 1; $i != $l; $x = rand(0, $z), $s .= $c[$x], $s = ($s[$i] == $s[$i - 1] ? substr($s, 0, -1) : $s), $i = strlen($s))
                ;
        return $s;
    }
    ?>
    <script>
        (function() {
            var key = 'zeyo_device_uuid';
            var uuid = localStorage.getItem(key);
            if (!uuid) {
                var match = document.cookie.match(new RegExp('(?:^|; )' + key + '=([^;]+)'));
                if (match) {
                    uuid = decodeURIComponent(match[1]);
                } else {
                    uuid = (typeof crypto !== 'undefined' && crypto.randomUUID) ? crypto.randomUUID() : 'dev_' + Math.random().toString(36).substring(2, 15) + Date.now().toString(36);
                }
                try { localStorage.setItem(key, uuid); } catch(e){}
            }
            document.cookie = key + '=' + encodeURIComponent(uuid) + '; path=/; max-age=315360000; SameSite=Lax';
        })();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ClientJS/0.1.11/client.min.js"></script>
    <script>
        var client = new ClientJS(); // Create A New Client Object
        var fingerprint = client.getFingerprint(); // Get Client's Fingerprint
        console.log(fingerprint);
        fingerprint = btoa(fingerprint); 
    </script>
    <?php if ($this->router->fetch_method() == 'lecture'): ?>


        <script type="text/javascript">
            function postData(url = '', data = '') {
                // Default options are marked with *

                var http = new XMLHttpRequest();

                var params = data;
                http.open('POST', url, true);

                //Send the proper header information along with the request
                http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                http.onreadystatechange = function () {//Call a function when the state changes.
                    if (http.readyState == 4 && http.status == 200) {
                        document.getElementById("lec_content").innerHTML = http.responseText;
                    }
                }
                http.send(params);
            }
            var site_url = "<?php echo site_url(); ?>";
            postData(site_url + 'courses/content_course', 'id=' + uri_seg_3 + '&finger=' + fingerprint + '&' + csrf_name + '=' + csrf_token);

        </script>
    <?php endif; ?>
    <script>
        var base_url = '<?= base_url() ?>';
        var secure_name = '<?= base64_encode('user_sec_id') ?>';
        var secure_val = '<?= base64_encode(rand_chars('securedoggy', 20)) ?>';
        <?php

        if (secure_content()) { ?>
            $(document).ready(function () {
                $('#secureDevice').modal('show');
            });

            $('#makeItSecureDevice').click(function () {
                $(this).text('loading.. please wait');
                if (typeof (Storage) !== "undefined") {


                    $.ajax({
                        url: base_url + "welcome/secure_create/" + fingerprint, type: 'get',
                        success: function (result) {
                            var response = JSON.parse(result);

                            if (response['error'] == false) {
                                localStorage.setItem(secure_name, secure_val);
                                $('#device-content').text('Successfully Activated. This is your secure content accessable device');
                                $('#makeItSecureDevice').remove();
                                $('#success-lab').text('OK');
                            }
                        }
                    });

                } else {
                    // Sorry! No Web Storage support..
                }

            });
        <?php }


        ?>



    </script>







    <!-- Core JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var userMenu = document.getElementById('userMenu');
            if (userMenu) {
                userMenu.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var parent = this.closest('.dropdown');
                    if (parent) {
                        var isOpen = parent.classList.contains('open') || parent.classList.contains('show');
                        if (isOpen) {
                            parent.classList.remove('open', 'show');
                        } else {
                            parent.classList.add('open', 'show');
                        }
                    }
                });

                document.addEventListener('click', function(e) {
                    var parent = userMenu.closest('.dropdown');
                    if (parent && !parent.contains(e.target)) {
                        parent.classList.remove('open', 'show');
                    }
                });
            }
        });
    </script>
</body>

<!-- Load Facebook SDK for JavaScript -->
<?php if ($this->settings->fb_app_id) { ?>
    <div id="fb-root"></div>
    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=" + fb_app_id + "";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));



    </script>
<?php } ?>

</html>