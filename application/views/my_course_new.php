<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    :root {
        --coursera-blue: #0056d2;
        --coursera-hover: #0041a3;
        --bg-light: #f5f7f8;
        --text-dark: #1f1f1f;
        --text-muted: #6a6a6a;
        --white: #ffffff;
        --border-radius: 8px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    /* Hero Section */
    .dashboard-hero {
        background: var(--white);
        padding: 48px 0;
        border-bottom: 1px solid #d1d7dc;
        margin-bottom: 40px;
    }

    .dashboard-hero h2 {
        font-weight: 700;
        font-size: 32px;
        margin-bottom: 8px;
        color: var(--text-dark);
    }

    .dashboard-hero p {
        font-size: 16px;
        color: var(--text-muted);
    }

    /* Section Headers */
    .section-title-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    /* Course Cards */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 48px;
    }

    .learning-card {
        background: var(--white);
        border-radius: var(--border-radius);
        overflow: hidden;
        border: 1px solid #d1d7dc;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .learning-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        border-color: rgba(0, 86, 210, 0.3);
    }

    .card-banner {
        width: 100%;
        height: 160px;
        overflow: hidden;
        position: relative;
        background: #eef0f2;
    }

    .card-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .learning-card:hover .card-banner img {
        transform: scale(1.05);
    }

    .card-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .course-category {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--coursera-blue);
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .course-name {
        font-size: 16px;
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 12px;
        color: var(--text-dark);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 44px;
    }

    .instructor-info {
        display: flex;
        align-items: center;
        margin-bottom: 16px;
    }

    .instructor-info img {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .instructor-info span {
        font-size: 13px;
        color: var(--text-muted);
    }

    .progress-minimal {
        height: 4px;
        background: #eef0f2;
        border-radius: 2px;
        margin-bottom: 16px;
        overflow: hidden;
    }

    .progress-bar-minimal {
        height: 100%;
        background: var(--coursera-blue);
        width: 0;
        /* Updated dynamically or placeholder */
    }

    .card-actions {
        margin-top: auto;
    }

    .btn-dashboard {
        display: block;
        width: 100%;
        padding: 10px;
        text-align: center;
        background: var(--coursera-blue);
        color: var(--white);
        border-radius: 4px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-dashboard:hover {
        background: var(--coursera-hover);
        color: var(--white);
        text-decoration: none;
    }

    .btn-outline-dashboard {
        display: block;
        width: 100%;
        padding: 10px;
        text-align: center;
        border: 1px solid var(--coursera-blue);
        color: var(--coursera-blue);
        border-radius: 4px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: var(--transition);
        margin-top: 8px;
    }

    .btn-outline-dashboard:hover {
        background: rgba(0, 86, 210, 0.04);
        text-decoration: none;
        color: var(--coursera-blue);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: var(--white);
        border-radius: var(--border-radius);
        border: 1px dashed #d1d7dc;
    }

    .empty-state i {
        font-size: 48px;
        color: #d1d7dc;
        margin-bottom: 16px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-hero {
            padding: 32px 0;
            text-align: center;
        }

        .dashboard-hero h2 {
            font-size: 24px;
        }
    }
</style>

<!-- Welcome Hero -->
<?php if ($this->session->userdata('logged_in')): ?>
    <section class="dashboard-hero">
        <div class="container">
            <h2>Welcome back, <?php echo $this->session->userdata('logged_in')['username']; ?></h2>
            <p>Pick up where you left off or explore something new.</p>
        </div>
    </section>
<?php endif; ?>

<section class="container" style="padding-top: 20px;">

    <!-- My Courses Section -->
    <?php
    $enrolled_courses = !empty($my_courses) ? $my_courses : array();
    ?>

    <?php if (!empty($enrolled_courses)): ?>
        <div class="section-title-wrap">
            <h3 class="section-title">My Courses</h3>
        </div>
        <div class="course-grid">
            <?php foreach ($enrolled_courses as $val): ?>
                <div class="learning-card">
                    <div class="card-banner">
                        <img src="<?php echo base_url() . ($val->images ? '/upload/courses/images/' . image_to_thumb(json_decode($val->images)[0]) : 'themes/default/images/course/course-01.jpg') ?>"
                            alt="<?php echo $val->title ?>">
                    </div>
                    <div class="card-body">
                        <div class="course-category"><?php echo $val->category_name ?? 'Online Course'; ?></div>
                        <h4 class="course-name"><?php echo $val->title ?></h4>

                        <div class="instructor-info">
                            <?php if (!empty($val->tutor)): ?>
                                <img src="<?php echo base_url() . ($val->tutor->image ? '/upload/users/images/' . image_to_thumb($val->tutor->image) : 'themes/default/images/teacher/thumb-teacher-01.jpg') ?>"
                                    alt="Tutor">
                                <span><?php echo $val->tutor->first_name . ' ' . $val->tutor->last_name ?></span>
                            <?php else: ?>
                                <i class="fa fa-user-circle-o" style="margin-right: 8px; color: #ccc;"></i>
                                <span>Lead Instructor</span>
                            <?php endif; ?>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <span
                                style="font-size: 12px; color: var(--text-muted); font-weight: 600;"><?php echo $val->progress; ?>%
                                Complete</span>
                        </div>
                        <div class="progress-minimal">
                            <div class="progress-bar-minimal" style="width: <?php echo $val->progress; ?>%;"></div>
                        </div>

                        <div class="card-actions">
                            <a href="<?php echo site_url('courses/lecture/' . $val->id); ?>" class="btn-dashboard">Resume
                                Learning</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Explore More Section -->
    <div class="section-title-wrap" style="<?php echo empty($enrolled_courses) ? '' : 'margin-top: 60px;'; ?>">
        <h3 class="section-title">
            <?php echo empty($enrolled_courses) ? 'Recommended Courses' : 'Explore more courses'; ?>
        </h3>
    </div>

    <?php if (!empty($f_courses)): ?>
        <div class="course-grid">
            <?php
            $enrolled_ids = array_column($enrolled_courses, 'id');
            foreach ($f_courses as $val):
                ?>
                <?php if (empty($_SESSION['logged_in']) || !in_array($val->id, $enrolled_ids)): ?>
                    <div class="learning-card">
                        <div class="card-banner">
                            <img src="<?php echo base_url() . ($val->images ? '/upload/courses/images/' . image_to_thumb(json_decode($val->images)[0]) : 'themes/default/images/course/course-01.jpg') ?>"
                                alt="<?php echo $val->title ?>">
                        </div>
                        <div class="card-body">
                            <div class="course-category"><?php echo $val->category_name ?? 'Education'; ?></div>
                            <h4 class="course-name"><?php echo $val->title ?></h4>

                            <div class="instructor-info">
                                <?php if (!empty($val->tutor)): ?>
                                    <img src="<?php echo base_url() . ($val->tutor->image ? '/upload/users/images/' . image_to_thumb($val->tutor->image) : 'themes/default/images/teacher/thumb-teacher-01.jpg') ?>"
                                        alt="Tutor">
                                    <span><?php echo $val->tutor->first_name . ' ' . $val->tutor->last_name ?></span>
                                <?php else: ?>
                                    <i class="fa fa-user-circle-o" style="margin-right: 8px; color: #ccc;"></i>
                                    <span>Expert Mentor</span>
                                <?php endif; ?>
                            </div>

                            <div class="card-actions">
                                <a href="<?php echo site_url('courses/detail/') . str_replace(' ', '+', $val->title); ?>"
                                    class="btn-dashboard">Learn More</a>
                                <a href="<?php echo site_url('courses/detail/') . str_replace(' ', '+', $val->title); ?>"
                                    class="btn-outline-dashboard">View Syllabus</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fa fa-graduation-cap"></i>
            <h3>No courses available yet</h3>
            <p>Our experts are preparing quality content for you. Check back soon!</p>
        </div>
    <?php endif; ?>

</section>