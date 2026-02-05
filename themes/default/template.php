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

    <!-- Premium Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap"
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
        :root {
            --coursera-blue: #0056d2;
            --coursera-hover: #0041a3;
            --text-dark: #1f1f1f;
            --text-muted: #6a6a6a;
            --border-color: #d1d7dc;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);

            /* Premium Palette */
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(255, 255, 255, 0.3);
            --accent-gradient: linear-gradient(135deg, #0056d2 0%, #00a2ff 100%);
            --mesh-gradient: radial-gradient(at 0% 0%, hsla(216, 100%, 95%, 1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(202, 100%, 98%, 1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(190, 100%, 96%, 1) 0, transparent 50%);
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background: #fff;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }

        /* Minimal Header */
        #header {
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow);
            height: 72px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0;
        }

        #header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-grow: 1;
        }

        .header-search {
            position: relative;
            flex-grow: 1;
            max-width: 600px;
            margin-left: 12px;
            display: flex;
            align-items: center;
        }

        .header-search input {
            width: 100%;
            padding: 10px 50px 10px 16px;
            border: 1px solid #747474;
            border-radius: 4px;
            font-size: 14px;
            background: #fff;
            transition: all 0.3s ease;
        }

        .header-search button {
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--coursera-blue);
            color: #fff;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .header-search button:hover {
            background: var(--coursera-hover);
        }

        .nav--main {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 30px;
            width: auto;
            vertical-align: middle;
        }

        .header-links {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-right: 24px;
        }

        .header-links a {
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-login {
            color: var(--coursera-blue);
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-join {
            border: 1px solid var(--coursera-blue);
            color: var(--coursera-blue);
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
        }

        .btn-join:hover {
            background: rgba(0, 86, 210, 0.05);
        }

        .nav-main {
            margin: 0;
        }

        .nav-main>ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        .nav-main>ul>li {
            margin-left: 24px;
        }

        .nav-main>ul>li>a {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-main>ul>li>a:hover {
            color: var(--coursera-blue);
        }

        /* Auth Buttons */
        .btn-login {
            color: var(--coursera-blue) !important;
            font-weight: 600 !important;
        }

        .btn-register-header {
            background: var(--coursera-blue);
            color: #fff !important;
            padding: 8px 20px;
            border-radius: 4px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .btn-register-header:hover {
            background: var(--coursera-hover);
            text-decoration: none;
        }

        .user-nav .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 20px;
            transition: background 0.2s;
        }

        .user-nav .dropdown-toggle:hover {
            background: #f1f3f4;
            text-decoration: none;
        }

        .header-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 0 0 1px var(--border-color);
        }

        .avatar-placeholder {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e8f0fe;
            color: var(--coursera-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        /* Footer Improvements */
        .footer-modern {
            background: #fff;
            border-top: 1px solid var(--border-color);
            padding: 64px 0 32px;
            color: var(--text-dark);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 48px;
        }

        .footer-brand h5 {
            font-weight: 700;
            margin-bottom: 16px;
        }

        .footer-links h6,
        .footer-social h6 {
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 1px;
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
        }

        .footer-links a:hover {
            color: var(--coursera-blue);
            text-decoration: underline;
        }

        .footer-bottom {
            border-top: 1px solid var(--border-color);
            padding-top: 32px;
            text-align: center;
            color: var(--text-muted);
            font-size: 13px;
        }

        .social-icons a {
            color: var(--text-muted);
            font-size: 20px;
            margin-right: 20px;
            transition: color 0.2s;
        }

        .social-icons a:hover {
            color: var(--coursera-blue);
        }

        /* Desktop/Mobile handling */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: #fff;
                position: absolute;
                top: 72px;
                left: 0;
                right: 0;
                padding: 20px;
                box-shadow: var(--shadow);
            }

            .nav-main>ul {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-main>ul>li {
                margin: 10px 0;
            }
        }
    </style>

    <!-- Header Begins -->
    <?php if (!isset($hide_header)): ?>
        <header id="header">
            <div class="container">
                <div class="header-left">
                    <div class="logo">
                        <a href="<?php echo site_url(); ?>">
                            <img src="<?php echo base_url('/upload/institute/logo.png') ?>" alt="Logo">
                        </a>
                    </div>

                    <div class="header-links">
                        <a href="<?php echo site_url('courses') ?>"> Courses </a>

                    </div>

                    <form class="header-search" action="<?php echo site_url('courses') ?>" method="get">
                        <input type="text" name="search" placeholder="What do you want to learn?">
                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>

                <div class="header-right">
                    <?php if (!$this->ion_auth->logged_in()): ?>
                        <a href="<?php echo site_url('auth/login') ?>" class="btn-login">Log In</a>
                        <a href="<?php echo site_url('auth/register') ?>" class="btn-join">Join for Free</a>
                    <?php else: ?>
                        <div class="dropdown">
                            <a class="dropdown-toggle" id="userMenu" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="true" style="cursor: pointer;">
                                <span class="header-username">
                                    <?php echo $this->session->userdata('logged_in')['username']; ?>
                                </span>
                                <?php if (!empty($this->session->userdata('logged_in')['image'])): ?>
                                    <div class="header-avatar">
                                        <img src="<?php echo base_url('upload/users/images/' . $this->session->userdata('logged_in')['image']); ?>"
                                            alt="Profile">
                                    </div>
                                <?php else: ?>
                                    <div class="avatar-placeholder">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
                                <li><a href="<?php echo site_url('profile') ?>"><i class="fa fa-user-circle"></i> Profile</a>
                                </li>
                                <li><a href="<?php echo site_url('my_courses') ?>"><i class="fa fa-book"></i> My Learning</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li><a href="<?php echo site_url('auth/logout') ?>"><i class="fa fa-sign-out"></i> Logout</a>
                                </li>
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
                    <div class="footer-brand">
                        <h5><?php echo $this->settings->site_name ?></h5>
                        <p><?php echo $this->settings->institute_address ?></p>
                        <div class="footer-contact">
                            <span style="display:block; margin-bottom: 8px;"><i class="fa fa-phone"></i>
                                <?php echo $this->settings->institute_phone; ?></span>
                            <span style="display:block;"><i class="fa fa-envelope"></i>
                                <?php echo $this->settings->site_email; ?></span>
                        </div>
                    </div>

                    <div class="footer-links">
                        <h6>Navigation</h6>
                        <ul>
                            <li><a href="<?php echo site_url('courses'); ?>">Browse Courses</a></li>
                            <li><a href="<?php echo site_url('cms/about-us'); ?>">About Zeyobron</a></li>
                            <li><a href="<?php echo site_url('contact'); ?>">Contact Support</a></li>
                        </ul>
                    </div>

                    <div class="footer-social">
                        <h6>Follow Our Journey</h6>
                        <div class="social-icons">
                            <?php if ($this->settings->social_facebook): ?><a
                                    href="<?php echo $this->settings->social_facebook ?>" target="_blank"><i
                                        class="fa fa-facebook"></i></a><?php endif; ?>
                            <?php if ($this->settings->social_twitter): ?><a
                                    href="<?php echo $this->settings->social_twitter ?>" target="_blank"><i
                                        class="fa fa-twitter"></i></a><?php endif; ?>
                            <?php if ($this->settings->social_linkedin): ?><a
                                    href="<?php echo $this->settings->social_linkedin ?>" target="_blank"><i
                                        class="fa fa-linkedin"></i></a><?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p>&copy; <?php echo date('Y') ?>     <?php echo $this->settings->site_name ?>. Empowering learners
                        worldwide.</p>
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
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
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