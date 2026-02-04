<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    :root {
        --coursera-blue: #0056d2;
        --coursera-hover: #0041a3;
        --text-dark: #1f1f1f;
        --text-muted: #6a6a6a;
        --bg-light: #f5f7f8;
        --white: #ffffff;
        --border-color: #d1d7dc;
        --border-radius: 8px;
        --transition: all 0.2s ease-in-out;
    }

    body {
        background-color: var(--white);
        font-family: 'Inter', sans-serif;
    }

    /* Course Header Area */
    .course-hero-banner {
        background: #1f1f1f;
        color: #fff;
        padding: 60px 0;
    }

    .course-hero-banner h1 {
        font-weight: 700;
        font-size: 36px;
        margin-bottom: 16px;
    }

    .course-meta-top {
        display: flex;
        gap: 24px;
        font-size: 14px;
        opacity: 0.9;
    }

    .course-meta-top span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Main Content Layout */
    .detail-container {
        padding-top: 40px;
        padding-bottom: 60px;
    }

    .sidebar-card-wrap {
        position: sticky;
        top: 100px;
        z-index: 10;
    }

    .enrollment-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        box-shadow: 0 4px 24px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .card-video-thumb {
        width: 100%;
        height: 180px;
        background: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .card-video-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.7;
    }

    .play-overlay {
        position: absolute;
        font-size: 48px;
        color: #fff;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .play-overlay:hover {
        transform: scale(1.1);
    }

    .card-price-area {
        padding: 24px;
        text-align: center;
    }

    .btn-primary-action {
        display: block;
        width: 100%;
        padding: 14px;
        background: var(--coursera-blue);
        color: #fff !important;
        font-weight: 700;
        border-radius: 4px;
        text-decoration: none;
        margin-bottom: 16px;
        transition: background 0.2s;
    }

    .btn-primary-action:hover {
        background: var(--coursera-hover);
        text-decoration: none;
    }

    /* Tabs & Content */
    .nav-tabs-coursera {
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 32px;
    }

    .nav-tabs-coursera .nav-link {
        border: none;
        color: var(--text-muted);
        font-weight: 600;
        padding: 12px 24px;
        border-bottom: 3px solid transparent;
    }

    .nav-tabs-coursera .nav-link.active {
        color: var(--coursera-blue);
        border-bottom-color: var(--coursera-blue);
        background: none;
    }

    /* Curriculum Accordion */
    .curriculum-section h3 {
        font-weight: 700;
        margin-bottom: 20px;
    }

    .accordion-item-premium {
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        margin-bottom: 12px;
        overflow: hidden;
    }

    .accordion-header-premium {
        background: #fafafa;
        padding: 16px 20px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .accordion-header-premium:hover {
        background: #f0f0f0;
    }

    .accordion-header-premium h5 {
        margin: 0;
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .accordion-content-premium {
        padding: 0;
        display: none;
        border-top: 1px solid var(--border-color);
    }

    .lesson-row {
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        color: var(--text-dark);
        text-decoration: none !important;
        border-bottom: 1px solid #f5f5f5;
    }

    .lesson-row:last-child {
        border-bottom: none;
    }

    .lesson-row:hover {
        background: #fcfcfc;
        color: var(--coursera-blue);
    }

    .lesson-row i {
        color: var(--text-muted);
        width: 16px;
    }

    .accordion-item-premium.completed .accordion-header-premium h5::after {
        content: '\f058';
        font-family: FontAwesome;
        color: #28a745;
        margin-left: 10px;
    }
</style>

<?php 
  $course_image = json_decode($course_detail->images);
  $course_image_url = !empty($course_image) ? base_url('/upload/courses/images/').$course_image[0] : base_url('themes/default/images/course/course-01.jpg');
?>

<div class="course-hero-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1><?php echo $course_detail->title; ?></h1>
                <div class="course-meta-top">
                    <span><i class="fa fa-star text-warning"></i> 4.9 (2.4k ratings)</span>
                    <span><i class="fa fa-globe"></i> English</span>
                    <span>Created by Zeyobron</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container detail-container">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8">
            <ul class="nav nav-tabs nav-tabs-coursera">
                <li class="nav-item"><a class="nav-link active" href="#curriculum">Curriculum</a></li>
                <li class="nav-item"><a class="nav-link" href="#description">Description</a></li>
            </ul>

            <div id="curriculum" class="curriculum-section">
                <h3>Course Content</h3>
                <?php if(!empty($course_lectue)): ?>
                    <div class="accordion-premium">
                        <?php foreach($course_lectue as $lecture): 
                            $url = ($has_entrolled) ? site_url('courses/lecture/'.$lecture['cl_course_id'].'/'.$lecture['id']) : '#';
                            $is_completed = in_array($lecture['id'], $completed_lectures ?? []);
                        ?>
                            <div class="accordion-item-premium <?php echo $is_completed ? 'completed' : ''; ?>">
                                <div class="accordion-header-premium" onclick="$(this).next().slideToggle()">
                                    <h5><?php echo $lecture['cl_name']; ?></h5>
                                    <i class="fa fa-chevron-down text-muted small"></i>
                                </div>
                                <div class="accordion-content-premium">
                                    <a href="<?php echo $url; ?>" class="lesson-row">
                                        <i class="fa fa-play-circle"></i>
                                        <span>Video Lecture</span>
                                        <span class="ml-auto text-muted">Preview</span>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div id="description" class="mt-5">
                <h3>About this course</h3>
                <div class="text-muted" style="line-height: 1.8;">
                    <?php echo $course_detail->description ?? 'No description provided for this course.'; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar Enrollment Card -->
        <div class="col-md-4">
            <div class="sidebar-card-wrap">
                <div class="enrollment-card">
                    <div class="card-video-thumb">
                        <img src="<?php echo $course_image_url; ?>" alt="Preview">
                        <div class="play-overlay"><i class="fa fa-play-circle"></i></div>
                    </div>
                    <div class="card-price-area">
                        <?php if($has_entrolled): ?>
                            <a href="<?php echo site_url('courses/lecture/'.$course_detail->id); ?>" class="btn-primary-action">Resume Learning</a>
                        <?php else: ?>
                            <a href="<?php echo site_url('auth/register'); ?>" class="btn-primary-action">Enroll for Free</a>
                        <?php endif; ?>
                        
                        <div class="text-left mt-3">
                            <p class="small font-weight-bold mb-2">This course includes:</p>
                            <ul class="list-unstyled small text-muted">
                                <li class="mb-2"><i class="fa fa-video-camera mr-2"></i> <?php echo count($course_lectue); ?> modules</li>
                                <li class="mb-2"><i class="fa fa-file-text-o mr-2"></i> Comprehensive reading materials</li>
                                <li><i class="fa fa-infinity mr-2"></i> Full lifetime access</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple tab switching if needed, or rely on URL fragments
    $('.nav-tabs-coursera .nav-link').click(function(e) {
        e.preventDefault();
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
        // Logic to show/hide sections
    });
</script>