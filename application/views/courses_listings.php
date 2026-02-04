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

	.page-listings {
		background-color: var(--bg-light);
		padding: 60px 0;
		min-height: calc(100vh - 72px);
	}

	.listings-header {
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 1px solid #ebebeb;
    }

    .search-box-premium {
        position: relative;
        width: 100%;
    }

    .search-box-premium i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .search-box-premium input {
        width: 100%;
        padding: 12px 12px 12px 44px;
        border: 1px solid #d1d7dc; /* Assuming --border-color is #d1d7dc or similar */
        border-radius: 4px;
        outline: none;
        transition: var(--transition);
        font-size: 14px;
    }

    .search-box-premium input:focus {
        border-color: var(--coursera-blue);
        box-shadow: 0 0 0 4px rgba(0, 86, 210, 0.1);
    }

	.listings-header h2 {
		font-weight: 700;
		font-size: 28px;
		color: var(--text-dark);
		margin-bottom: 12px;
	}

	.listings-header p {
		color: var(--text-muted);
		font-size: 16px;
	}

	/* Course Grid */
	.course-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
		gap: 30px;
	}

	.course-card-premium {
		background: var(--white);
		border-radius: var(--border-radius);
		overflow: hidden;
		border: 1px solid #d1d7dc;
		transition: var(--transition);
		display: flex;
		flex-direction: column;
		height: 100%;
		text-decoration: none !important;
	}

	.course-card-premium:hover {
		transform: translateY(-4px);
		box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
		border-color: rgba(0, 86, 210, 0.3);
	}

	.card-banner-wrap {
		width: 100%;
		height: 160px;
		overflow: hidden;
		position: relative;
		background: #eef0f2;
	}

	.card-banner-wrap img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transition: var(--transition);
	}

	.course-card-premium:hover .card-banner-wrap img {
		transform: scale(1.05);
	}

	.card-content {
		padding: 20px;
		flex: 1;
		display: flex;
		flex-direction: column;
	}

	.category-label {
		font-size: 11px;
		font-weight: 700;
		text-transform: uppercase;
		color: var(--coursera-blue);
		letter-spacing: 0.5px;
		margin-bottom: 8px;
	}

	.course-title-premium {
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

	.instructor-meta {
		display: flex;
		align-items: center;
		margin-top: auto;
	}

	.instructor-meta img {
		width: 24px;
		height: 24px;
		border-radius: 50%;
		margin-right: 8px;
	}

	.instructor-meta span {
		font-size: 13px;
		color: var(--text-muted);
	}

	.empty-catalog {
		text-align: center;
		padding: 80px 20px;
		grid-column: 1 / -1;
	}

	.empty-catalog i {
		font-size: 64px;
		color: #d1d7dc;
		margin-bottom: 24px;
	}

	.course-card-premium-wrap {
		display: contents;
		/* Allows the grid to manage the direct child (a) while wrapping it */
	}
</style>

<div class="page-listings">
	<div class="container">
		<div class="listings-header">
			<div class="row align-items-center">
				<div class="col-md-7">
					<h2>Explore Our Courses</h2>
					<p>Start your learning journey with world-class content.</p>
				</div>
				<div class="col-md-5">
					<div class="search-box-premium">
						<i class="fa fa-search"></i>
						<input type="text" id="courseSearch" placeholder="What do you want to learn?">
					</div>
				</div>
			</div>
		</div>

		<div class="course-grid" id="courseListingsGrid">
			<?php if (!empty($courses)): ?>
				<?php foreach ($courses as $val): ?>
					<div class="course-card-premium-wrap" data-title="<?php echo strtolower($val->title); ?>">
						<a href="<?php echo site_url('courses/detail/') . str_replace(' ', '+', $val->title); ?>"
							class="course-card-premium">
							<div class="card-banner-wrap">
								<img src="<?php echo base_url() . ($val->images ? '/upload/courses/images/' . image_to_thumb(json_decode($val->images)[0]) : 'themes/default/images/course/course-01.jpg') ?>"
									alt="<?php echo $val->title ?>">
							</div>
							<div class="card-content">
								<div class="category-label"><?php echo $val->category_name ?? 'Education'; ?></div>
								<h4 class="course-title-premium"><?php echo $val->title ?></h4>

								<div class="instructor-meta">
									<?php if (!empty($val->tutor)): ?>
										<img src="<?php echo base_url() . ($val->tutor->image ? '/upload/users/images/' . image_to_thumb($val->tutor->image) : 'themes/default/images/teacher/thumb-teacher-01.jpg') ?>"
											alt="Tutor">
										<span><?php echo $val->tutor->first_name . ' ' . $val->tutor->last_name ?></span>
									<?php else: ?>
										<i class="fa fa-user-circle-o" style="margin-right: 8px; color: #ccc;"></i>
										<span>Expert Mentor</span>
									<?php endif; ?>
								</div>
							</div>
						</a>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="empty-catalog">
					<i class="fa fa-search"></i>
					<h3>No courses found</h3>
					<p>We couldn't find any courses matching your criteria. Try exploring other categories.</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<script>
    document.getElementById('courseSearch').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.course-card-premium-wrap');
        
        cards.forEach(card => {
            const title = card.getAttribute('data-title');
            if(title.includes(term)) {
                card.style.display = 'contents'; // Use 'contents' to maintain grid layout
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>