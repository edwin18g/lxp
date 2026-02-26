<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- About Us Hero Section -->
<div class="about-hero text-center"
    style="background-image: url('<?php echo (!empty($row->image)) ? base_url('upload/pages/images/' . image_to_large($row->image)) : base_url('themes/default/images/blog/blog-large-01.jpg'); ?>');">
    <div class="overlay"></div>
    <div class="container relative-content">
        <h1 class="display-3 text-white font-weight-bold animate-fade-up">
            <?php echo isset($row->title) ? $row->title : 'About Us'; ?>
        </h1>
        <p class="lead text-white animate-fade-up delay-100">Empowering learning, everywhere.</p>
    </div>
</div>

<!-- Stats Section -->
<div class="section-stats bg-white py-5 shadow-sm relative-overlap">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stat-item animate-pop" data-delay="0">
                    <div class="icon-box mb-3 text-primary"><i class="fa fa-users fa-3x"></i></div>
                    <h2 class="counter font-weight-bold">10k+</h2>
                    <p class="text-muted text-uppercase small ls-1">Happy Students</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stat-item animate-pop" data-delay="100">
                    <div class="icon-box mb-3 text-success"><i class="fa fa-book fa-3x"></i></div>
                    <h2 class="counter font-weight-bold">500+</h2>
                    <p class="text-muted text-uppercase small ls-1">Courses</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stat-item animate-pop" data-delay="200">
                    <div class="icon-box mb-3 text-warning"><i class="fa fa-graduation-cap fa-3x"></i></div>
                    <h2 class="counter font-weight-bold">50+</h2>
                    <p class="text-muted text-uppercase small ls-1">Expert Instructors</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stat-item animate-pop" data-delay="300">
                    <div class="icon-box mb-3 text-danger"><i class="fa fa-globe fa-3x"></i></div>
                    <h2 class="counter font-weight-bold">15+</h2>
                    <p class="text-muted text-uppercase small ls-1">Countries</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Story Section -->
<div class="section-story py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-10 col-md-offset-1 text-center">
                <div class="section-heading mb-5">
                    <h6 class="text-primary font-weight-bold text-uppercase ls-2">Our Story</h6>
                    <h2 class="display-5 font-weight-bold mb-4">Who We Are</h2>
                    <div class="divider mx-auto bg-primary mb-4" style="width: 60px; height: 3px;"></div>
                </div>
                <div class="story-content lead text-muted">
                    <?php echo isset($row->content) ? $row->content : ''; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features / Values Section -->
<div class="section-values bg-light py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-weight-bold">Why Choose Us?</h2>
            <p class="lead text-muted">We provide the best environment for your growth.</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100 shadow-hover border-0 rounded-lg p-4 bg-white text-center">
                    <div class="icon-circle bg-primary-light text-primary mb-4 mx-auto">
                        <i class="fa fa-certificate fa-2x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-3">Certified Content</h4>
                    <p class="text-muted">High-quality content curated by industry experts to ensure you learn the best
                        skills.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100 shadow-hover border-0 rounded-lg p-4 bg-white text-center">
                    <div class="icon-circle bg-success-light text-success mb-4 mx-auto">
                        <i class="fa fa-clock-o fa-2x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-3">Lifetime Access</h4>
                    <p class="text-muted">Learn at your own pace with lifetime access to all your purchased courses.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100 shadow-hover border-0 rounded-lg p-4 bg-white text-center">
                    <div class="icon-circle bg-warning-light text-warning mb-4 mx-auto">
                        <i class="fa fa-users fa-2x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-3">Community Support</h4>
                    <p class="text-muted">Join a vibrant community of learners and mentors to help you succeed.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Team Section (Static/Placeholder for now) -->
<div class="section-team py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-weight-bold">Meet Our Team</h2>
            <p class="lead text-muted">The people behind the mission.</p>
        </div>

        <div class="row">
            <!-- Team Member 1 -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="team-card text-center">
                    <div class="team-img mb-3 overflow-hidden rounded-circle mx-auto shadow-sm"
                        style="width: 150px; height: 150px;">
                        <img src="<?php echo base_url('themes/default/images/avatar/01.jpg'); ?>" alt="Team Member"
                            class="img-fluid w-100 h-100 object-cover"
                            onerror="this.src='https://via.placeholder.com/150'">
                    </div>
                    <h5 class="font-weight-bold mb-1">John Doe</h5>
                    <p class="text-muted small text-uppercase">Founder & CEO</p>
                    <div class="team-social">
                        <a href="#" class="text-muted mr-2"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="text-muted mr-2"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <!-- Team Member 2 -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="team-card text-center">
                    <div class="team-img mb-3 overflow-hidden rounded-circle mx-auto shadow-sm"
                        style="width: 150px; height: 150px;">
                        <img src="<?php echo base_url('themes/default/images/avatar/02.jpg'); ?>" alt="Team Member"
                            class="img-fluid w-100 h-100 object-cover"
                            onerror="this.src='https://via.placeholder.com/150'">
                    </div>
                    <h5 class="font-weight-bold mb-1">Jane Smith</h5>
                    <p class="text-muted small text-uppercase">Head of Content</p>
                    <div class="team-social">
                        <a href="#" class="text-muted mr-2"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="text-muted mr-2"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <!-- Team Member 3 -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="team-card text-center">
                    <div class="team-img mb-3 overflow-hidden rounded-circle mx-auto shadow-sm"
                        style="width: 150px; height: 150px;">
                        <img src="<?php echo base_url('themes/default/images/avatar/03.jpg'); ?>" alt="Team Member"
                            class="img-fluid w-100 h-100 object-cover"
                            onerror="this.src='https://via.placeholder.com/150'">
                    </div>
                    <h5 class="font-weight-bold mb-1">Mike Ross</h5>
                    <p class="text-muted small text-uppercase">Lead Developer</p>
                    <div class="team-social">
                        <a href="#" class="text-muted mr-2"><i class="fa fa-github"></i></a>
                        <a href="#" class="text-muted mr-2"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <!-- Team Member 4 -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="team-card text-center">
                    <div class="team-img mb-3 overflow-hidden rounded-circle mx-auto shadow-sm"
                        style="width: 150px; height: 150px;">
                        <img src="<?php echo base_url('themes/default/images/avatar/04.jpg'); ?>" alt="Team Member"
                            class="img-fluid w-100 h-100 object-cover"
                            onerror="this.src='https://via.placeholder.com/150'">
                    </div>
                    <h5 class="font-weight-bold mb-1">Sarah Connor</h5>
                    <p class="text-muted small text-uppercase">Marketing Director</p>
                    <div class="team-social">
                        <a href="#" class="text-muted mr-2"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="text-muted mr-2"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>