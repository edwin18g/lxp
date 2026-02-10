<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    /* Hero Section - Premium Polish */
    .hero-plus {
        padding: 0 0;
        background: linear-gradient(180deg, #f0f6ff 0%, #e6f0fa 100%);
        /* Subtle gradient */
        position: relative;
        overflow: hidden;
        /* To contain the shapes */
    }

    /* Background Shapes */
    .hero-bg-shapes {
        position: absolute;
        top: 50%;
        right: -100px;
        transform: translateY(-50%);
        width: 600px;
        height: 600px;
        z-index: 1;
        pointer-events: none;
    }

    .shape-fan-1,
    .shape-fan-2,
    .shape-fan-3 {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        transform-origin: bottom left;
    }

    .shape-fan-1 {
        background: transparent;
        border: 2px solid #0056d2;
        /* Darker blue outline */
        transform: rotate(-15deg) scale(0.9);
        opacity: 0.3;
    }

    .shape-fan-2 {
        background: #1f6ce6;
        /* Mid blue */
        transform: rotate(15deg) scale(0.95);
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        /* Quarter circle approx */
        z-index: 1;
    }

    .shape-fan-3 {
        background: #0056d2;
        /* Dark blue */
        transform: rotate(45deg);
        z-index: 0;
        clip-path: circle(50% at 0 100%);
    }

    /* Simple blue arc approximation */
    .blue-fan-bg {
        position: absolute;
        right: -5%;
        top: 10%;
        width: 600px;
        height: 600px;
        z-index: 1;
        filter: drop-shadow(0 20px 40px rgba(0, 86, 210, 0.1));
        /* Soft shadow for depth */
        animation: float-delayed 8s ease-in-out infinite;
    }

    .fan-blade {
        position: absolute;
        bottom: 50px;
        left: 50px;
        width: 400px;
        height: 600px;
        transform-origin: bottom left;
        border-radius: 0 400px 0 0;
        box-shadow: -10px 0 20px rgba(0, 0, 0, 0.05);
        /* Separation between blades */
    }

    .fan-blade-1 {
        background: linear-gradient(135deg, #3c82e6 0%, #2b6cb0 100%);
        transform: rotate(-20deg);
        z-index: 1;
    }

    .fan-blade-2 {
        background: linear-gradient(135deg, #1f6ce6 0%, #0056d2 100%);
        transform: rotate(0deg);
        z-index: 2;
    }

    .fan-blade-3 {
        background: linear-gradient(135deg, #0056d2 0%, #003c8f 100%);
        transform: rotate(20deg);
        z-index: 3;
    }

    /* Animations */
    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    @keyframes float-delayed {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-15px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-content {
        animation: fadeInUp 0.8s ease-out;
        position: relative;
        z-index: 10;
    }

    .hero-plus-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
    }

    .hero-plus-badge span:first-child {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--coursera-blue);
        letter-spacing: -1px;
    }

    .hero-plus-badge span:last-child {
        background: linear-gradient(90deg, #0056d2, #1f6ce6);
        color: #fff;
        padding: 4px 12px;
        border-radius: 4px;
        font-weight: 800;
        font-size: 0.9rem;
        box-shadow: 0 4px 10px rgba(0, 86, 210, 0.2);
    }

    .hero-plus h1 {
        font-size: 4rem;
        font-weight: 800;
        line-height: 1.05;
        margin-bottom: 24px;
        color: #1a1a1a;
        letter-spacing: -0.04em;
    }

    .hero-plus .subtext {
        font-size: 1.25rem;
        color: #404040;
        margin-bottom: 12px;
        font-weight: 500;
    }

    .hero-plus .price {
        font-size: 1.1rem;
        color: #404040;
        margin-bottom: 40px;
    }

    .btn-plus-trial {
        display: inline-block;
        background: linear-gradient(90deg, #0056d2, #1f6ce6);
        color: #fff;
        padding: 18px 40px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 1.1rem;
        text-decoration: none;
        margin-bottom: 24px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0, 86, 210, 0.2);
    }

    .btn-plus-trial:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0, 86, 210, 0.3);
        color: #fff;
    }

    .hero-plus .guarantee {
        font-size: 0.95rem;
        color: var(--coursera-blue);
        font-weight: 600;
        opacity: 0.9;
    }

    .hero-plus-image {
        position: relative;
    }

    .hero-plus-image img {
        width: 100%;
        position: relative;
        z-index: 2;
        /* Floating animation for the person */
        animation: float 6s ease-in-out infinite;
        filter: drop-shadow(0 20px 40px rgba(0, 86, 210, 0.15));
    }

    /* Partners Section - Exact */
    .partners-section {
        padding: 60px 0;
        border-bottom: 1px solid #ebedef;
    }

    .partners-section h2 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 48px;
    }

    .partner-logos-exact {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 40px;
        flex-wrap: wrap;
    }

    .partner-logos-exact img {
        max-height: 40px;
        filter: grayscale(100%);
        opacity: 0.8;
        transition: var(--transition);
    }

    .partner-logos-exact img:hover {
        filter: grayscale(0%);
        opacity: 1;
    }

    /* Invest Section - Exact */
    .invest-section {
        padding: 80px 0;
        background: #f5f7f8;
    }

    .invest-section h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 60px;
    }

    .benefit-item {
        text-align: left;
    }

    .benefit-item .icon {
        font-size: 2rem;
        color: var(--text-dark);
        margin-bottom: 24px;
    }

    .benefit-item h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .benefit-item p {
        font-size: 0.95rem;
        color: #404040;
        line-height: 1.5;
    }

    /* Course Grid Polish */
    .course-grid-modern {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 24px;
        margin-top: 40px;
    }

    .course-card-premium {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .course-card-premium:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
        border-color: var(--coursera-blue);
    }

    .card-banner-wrap {
        position: relative;
        height: 180px;
        overflow: hidden;
    }

    .card-banner-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .course-card-premium:hover .card-banner-wrap img {
        transform: scale(1.1);
    }

    .card-content {
        padding: 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .category-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--coursera-blue);
        text-transform: uppercase;
        margin-bottom: 12px;
        letter-spacing: 1px;
        display: inline-block;
        padding: 4px 12px;
        background: #e8f0fe;
        border-radius: 50px;
        width: fit-content;
    }

    .course-title-premium {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 16px;
        line-height: 1.4;
        color: var(--text-dark);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .instructor-meta {
        margin-top: auto;
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        color: var(--text-muted);
        padding-top: 16px;
        border-top: 1px solid #f0f0f0;
    }

    .instructor-meta img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-right: 12px;
        object-fit: cover;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Testimonials Redesign */
    .testimonial-card-premium {
        background: rgba(20, 20, 20, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 40px 30px;
        height: auto;
        min-height: 250px;
        display: flex;
        flex-direction: column;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        position: relative;
        margin-bottom: 60px;
        /* Space for overlapping profile */
    }

    .testimonial-card-premium:hover {
        transform: translateY(-10px) scale(1.02);
        background: rgba(32, 32, 32, 0.85);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
    }

    .testimonial-text {
        font-size: 1.1rem;
        font-style: italic;
        line-height: 1.7;
        color: #fff;
        margin-bottom: 25px;
        position: relative;
        font-weight: 500;
        z-index: 1;
    }

    .testimonial-text::before {
        content: '\201C';
        position: absolute;
        top: -40px;
        left: -20px;
        font-size: 6rem;
        color: rgba(255, 255, 255, 0.08);
        font-family: 'Plus Jakarta Sans', sans-serif;
        z-index: -1;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        position: absolute;
        bottom: -45px;
        left: 0px;
        z-index: 10;
        width: 100%;
        padding-left: 20px;
    }

    .testimonial-author img {
        width: 85px;
        height: 85px;
        border-radius: 50%;
        border: 6px solid #fff;
        margin-right: 15px;
        object-fit: cover;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        background: #fff;
        flex-shrink: 0;
        transition: transform 0.4s ease;
    }

    .testimonial-card-premium:hover .testimonial-author img {
        transform: scale(1.1) rotate(5deg);
    }

    .author-info h5 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
        /* Default dark for outside card */
        display: inline-block;
        letter-spacing: -0.02em;
    }

    .author-info span {
        font-size: 0.95rem;
        font-weight: 600;
        color: #666;
        margin-left: 5px;
    }

    /* When inside section with dark overlay background like image */
    .testimonial-section-dark {
        background-color: #0c1421;
        background-image: linear-gradient(rgba(12, 20, 33, 0.85), rgba(12, 20, 33, 0.85)), url('<?php echo base_url('upload/home/banner_image_3.jpg'); ?>');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    .testimonial-author .author-info h5 {
        color: #fff;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .testimonial-author .author-info span {
        color: rgba(255, 255, 255, 0.8);
    }

    .section-accent-badge {
        display: inline-block;
        font-size: 0.8rem;
        font-weight: 800;
        color: var(--coursera-blue);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 12px;
        padding: 4px 16px;
        background: rgba(0, 86, 210, 0.1);
        border-radius: 50px;
    }

    .testimonial-section-dark .section-accent-badge {
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
    }

    /* SVG Wave Divider */
    .section-divider-wave {
        width: 100%;
        height: 80px;
        margin-top: -1px;
        display: block;
    }

    .wave-fill {
        fill: #f5f7f8;
    }

    /* Value Prop Section */
    .value-prop {
        padding: 100px 0;
        background: #fff;
    }

    .vp-item {
        margin-bottom: 50px;
        display: flex;
        gap: 20px;
    }

    .vp-item i {
        font-size: 2.2rem;
        color: var(--coursera-blue);
        flex-shrink: 0;
    }

    .vp-item h4 {
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 1.3rem;
    }

    .vp-item p {
        color: var(--text-muted);
        line-height: 1.6;
    }

    /* Skills Cloud */
    .skills-cloud {
        padding: 40px 0;
        text-align: center;
    }

    .skill-tag {
        display: inline-block;
        padding: 10px 24px;
        background: #f5f7f8;
        border-radius: 50px;
        margin: 10px;
        font-size: 1rem;
        font-weight: 500;
        color: var(--text-dark);
        transition: var(--transition);
        border: 1px solid #ebebeb;
    }

    .skill-tag:hover {
        background: #fff;
        border-color: var(--coursera-blue);
        color: var(--coursera-blue);
        transform: translateY(-3px);
    }

    /* Hero Slider Navigation */
    .hero-slider .owl-dots {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 12px;
        z-index: 20;
    }

    .hero-slider .owl-dot {
        width: 12px;
        height: 12px;
        background: rgba(0, 86, 210, 0.2) !important;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .hero-slider .owl-dot.active {
        background: var(--coursera-blue) !important;
        transform: scale(1.2);
    }

    .hero-slider-item {
        padding: 60px 0;
        min-height: 450px;
        display: flex;
        align-items: center;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    /* Full Width Slider */
    .hero-slider {
        width: 100%;
        overflow: hidden;
    }

    /* Blue Overlay */
    .hero-slider-item {
        position: relative;
    }

    .hero-slider-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(5, 35, 77, 0.8) 0%, rgba(2, 12, 27, 0.9) 100%);
        z-index: 1;
    }

    .hero-slider-item>.container {
        position: relative;
        z-index: 2;
    }

    /* Fix for preventDefault console intervention */
    .hero-slider {
        touch-action: pan-y;
        -webkit-user-drag: none;
    }


    /* Hero Text Content & Typography */
    /* Staggered Animations */
    .hero-slider .owl-item.active .hero-plus-badge {
        animation: fadeInUp 0.8s ease-out 0.2s both;
    }

    .hero-slider .owl-item.active .hero-text-content h1 {
        animation: fadeInUp 0.8s ease-out 0.4s both;
    }

    .hero-slider .owl-item.active .hero-text-content .subtext {
        animation: fadeInUp 0.8s ease-out 0.6s both;
    }

    .hero-slider .owl-item.active .hero-actions {
        animation: fadeInUp 0.8s ease-out 0.8s both;
    }

    .hero-text-content h1 {
        font-size: 4.5rem;
        font-weight: 800;
        color: #fff !important;
        margin-bottom: 24px;
        line-height: 1;
        text-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        letter-spacing: -0.05em;
    }

    .hero-text-content .subtext {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 500;
        margin-bottom: 30px;
        text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
    }

    .hero-text-content .hero-plus-badge span:first-child {
        color: #fff !important;
        /* Make site name white */
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .hero-text-content .hero-plus-badge span:last-child {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #fff;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    /* Button Polish */
    .hero-text-content .btn-plus-trial {
        background: #fff;
        color: #0056d2;
        font-weight: 800;
        padding: 18px 50px;
        border-radius: 60px;
        /* Pill shape */
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid transparent;
    }

    .hero-text-content .btn-plus-trial:hover {
        transform: translateY(-6px) scale(1.05);
        box-shadow: 0 20px 45px rgba(0, 86, 210, 0.4);
        background: #0056d2;
        color: #fff;
        border-color: #fff;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .hero-text-content h1 {
            font-size: 2rem;
        }

        .hero-text-content .subtext {
            font-size: 1rem;
        }

        .hero-slider-item {
            min-height: 400px;
            /* Slightly shorter on mobile */
        }
    }

    /* WhatsApp Style Progress Bars */
    .slider-progress-container {
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        width: 90%;
        max-width: 600px;
        z-index: 20;
    }

    .progress-bar-item {
        flex: 1;
        height: 4px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
        overflow: hidden;
        position: relative;
    }

    .progress-bar-item .bar-fill {
        display: block;
        height: 100%;
        background: #fff;
        width: 0;
        transition: width 0.1s linear;
    }

    .progress-bar-item.active .bar-fill {
        width: 0;
        /* JS will animate this */
    }

    .progress-bar-item.completed .bar-fill {
        width: 100%;
    }
</style>

<!-- Hero Slider Section -->
<section class="hero-plus" style="position: relative;">
    <!-- Progress Bars Container -->
    <div class="slider-progress-container" id="sliderProgressContainer">
        <!-- Bars will be injected by JS -->
    </div>

    <div class="hero-slider owl-theme">
        <?php if (!empty($sliders)): ?>
            <?php foreach ($sliders as $slider): ?>
                <div class="item hero-slider-item"
                    style="background-image: url('<?php echo (!empty($slider->image)) ? base_url('upload/sliders/images/' . $slider->image) : base_url('themes/default/images/zeyobron_plus_hero_transparent.png'); ?>');">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-8 mx-auto text-center hero-text-content">
                                <div class="hero-content">
                                    <div class="hero-plus-badge justify-content-center">
                                        <span><?php echo $this->settings->site_name; ?></span>
                                        <span><?php echo $slider->title; ?></span>
                                    </div>
                                    <h1 class="text-center"><?php echo $slider->subtitle; ?></h1>

                                    <div class="hero-actions text-center">
                                        <a href="<?php echo $slider->button_link; ?>" class="btn-plus-trial">
                                            <?php echo $slider->button_text; ?>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback Static Slide if no dynamic sliders found -->
            <div class="item hero-slider-item"
                style="background-image: url('<?php echo base_url('themes/default/images/zeyobron_plus_hero_transparent.png'); ?>');">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8 mx-auto text-center hero-text-content">
                            <div class="hero-content">
                                <div class="hero-plus-badge justify-content-center">
                                    <span>zeyobron</span> <span>analytics</span>
                                </div>
                                <h1 class="text-center">Achieve your career goals with Zeyobron Plus</h1>
                                <p class="subtext text-center">Subscribe to build job-ready skills from world-class
                                    institutions.</p>

                                <div class="hero-actions text-center">
                                    <a href="<?php echo site_url('courses') ?>" class="btn-plus-trial">Explore courses</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>


<!-- Featured Courses -->
<?php if (!empty($f_courses)): ?>
    <section class="section-padding" style="background: #f5f7f8;">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Explore Featured Courses</h2>
                <p>Over 5,000 courses from leading experts</p>
            </div>

            <div class="course-grid-modern">
                <?php foreach (array_slice($f_courses, 0, 8) as $key => $val):
                    $course_url = site_url('courses/detail/') . str_replace(' ', '+', $val->title);
                    ?>
                    <div data-aos="fade-up" data-aos-delay="<?php echo ($key % 4) * 100; ?>">
                        <a href="<?php echo $course_url; ?>" class="course-card-premium">
                            <div class="card-banner-wrap">
                                <img src="<?php echo base_url() . ($val->images ? '/upload/courses/images/' . image_to_thumb(json_decode($val->images)[0]) : 'upload/default_course_banner.png') ?>"
                                    alt="<?php echo $val->title ?>">
                            </div>
                            <div class="card-content">
                                <div class="category-label">Professional Certificate</div>
                                <h4 class="course-title-premium">
                                    <?php echo $val->title ?>
                                </h4>
                                <div class="instructor-meta">
                                    <img src="<?php echo base_url('upload/expert_mentor_avatar.png'); ?>" alt="Instructor">
                                    <span>Expert Mentor</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="<?php echo site_url('courses') ?>" class="btn-primary-coursera"
                    style="background: none; border: 1px solid var(--coursera-blue); color: var(--coursera-blue);">View All
                    Courses</a>
            </div>
        </div>
    </section>
<?php endif; ?>


<!-- Testimonials -->
<?php if (!empty($testimonials)): ?>
    <section class="section-padding testimonial-section-dark" style="position: relative; padding-top: 100px;">
        <!-- Wave Transition -->
        <svg class="section-divider-wave" style="position: absolute; top: 0; left: 0;" viewBox="0 0 1440 320"
            preserveAspectRatio="none">
            <path class="wave-fill"
                d="M0,160L80,176C160,192,320,224,480,213.3C640,203,800,149,960,128C1120,107,1280,117,1360,122.7L1440,128L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z">
            </path>
        </svg>
        <div class="container">
            <div class="section-title text-center mb-5" data-aos="fade-up">
                <span class="section-accent-badge">Customer Stories</span>
                <h2 style="color: #fff;">From the Zeyobron Community</h2>
                <p style="color: rgba(255, 255, 255, 0.8);">100+ million people are already learning with us</p>
            </div>
            <div class="row">
                <?php foreach (array_slice($testimonials, 0, 3) as $key => $val): ?>
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $key * 100; ?>">
                        <div class="testimonial-card-premium">
                            <div class="testimonial-text">
                                <?php echo $val->t_feedback; ?>
                            </div>
                            <div class="testimonial-author">
                                <img src="<?php echo base_url('upload/testimonials/images/' . ($val->image ? $val->image : 'default_avatar.png')) ?>"
                                    alt="<?php echo $val->t_name ?>"
                                    onerror="this.src='<?php echo base_url('upload/expert_mentor_avatar.png'); ?>'">
                                <div class="author-info">
                                    <h5>
                                        <?php echo $val->t_name ?>
                                    </h5>
                                    <span> /
                                        <?php echo $val->t_type ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Hero Slider (Owl 1.x compatibility)
        var time = 5000;
        var $heroSlider = $('.hero-slider');
        var $progressBarContainer = $('#sliderProgressContainer');

        $heroSlider.owlCarousel({
            singleItem: true,
            autoPlay: time,
            stopOnHover: true,
            navigation: false,
            pagination: false,
            slideSpeed: 800,
            paginationSpeed: 800,
            rewindSpeed: 1000,
            afterInit: function () {
                initProgressBars(this);
            },
            afterMove: function () {
                updateProgressBars(this);
            },
            afterAction: function () {
                // Ensure bars are initialized if afterInit was missed
                if ($progressBarContainer.children().length === 0) {
                    initProgressBars(this);
                }
            }
        });

        // Explicit call in case afterInit didn't fire due to already being initialized
        var owlInstance = $heroSlider.data('owlCarousel');
        if (owlInstance && $progressBarContainer.children().length === 0) {
            initProgressBars(owlInstance);
        }

        function initProgressBars(owl) {
            $progressBarContainer.html('');
            // Use $owlItems as it's the primary storage for items in Owl 1.x
            var $items = owl.$owlItems || (owl.owl && owl.owl.owlItems);
            if (!$items) return;

            var itemsCount = $items.length;
            for (var i = 0; i < itemsCount; i++) {
                var $barItem = $('<div class="progress-bar-item"><span class="bar-fill"></span></div>');
                $progressBarContainer.append($barItem);
            }
            updateProgressBars(owl);
        }

        function updateProgressBars(owl) {
            var current = owl.currentItem;
            var $items = owl.$owlItems || (owl.owl && owl.owl.owlItems);
            if (!$items) return;

            var itemsCount = $items.length;

            $progressBarContainer.find('.progress-bar-item').each(function (index) {
                var $bar = $(this);
                var $fill = $bar.find('.bar-fill');

                $fill.stop(true, true);
                $bar.removeClass('active completed');

                if (index < current) {
                    $bar.addClass('completed');
                    $fill.css('width', '100%');
                } else if (index === current) {
                    $bar.addClass('active');
                    $fill.css('width', '0').animate({
                        width: '100%'
                    }, time, 'linear');
                } else {
                    $fill.css('width', '0');
                }
            });
        }

        // Handle Hover Pause for Progress Bar Animation
        $heroSlider.on('mouseover', function () {
            var $activeFill = $progressBarContainer.find('.active .bar-fill');
            $activeFill.stop(true, false);
        });

        $heroSlider.on('mouseout', function () {
            var $activeFill = $progressBarContainer.find('.active .bar-fill');
            var currentWidth = $activeFill.width();
            var totalWidth = $activeFill.parent().width();
            var remainingTime = time * (1 - (currentWidth / totalWidth));

            $activeFill.animate({
                width: '100%'
            }, remainingTime, 'linear');
        });
    });
</script>

<?php
$CI =& get_instance();
$settings = $CI->settings;
if (isset($settings->promo_modal_enabled) && $settings->promo_modal_enabled == 1):
    ?>
    <!-- Promotion Modal -->
    <div id="promoModal" class="modal fade" role="dialog" style="z-index: 100000;">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header relative">
                    <button type="button" class="close" data-dismiss="modal" onclick="dismissPromo()"
                        style="position: absolute; right: 20px; top: 15px; font-size: 28px; z-index: 10;">&times;</button>
                    <h4 class="modal-title text-center font-weight-bold" style="padding-top: 10px; color: #333;">
                        <?php echo isset($settings->promo_modal_title) ? $settings->promo_modal_title : 'Special Offer'; ?>
                    </h4>
                </div>
                <div class="modal-body text-center" style="padding: 20px 30px;">
                    <?php if (isset($settings->promo_modal_image) && !empty($settings->promo_modal_image)): ?>
                        <img src="<?php echo base_url('upload/home/' . $settings->promo_modal_image); ?>"
                            class="img-responsive center-block"
                            style="margin-bottom: 20px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%;">
                    <?php endif; ?>
                    <p style="font-size: 16px; color: #555; line-height: 1.6; margin-bottom: 10px;">
                        <?php echo isset($settings->promo_modal_content) ? nl2br($settings->promo_modal_content) : ''; ?>
                    </p>
                </div>
                <div class="modal-footer text-center" style="text-align: center; border-top: none; padding-bottom: 35px;">
                    <?php if (isset($settings->promo_modal_btn_text) && !empty($settings->promo_modal_btn_text)): ?>
                        <a href="<?php echo isset($settings->promo_modal_btn_url) ? $settings->promo_modal_btn_url : '#'; ?>"
                            class="btn btn-promo" onclick="dismissPromo()">
                            <?php echo $settings->promo_modal_btn_text; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <style>
        #promoModal .modal-content {
            border-radius: 16px;
            overflow: hidden;
            border: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .btn-promo {
            background: linear-gradient(90deg, #0056d2, #1f6ce6);
            color: white !important;
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 16px;
            border: none;
            box-shadow: 0 4px 14px 0 rgba(0, 118, 255, 0.39);
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-promo:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 118, 255, 0.23);
            color: white;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Wait for jQuery
            var checkJqueryPromise = new Promise(function (resolve, reject) {
                var count = 0;
                var checkJquery = setInterval(function () {
                    if (window.jQuery) {
                        clearInterval(checkJquery);
                        resolve();
                    }
                    if (count > 100) { // Timeout 10s
                        clearInterval(checkJquery);
                        resolve(); // Try anyway
                    }
                    count++;
                }, 100);
            });

            checkJqueryPromise.then(function () {
                var storageKey = 'promo_modal_dismissed_<?php echo md5(isset($settings->promo_modal_title) ? $settings->promo_modal_title : ""); ?>';

                // Show modal if not dismissed
                if (!localStorage.getItem(storageKey)) {
                    setTimeout(function () {
                        jQuery('#promoModal').modal('show');
                    }, 2000);
                }

                window.dismissPromo = function () {
                    localStorage.setItem(storageKey, 'true');
                };
            });
        });
    </script>
<?php endif; ?>