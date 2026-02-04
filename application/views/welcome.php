<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    .hero-minimal {
        position: relative;
        height: 80vh;
        min-height: 500px;
        background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        overflow: hidden;
    }

    .hero-minimal .container {
        position: relative;
        z-index: 2;
    }

    .hero-minimal h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .hero-minimal p {
        font-size: 1.25rem;
        opacity: 0.9;
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .search-bar-modern {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 0.5rem;
        border-radius: 50px;
        display: flex;
        max-width: 500px;
        margin: 0 auto;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .search-bar-modern input {
        background: none;
        border: none;
        color: #fff;
        padding: 0.75rem 1.5rem;
        flex-grow: 1;
        font-size: 1rem;
    }

    .search-bar-modern input::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .search-bar-modern .btn-search {
        background: #fff;
        color: #1a237e;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .search-bar-modern .btn-search:hover {
        transform: scale(1.05);
        background: #f0f0f0;
    }

    .section-padding {
        padding: 80px 0;
    }

    .course-card-minimal {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        margin-bottom: 30px;
    }

    .course-card-minimal:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .course-card-minimal img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .course-content-minimal {
        padding: 1.5rem;
    }

    .course-content-minimal h4 {
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .course-footer-minimal {
        border-top: 1px solid #f0f0f0;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-enroll-minimal {
        color: #1a237e;
        font-weight: 600;
        font-size: 0.9rem;
    }
</style>

<!-- Hero Section -->
<section class="hero-minimal">
    <div class="container">
        <h1 data-animation="fadeInUp"><?php echo $this->settings->banner_title_1 ?></h1>
        <p data-animation="fadeInUp" data-delay="600"><?php echo $this->settings->banner_description_1 ?></p>
        <div class="search-bar-modern" data-animation="fadeInUp" data-delay="1000">
            <input type="text" placeholder="Search for courses..." id="course-search">
            <button class="btn-search">Search</button>
        </div>
    </div>
</section>

<!-- Featured Courses -->
<?php if (!empty($f_courses)): ?>
    <section class="section-padding bg-light">
        <div class="container text-center">
            <div class="title-wrap margin-bottom-50">
                <h2 class="title"><?php echo lang('w_featured_courses') ?></h2>
                <p>Explore our most popular learning paths</p>
            </div>

            <div class="row">
                <?php foreach ($f_courses as $val):
                    $course_url = site_url('courses/detail/') . str_replace(' ', '+', $val->title);
                    if ($this->session->userdata('logged_in') && in_array($val->id, $my_courses)) {
                        $course_url = site_url('courses/lecture/' . $val->id);
                    }
                    ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="course-card-minimal">
                            <a href="<?php echo $course_url; ?>">
                                <img src="<?php echo base_url() . ($val->images ? '/upload/courses/images/' . image_to_thumb(json_decode($val->images)[0]) : 'themes/default/images/course/course-01.jpg') ?>"
                                    alt="<?php echo $val->title ?>">
                            </a>
                            <div class="course-content-minimal text-left">
                                <h4><a href="<?php echo $course_url; ?>"><?php echo $val->title ?></a></h4>
                            </div>
                            <div class="course-footer-minimal">
                                <a href="<?php echo $course_url; ?>" class="btn-enroll-minimal">View Course <i
                                        class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Testimonials (Simplified) -->
<?php if (!empty($testimonials)): ?>
    <section class="section-padding bg-white">
        <div class="container text-center">
            <h2 class="margin-bottom-50">What Our Learners Say</h2>
            <div class="row">
                <?php foreach (array_slice($testimonials, 0, 3) as $val): ?>
                    <div class="col-md-4">
                        <div class="testimonial-minimal">
                            <p class="text-italic">"<?php echo $val->t_feedback; ?>"</p>
                            <div class="margin-top-20">
                                <strong><?php echo $val->t_name ?></strong>
                                <span class="block text-muted small"><?php echo $val->t_type ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Contact Section (Minimal) -->
<section class="section-padding bg-dark color-light text-center">
    <div class="container">
        <h2>Ready to start?</h2>
        <p class="margin-bottom-30">Get in touch for personalized learning solutions.</p>
        <a href="<?php echo site_url('contact') ?>" class="btn-search"
            style="display:inline-block; text-decoration:none;">Contact Us</a>
    </div>
</section>