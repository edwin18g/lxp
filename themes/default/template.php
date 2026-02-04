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

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

    <!-- Header Begins -->
    <?php if (!isset($hide_header)): ?>
        <header id="header">
            <div class="container">
                <div class="logo">
                    <a href="<?php echo site_url(''); ?>">
                        <img alt="Logo" width="180" src="<?php echo base_url('upload/institute/logo.png') ?>">
                    </a>
                </div>

                <div class="header-nav-main">
                    <button class="btn btn-responsive-nav" data-toggle="collapse" data-target=".nav-main-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="navbar-collapse nav-main-collapse collapse">
                        <nav class="nav-main mega-menu">
                            <ul class="nav nav-pills nav-main" id="mainMenu">
                                <li><a href="<?php echo site_url('courses'); ?>">
                                        <?php echo lang('menu_courses') ?>
                                    </a></li>
                                <li><a href="<?php echo site_url('contact'); ?>">
                                        <?php echo lang('menu_contact'); ?>
                                    </a></li>
                                <li><a href="<?php echo site_url('cms/about-us'); ?>">About us</a></li>

                                <?php if (!$this->session->userdata('logged_in')): ?>
                                    <li class="nav-auth">
                                        <a href="<?php echo site_url('auth/login') ?>" class="btn-login">
                                            <?php echo lang('action_login'); ?>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="dropdown user-nav">
                                        <a class="dropdown-toggle" href="#">
                                            <i class="fa fa-user-circle"></i>
                                            <?php echo $this->user['first_name']; ?>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo site_url('admin'); ?>">Dashboard</a></li>
                                            <li><a href="<?php echo site_url('courses/my_courses'); ?>">My Learning</a></li>
                                            <li><a href="<?php echo site_url('profile'); ?>">
                                                    <?php echo lang('action_profile'); ?>
                                                </a></li>
                                            <li>
                                                <hr>
                                            </li>
                                            <li><a href="<?php echo site_url('logout'); ?>">
                                                    <?php echo lang('action_logout') ?>
                                                </a></li>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
    <?php endif; ?>



    <!-- Page Header -->
    <?php if (uri_string() !== '') { ?>
        <div class="page-header sm <?php echo isset($this->hide_footer_and_header) ? 'hidden' : ''; ?>">


            <div class="row alert-row">
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
                    <div class="alert-danger alert alert-dismissable" id="validation-error">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p></p>
                    </div>
                    <div class="alert-success alert alert-dismissable" id="validation-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p></p>
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
                        <h5>
                            <?php echo $this->settings->site_name ?>
                        </h5>
                        <p>
                            <?php echo $this->settings->institute_address ?>
                        </p>
                        <div class="footer-contact">
                            <span><i class="fa fa-phone"></i>
                                <?php echo $this->settings->institute_phone; ?>
                            </span>
                            <span><i class="fa fa-envelope"></i>
                                <?php echo $this->settings->site_email; ?>
                            </span>
                        </div>
                    </div>

                    <div class="footer-links">
                        <h6>Quick Links</h6>
                        <ul>
                            <li><a href="<?php echo site_url('courses'); ?>">Courses</a></li>
                            <li><a href="<?php echo site_url('contact'); ?>">Contact</a></li>
                            <li><a href="<?php echo site_url('cms/about-us'); ?>">About Us</a></li>
                        </ul>
                    </div>

                    <div class="footer-social">
                        <h6>Follow Us</h6>
                        <div class="social-icons">
                            <?php if ($this->settings->social_facebook): ?><a
                                    href="<?php echo $this->settings->social_facebook ?>" target="_blank"><i
                                        class="fa fa-facebook"></i></a>
                            <?php endif; ?>
                            <?php if ($this->settings->social_twitter): ?><a
                                    href="<?php echo $this->settings->social_twitter ?>" target="_blank"><i
                                        class="fa fa-twitter"></i></a>
                            <?php endif; ?>
                            <?php if ($this->settings->social_linkedin): ?><a
                                    href="<?php echo $this->settings->social_linkedin ?>" target="_blank"><i
                                        class="fa fa-linkedin"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p>&copy;
                                <?php echo date('Y') ?>
                                <?php echo $this->settings->site_name ?>. All rights reserved.
                            </p>
                        </div>
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
<?php die(' '); ?>