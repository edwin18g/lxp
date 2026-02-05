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
        line-height: 1.1;
        margin-bottom: 24px;
        color: #1a1a1a;
        letter-spacing: -1.5px;
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
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 40px;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: var(--transition);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    }

    .testimonial-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border-color: var(--coursera-blue);
    }

    .testimonial-text {
        font-size: 1.1rem;
        font-style: italic;
        line-height: 1.7;
        color: var(--text-dark);
        margin-bottom: 30px;
        position: relative;
    }

    .testimonial-text::before {
        content: '"';
        position: absolute;
        top: -20px;
        left: -10px;
        font-size: 4rem;
        color: #e8f0fe;
        font-family: 'Outfit';
        z-index: -1;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        margin-top: auto;
    }

    .author-info h5 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .author-info span {
        font-size: 0.9rem;
        color: var(--text-muted);
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
</style>

<!-- Hero Section -->
<section class="hero-plus">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 margin-top-100">
                <div class="hero-content">
                    <div class="hero-plus-badge">
                        <span>zeyobron</span> <span>analytics</span>
                    </div>
                    <h1>Achieve your career goals with Zeyobron Plus</h1>
                    <p class="subtext">Subscribe to build job-ready skills from world-class institutions.</p>

                    <div class="hero-actions">
                        <a href="<?php echo site_url('courses') ?>" class="btn-plus-trial">Explore courses</a>
                    </div>

                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-plus-image">
                    <div class="blue-fan-bg">
                        <div class="fan-blade fan-blade-1"></div>
                        <div class="fan-blade fan-blade-2"></div>
                        <div class="fan-blade fan-blade-3"></div>
                    </div>
                    <img src="<?php echo base_url('upload/zeyobron_plus_hero_transparent.png') ?>"
                        alt="Big Data Professional">
                </div>
            </div>
        </div>
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
    <section class="section-padding bg-white">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>From the Zeyobron Community</h2>
                <p>100+ million people are already learning with us</p>
            </div>
            <div class="row">
                <?php foreach (array_slice($testimonials, 0, 3) as $key => $val): ?>
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $key * 100; ?>">
                        <div class="testimonial-card-premium">
                            <div class="testimonial-text">
                                <?php echo $val->t_feedback; ?>
                            </div>
                            <div class="testimonial-author">
                                <div class="author-info">
                                    <h5>
                                        <?php echo $val->t_name ?>
                                    </h5>
                                    <span>
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


<!-- CTA Section -->
<section class="section-padding" style="background: var(--coursera-blue); color: #fff; text-align: center;">
    <div class="container" data-aos="zoom-in">
        <h2 style="font-size: 3rem; font-weight: 700; margin-bottom: 24px;">Take the next step toward your goals.</h2>
        <p style="font-size: 1.25rem; margin-bottom: 40px; opacity: 0.9;">Join now to receive personalized
            recommendations from the Zeyobron catalog.</p>
        <a href="<?php echo site_url('courses') ?>" class="btn-primary-coursera"
            style="background: #fff; color: var(--coursera-blue);">Join for Free</a>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initializing AOS is handled in template.php
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