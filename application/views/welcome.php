<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
/* ======================================================
   LANDING PAGE — MODERN LMS REDESIGN
   ====================================================== */

/* ----------- CSS Custom Properties ----------- */
:root {
    --lp-primary: #4F46E5;
    --lp-primary-hover: #4338CA;
    --lp-secondary: #7C3AED;
    --lp-accent: #06B6D4;
    --lp-orange: #F59E0B;
    --lp-dark: #0F0C29;
    --lp-dark-2: #1E1B4B;
    --lp-card-bg: rgba(255,255,255,0.07);
    --lp-glass: rgba(255,255,255,0.12);
    --lp-light: #F8F7FF;
    --lp-text: #1F2937;
    --lp-muted: #6B7280;
    --lp-border: rgba(79,70,229,0.15);
    --lp-shadow: 0 20px 60px rgba(79,70,229,0.15);
    --lp-radius: 16px;
    --lp-radius-sm: 10px;
    --lp-transition: all 0.4s cubic-bezier(0.165,0.84,0.44,1);
    --lp-gradient: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #06B6D4 100%);
    --lp-gradient-text: linear-gradient(135deg, #4F46E5, #7C3AED, #06B6D4);
}

/* ----------- Global Reset for Landing ----------- */
.lp-section { position: relative; overflow: hidden; }
[data-aos] {
    opacity: 1 !important;
    transform: none !important;
    visibility: visible !important;
}

/* ----------- Gradient Text ----------- */
.gradient-text {
    background: var(--lp-gradient-text);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ======================================================
   HERO SECTION — Compact
   ====================================================== */
.lp-hero {
    min-height: 50vh;
    background: linear-gradient(135deg, rgba(15, 12, 41, 0.85) 0%, rgba(30, 27, 75, 0.88) 60%, rgba(13, 17, 23, 0.92) 100%), url('<?php echo base_url("upload/home/banner_image_1.jpg"); ?>') center/cover no-repeat fixed;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    padding: 60px 0 50px;
    text-align: center;
}

/* Subtle grid overlay */
.lp-hero-grid {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none;
}

/* One soft glow orb — subtle */
.lp-hero::before {
    content: '';
    position: absolute;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(79,70,229,0.18) 0%, transparent 70%);
    top: -120px; left: 50%;
    transform: translateX(-50%);
    border-radius: 50%;
    pointer-events: none;
}
.lp-hero::after { display: none; }
.lp-hero-orb3 { display: none; }

.lp-hero-content { position: relative; z-index: 2; }

/* Hero Badge */
.lp-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(79,70,229,0.18);
    border: 1px solid rgba(79,70,229,0.35);
    border-radius: 50px;
    padding: 5px 16px;
    margin-bottom: 20px;
    animation: lp-fadeInUp 0.6s ease-out both;
}
.lp-hero-badge .badge-dot {
    width: 7px; height: 7px;
    background: #06B6D4;
    border-radius: 50%;
    animation: lp-pulse 2s ease-in-out infinite;
}
.lp-hero-badge span {
    color: #a5b4fc;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

@keyframes lp-pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(6,182,212,0.4); }
    50% { box-shadow: 0 0 0 6px rgba(6,182,212,0); }
}

/* Hero Heading */
.lp-hero h1 {
    font-size: clamp(2.4rem, 4.5vw, 3.6rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.15;
    letter-spacing: -0.025em;
    margin-bottom: 16px;
    animation: lp-fadeInUp 0.6s ease-out 0.1s both;
}
.lp-hero h1 .highlight {
    background: linear-gradient(90deg, #a5b4fc, #7C3AED, #06B6D4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.lp-hero-subtext {
    font-size: 1.25rem;
    color: rgba(255,255,255,0.75);
    line-height: 1.65;
    margin: 0 auto 28px;
    max-width: 620px;
    animation: lp-fadeInUp 0.6s ease-out 0.2s both;
}

/* CTA Buttons */
.lp-hero-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: center;
    margin-bottom: 32px;
    animation: lp-fadeInUp 0.6s ease-out 0.3s both;
}

.btn-lp-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--lp-gradient);
    color: #fff !important;
    padding: 11px 28px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.95rem;
    text-decoration: none !important;
    transition: var(--lp-transition);
    box-shadow: 0 6px 24px rgba(79,70,229,0.35);
    border: none;
    cursor: pointer;
}
.btn-lp-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 36px rgba(79,70,229,0.45);
    color: #fff !important;
}

.btn-lp-outline {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.07);
    color: #fff !important;
    padding: 11px 28px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none !important;
    transition: var(--lp-transition);
    border: 1px solid rgba(255,255,255,0.18);
}
.btn-lp-outline:hover {
    background: rgba(255,255,255,0.13);
    border-color: rgba(255,255,255,0.35);
    transform: translateY(-2px);
    color: #fff !important;
}

/* Trust row */
.lp-hero-trust {
    display: flex;
    align-items: center;
    gap: 14px;
    justify-content: center;
    animation: lp-fadeInUp 0.6s ease-out 0.4s both;
}
.lp-hero-trust .trust-avatars {
    display: flex;
}
.lp-hero-trust .trust-avatars .av-placeholder {
    width: 30px; height: 30px;
    border-radius: 50%;
    border: 2px solid #1E1B4B;
    margin-left: -8px;
    background: linear-gradient(135deg, #4F46E5, #7C3AED);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 11px; font-weight: 700;
}
.lp-hero-trust .trust-text { color: rgba(255,255,255,0.55); font-size: 0.82rem; }
.lp-hero-trust .trust-text strong { color: #e0e7ff; }

/* Responsive */
@media (max-width: 768px) {
    .lp-hero { min-height: auto; padding: 48px 0 40px; }
    .lp-hero h1 { font-size: 1.7rem; }
    .lp-hero-actions { flex-direction: column; align-items: center; }
}
.lp-slide-content {
    position: relative; z-index: 2;
    padding: 80px 0;
}

/* ======================================================
   STATS BAR
   ====================================================== */
.lp-stats-bar {
    background: linear-gradient(135deg, #4F46E5, #7C3AED);
    padding: 28px 0;
    position: relative;
    z-index: 2;
}
.lp-stats-bar-inner {
    display: flex;
    justify-content: center;
    gap: 0;
    flex-wrap: wrap;
}
.lp-stats-bar-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 40px;
    border-right: 1px solid rgba(255,255,255,0.2);
    transition: transform 0.3s;
}
.lp-stats-bar-item:last-child { border-right: none; }
.lp-stats-bar-item:hover { transform: scale(1.05); }
.lp-stats-bar-icon {
    width: 44px; height: 44px;
    background: rgba(255,255,255,0.15);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: #fff;
    flex-shrink: 0;
}
.lp-stats-bar-num {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.lp-stats-bar-label {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.75);
    font-weight: 500;
    margin-top: 2px;
}

/* ======================================================
   SECTION TITLES
   ====================================================== */
.lp-section-header {
    text-align: center;
    margin-bottom: 56px;
}
.lp-section-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(79,70,229,0.08);
    border: 1px solid rgba(79,70,229,0.2);
    border-radius: 50px;
    padding: 5px 16px;
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--lp-primary);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 16px;
}
.lp-section-title {
    font-size: clamp(1.8rem, 3.5vw, 2.8rem);
    font-weight: 800;
    color: var(--lp-text);
    line-height: 1.2;
    letter-spacing: -0.03em;
    margin-bottom: 16px;
}
.lp-section-title .accent {
    background: var(--lp-gradient-text);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.lp-section-sub {
    font-size: 1.05rem;
    color: var(--lp-muted);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.7;
}

/* ======================================================
   FEATURED COURSES
   ====================================================== */
.lp-courses-section {
    padding: 100px 0;
    background: var(--lp-light);
}

.lp-course-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 28px;
    margin-bottom: 48px;
}

.lp-course-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.06);
    transition: var(--lp-transition);
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    text-decoration: none !important;
    color: inherit !important;
    position: relative;
}
.lp-course-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 24px 64px rgba(79,70,229,0.18);
    border-color: rgba(79,70,229,0.2);
}

.lp-course-img-wrap {
    position: relative;
    height: 190px;
    overflow: hidden;
    background: linear-gradient(135deg, #4F46E5, #7C3AED);
}
.lp-course-img-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.165,0.84,0.44,1);
}
.lp-course-card:hover .lp-course-img-wrap img {
    transform: scale(1.08);
}
.lp-course-img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,0.5) 100%);
}
.lp-course-cat-badge {
    position: absolute;
    top: 14px; left: 14px;
    background: rgba(79,70,229,0.9);
    backdrop-filter: blur(6px);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 4px 12px;
    border-radius: 50px;
}

.lp-course-body {
    padding: 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.lp-course-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--lp-text);
    line-height: 1.45;
    margin-bottom: 16px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.lp-course-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    font-size: 0.82rem;
    color: var(--lp-muted);
}
.lp-course-meta i { font-size: 12px; }
.lp-course-meta .lp-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    color: #F59E0B;
    font-weight: 700;
}
.lp-course-actions {
    display: flex;
    gap: 10px;
    margin-top: auto;
}
.btn-enroll {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: var(--lp-primary);
    color: #fff !important;
    border: none;
    border-radius: 10px;
    padding: 10px 0;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--lp-transition);
    text-decoration: none !important;
}
.btn-enroll:hover {
    background: var(--lp-primary-hover);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(79,70,229,0.35);
    color: #fff !important;
}
.btn-preview {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: rgba(79,70,229,0.08);
    color: var(--lp-primary) !important;
    border: 1px solid rgba(79,70,229,0.2);
    border-radius: 10px;
    padding: 10px 18px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--lp-transition);
    text-decoration: none !important;
}
.btn-preview:hover {
    background: rgba(79,70,229,0.15);
    border-color: var(--lp-primary);
    color: var(--lp-primary) !important;
}

.lp-view-all {
    text-align: center;
}
.btn-lp-secondary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    color: var(--lp-primary) !important;
    border: 2px solid var(--lp-primary);
    padding: 14px 36px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.95rem;
    text-decoration: none !important;
    transition: var(--lp-transition);
}
.btn-lp-secondary:hover {
    background: var(--lp-primary);
    color: #fff !important;
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(79,70,229,0.3);
}

/* ======================================================
   FEATURES / WHY CHOOSE US - SLEEK & COMPACT
   ====================================================== */
.lp-features-section {
    padding: 60px 0 65px;
    background: #FFFFFF;
}

.lp-features-section .lp-section-header {
    margin-bottom: 32px;
}

.lp-features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 22px;
}

.lp-feature-card {
    padding: 24px 22px;
    border-radius: 18px;
    border: 1px solid rgba(99, 102, 241, 0.12);
    background: #F8FAFC;
    text-align: left;
    display: flex;
    align-items: flex-start;
    gap: 18px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.lp-feature-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; bottom: 0;
    width: 4px;
    background: var(--lp-gradient);
    transform: scaleY(0);
    transform-origin: top;
    transition: transform 0.3s ease;
}

.lp-feature-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(99, 102, 241, 0.12);
    border-color: rgba(99, 102, 241, 0.3);
    background: #FFFFFF;
}

.lp-feature-card:hover::before {
    transform: scaleY(1);
}

.lp-feature-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
    margin: 0;
    transition: transform 0.3s ease;
}

.lp-feature-card:hover .lp-feature-icon {
    transform: scale(1.08) rotate(-4deg);
}

.lp-feature-body {
    flex: 1;
}

.lp-feature-card h4 {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0F172A;
    margin: 0 0 6px 0;
}

.lp-feature-card p {
    font-size: 0.95rem;
    color: #475569;
    line-height: 1.6;
    margin: 0;
}

/* Icon gradient variants */
.icon-violet { background: linear-gradient(135deg, rgba(79,70,229,0.1), rgba(124,58,237,0.15)); color: #7C3AED; }
.icon-cyan { background: linear-gradient(135deg, rgba(6,182,212,0.1), rgba(14,165,233,0.15)); color: #0891B2; }
.icon-amber { background: linear-gradient(135deg, rgba(245,158,11,0.1), rgba(251,191,36,0.15)); color: #D97706; }
.icon-emerald { background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(52,211,153,0.15)); color: #059669; }
.icon-rose { background: linear-gradient(135deg, rgba(244,63,94,0.1), rgba(251,113,133,0.15)); color: #E11D48; }
.icon-indigo { background: linear-gradient(135deg, rgba(79,70,229,0.1), rgba(99,102,241,0.15)); color: #4F46E5; }

/* ======================================================
   TESTIMONIALS - ELEVATED DESIGN SYSTEM
   ====================================================== */
.lp-testimonials-section {
    padding: 75px 0 85px;
    background: linear-gradient(180deg, rgba(15, 23, 42, 0.91) 0%, rgba(15, 23, 42, 0.94) 100%), url('<?php echo base_url("upload/home/banner_image_2.jpg"); ?>') center/cover no-repeat fixed;
    position: relative;
    overflow: hidden;
}

.lp-testimonials-bg-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 900px;
    height: 500px;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.14) 0%, rgba(168, 85, 247, 0.06) 50%, transparent 70%);
    pointer-events: none;
    z-index: 0;
}

.lp-testimonials-section .lp-section-header {
    margin-bottom: 40px;
}

.lp-testimonials-section .lp-section-title {
    font-size: 2.35rem;
    font-weight: 800;
    color: #FFFFFF !important;
    margin-bottom: 12px;
}

.lp-testimonials-section .lp-section-sub {
    font-size: 1.1rem;
    color: #CBD5E1 !important;
    max-width: 650px;
}

.lp-testimonials-section .lp-section-badge {
    font-size: 0.88rem;
    padding: 6px 16px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.22);
    color: #F1F5F9;
    margin-bottom: 14px;
}

.lp-testimonials-trust-bar {
    display: inline-flex;
    align-items: center;
    gap: 16px;
    margin-top: 18px;
    padding: 8px 22px;
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 50px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    flex-wrap: wrap;
    justify-content: center;
}

.lp-trust-rating {
    display: flex;
    align-items: center;
    gap: 8px;
}

.lp-trust-score {
    font-weight: 800;
    font-size: 1.25rem;
    color: #FFFFFF;
}

.lp-trust-stars {
    color: #F59E0B;
    font-size: 1rem;
    display: flex;
    gap: 3px;
}

.lp-trust-count {
    font-size: 1.02rem;
    color: #CBD5E1;
    font-weight: 600;
}

.lp-trust-divider {
    width: 1px;
    height: 18px;
    background: rgba(255, 255, 255, 0.2);
}

.lp-trust-badge {
    font-size: 1.02rem;
    font-weight: 600;
    color: #F8FAFC;
    display: flex;
    align-items: center;
    gap: 6px;
}

.lp-testimonials-carousel {
    position: relative;
    z-index: 1;
    margin-top: 10px;
}

/* Equal Height & Spacing between Review Cards in Carousel */
.lp-testimonials-carousel .owl-stage {
    display: flex !important;
    margin: 0 -15px !important;
}

.lp-testimonials-carousel .owl-item {
    display: flex !important;
    height: auto !important;
    padding: 0 15px !important;
    box-sizing: border-box !important;
}

.lp-testimonials-carousel .owl-item > .item {
    display: flex !important;
    flex: 1 1 auto;
    width: 100%;
}

.lp-testimonial-card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(16px);
    border-radius: 20px;
    padding: 28px 24px 24px;
    box-shadow: 0 12px 36px rgba(0, 0, 0, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.9);
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: visible !important;
    margin: 12px 0 24px !important;
    display: flex !important;
    flex-direction: column !important;
    flex: 1 1 auto;
    width: 100%;
    min-height: 380px;
}

.lp-testimonial-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    position: relative;
    z-index: 2;
}

.lp-testimonial-stars {
    display: flex;
    align-items: center;
    gap: 4px;
    color: #F59E0B;
    font-size: 15px;
}

.lp-rating-num {
    margin-left: 6px;
    font-weight: 700;
    font-size: 0.85rem;
    color: #334155;
    background: #FEF3C7;
    padding: 2px 7px;
    border-radius: 6px;
}

.lp-verified-pill {
    font-size: 0.8rem;
    font-weight: 600;
    color: #047857;
    background: #D1FAE5;
    border: 1px solid #6EE7B7;
    padding: 3px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.lp-quote-watermark {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 4.5rem;
    font-family: Georgia, serif;
    line-height: 1;
    color: rgba(99, 102, 241, 0.08);
    pointer-events: none;
    user-select: none;
    z-index: 0;
}

.lp-testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 48px rgba(0, 0, 0, 0.35), 0 0 0 2px rgba(99, 102, 241, 0.3);
    background: #FFFFFF;
}

.lp-testimonial-text {
    font-size: 0.98rem;
    color: #334155;
    line-height: 1.65;
    margin-bottom: 20px;
    font-style: normal;
    font-weight: 400;
    position: relative;
    z-index: 1;
    flex-grow: 1;
    overflow: visible !important;
    display: block !important;
}

.lp-testimonial-author {
    display: flex;
    align-items: center;
    gap: 12px;
    border-top: 1px solid #F1F5F9;
    padding-top: 16px;
    margin-top: auto;
    position: relative;
    z-index: 1;
}

.lp-avatar-wrapper {
    position: relative;
    flex-shrink: 0;
}

.lp-testimonial-avatar {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #6366F1;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    background: #EEF2FF;
}

.lp-avatar-check {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 20px;
    height: 20px;
    background: #10B981;
    color: #FFF;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    border: 2px solid #FFF;
}

.lp-author-info {
    display: flex;
    flex-direction: column;
}

.lp-author-name {
    font-weight: 700;
    font-size: 1.12rem;
    color: #0F172A;
    letter-spacing: -0.01em;
}

.lp-author-role {
    font-size: 0.95rem;
    color: #4F46E5;
    font-weight: 600;
    margin-top: 3px;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Custom Owl Carousel Dots Styling */
.lp-testimonials-section .owl-dots {
    display: flex !important;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-top: 36px;
}

.lp-testimonials-section .owl-dot {
    width: 10px;
    height: 10px;
    background: #CBD5E1 !important;
    border-radius: 50%;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    outline: none;
    cursor: pointer;
}

.lp-testimonials-section .owl-dot.active {
    width: 32px;
    border-radius: 12px;
    background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%) !important;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35);
}

/* ======================================================
   CTA BANNER
   ====================================================== */
.lp-cta-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #0F0C29 0%, #1E1B4B 50%, #0d1117 100%);
    position: relative;
    overflow: hidden;
}
.lp-cta-section::before {
    content: '';
    position: absolute;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(79,70,229,0.3) 0%, transparent 70%);
    top: -150px; right: -100px;
    border-radius: 50%;
    pointer-events: none;
}
.lp-cta-section::after {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(124,58,237,0.2) 0%, transparent 70%);
    bottom: -100px; left: -100px;
    border-radius: 50%;
    pointer-events: none;
}
.lp-cta-content {
    position: relative; z-index: 2;
    text-align: center;
}
.lp-cta-content h2 {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: #fff;
    margin-bottom: 16px;
    letter-spacing: -0.03em;
}
.lp-cta-content h2 span {
    background: linear-gradient(90deg, #a5b4fc, #06B6D4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.lp-cta-content p {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.7);
    margin-bottom: 40px;
    max-width: 500px;
    margin-left: auto; margin-right: auto;
}

.lp-cta-buttons {
    display: flex;
    justify-content: center;
    gap: 16px;
    flex-wrap: wrap;
}

/* ======================================================
   ANIMATIONS
   ====================================================== */
@keyframes lp-fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes lp-fadeInRight {
    from { opacity: 0; transform: translateX(40px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes lp-float {
    0%, 100% { transform: translateY(0px); }
    50%       { transform: translateY(-16px); }
}

/* ======================================================
   RESPONSIVE
   ====================================================== */
@media (max-width: 991px) {
    .lp-hero {
        min-height: auto;
        padding: 60px 0 40px;
    }
    .lp-hero h1 { font-size: 2.4rem; }
    .lp-hero-card { margin-top: 48px; }
    .lp-stats-bar-item { padding: 8px 20px; }
    .lp-stats-bar-num { font-size: 1.2rem; }
}

@media (max-width: 768px) {
    .lp-hero h1 { font-size: 2rem; }
    .lp-hero-actions { flex-direction: column; align-items: flex-start; }
    .lp-stats-bar-inner { gap: 0; }
    .lp-stats-bar-item { width: 50%; border-right: none; border-bottom: 1px solid rgba(255,255,255,0.15); }
    .lp-stats-bar-item:nth-last-child(-n+2) { border-bottom: none; }
    .lp-features-grid { grid-template-columns: 1fr 1fr; }
    .lp-cta-buttons { flex-direction: column; align-items: center; }
}

@media (max-width: 480px) {
    .lp-features-grid { grid-template-columns: 1fr; }
    .lp-stat-grid { grid-template-columns: 1fr 1fr; }
}

/* Section padding util */
.lp-py { padding: 100px 0; }

</style>

<!-- ======================================================
     HERO SECTION
     ====================================================== -->
<!-- Compact Hero -->
<section class="lp-hero lp-section">
    <div class="lp-hero-grid"></div>
    <div class="lp-hero-orb3"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <div class="lp-hero-content">
                    <div class="lp-hero-badge">
                        <span class="badge-dot"></span>
                        <span><?php echo $this->settings->site_name; ?> &mdash; Real-Time Projects</span>
                    </div>
                    <h1>
                        Master <span class="highlight">BigData &amp; Spark</span>
                        Analytics
                    </h1>
                    <p class="lp-hero-subtext">
                        Industry-focused BigData, Spark &amp; Analytics programs with hands-on real-time projects — designed for professionals who want to stay ahead.
                    </p>
                    <div class="lp-hero-actions">
                        <a href="<?php echo site_url('auth/register') ?>" class="btn-lp-primary">
                            <i class="fa fa-user-plus"></i> Enroll Now
                        </a>
                        <a href="<?php echo site_url('courses') ?>" class="btn-lp-outline">
                            <i class="fa fa-th-large"></i> Browse Batches
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>




<!-- ======================================================
     FEATURED COURSES
     ====================================================== -->
<?php if (!empty($f_courses)): ?>
<section class="lp-courses-section lp-section">
    <div class="container">
        <div class="lp-section-header" data-aos="fade-up">
            <div class="lp-section-badge">
                <i class="fa fa-database"></i> Live Batches
            </div>
            <h2 class="lp-section-title">
                Our <span class="accent">BigData &amp; Spark</span> Programs
            </h2>
            <p class="lp-section-sub">
                Hands-on batch programs with real-time projects — from beginner to advanced Analytics &amp; Spark.
            </p>
        </div>

        <div class="lp-course-grid">
            <?php foreach (array_slice($f_courses, 0, 8) as $key => $val):
                $course_url = site_url('courses/detail/') . str_replace(' ', '+', $val->title);
            ?>
            <div data-aos="fade-up" data-aos-delay="<?php echo ($key % 4) * 100; ?>">
                <div class="lp-course-card">
                    <div class="lp-course-img-wrap">
                        <img src="<?php echo base_url() . ($val->images ? '/upload/courses/images/' . image_to_thumb(json_decode($val->images)[0]) : 'upload/default_course_banner.png') ?>"
                             alt="<?php echo htmlspecialchars($val->title) ?>"
                             loading="lazy">
                        <div class="lp-course-img-overlay"></div>
                        <div class="lp-course-cat-badge">Professional</div>
                    </div>
                    <div class="lp-course-body">
                        <h4 class="lp-course-title"><?php echo htmlspecialchars($val->title) ?></h4>
                        
                        <div class="lp-course-actions">
                            <button class="btn-enroll"
                                onclick="window.location.href='<?php echo site_url('auth/register'); ?>'">
                                <i class="fa fa-user-plus"></i> Enroll
                            </button>
                            <button class="btn-preview"
                                onclick="window.location.href='<?php echo $course_url; ?>'">
                                <i class="fa fa-play"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="lp-view-all" data-aos="fade-up">
            <a href="<?php echo site_url('courses') ?>" class="btn-lp-secondary">
                View All Courses <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ======================================================
     WHY CHOOSE US — FEATURES
     ====================================================== -->
<section class="lp-features-section lp-section">
    <div class="container">
        <div class="lp-section-header" data-aos="fade-up">
            <div class="lp-section-badge"><i class="fa fa-bolt"></i> Why Zeyobron</div>
            <h2 class="lp-section-title">Industry-Ready <span class="accent">Analytics Training</span></h2>
            <p class="lp-section-sub">We combine real-time project experience with expert mentorship to make you job-ready.</p>
        </div>

        <div class="lp-features-grid">
            <div class="lp-feature-card" data-aos="fade-up" data-aos-delay="0">
                <div class="lp-feature-icon icon-violet"><i class="fa fa-database"></i></div>
                <h5>BigData &amp; Spark</h5>
                <p>Deep-dive programs covering Hadoop, Spark, Kafka, Hive and real-time streaming analytics.</p>
            </div>
            <div class="lp-feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="lp-feature-icon icon-cyan"><i class="fa fa-code"></i></div>
                <h5>Hands-On Projects</h5>
                <p>Every batch includes real-time industry projects to build a portfolio that impresses recruiters.</p>
            </div>
            <div class="lp-feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="lp-feature-icon icon-amber"><i class="fa fa-users"></i></div>
                <h5>Batch-Based Learning</h5>
                <p>Learn alongside peers in structured batches — live sessions, recordings, and doubt-clearing included.</p>
            </div>
            <div class="lp-feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="lp-feature-icon icon-emerald"><i class="fa fa-line-chart"></i></div>
                <h5>Advanced Analytics</h5>
                <p>From data ingestion to ML pipelines — master the full analytics stack used in production systems.</p>
            </div>
            <div class="lp-feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="lp-feature-icon icon-violet"><i class="fa fa-video-camera"></i></div>
                <h5>Video Library Access</h5>
                <p>Get lifetime access to recorded sessions — rewatch any lesson at your own pace, anytime.</p>
            </div>
            <div class="lp-feature-card" data-aos="fade-up" data-aos-delay="500">
                <div class="lp-feature-icon icon-indigo">
                    <i class="fa fa-life-ring" style="display:contents;">🛟</i>
                </div>
                <h3>Dedicated Support</h3>
                <p>Our support team is always on hand to assist you throughout your learning journey.</p>
            </div>
        </div>
    </div>
</section>


<!-- ======================================================
     TESTIMONIALS
     ====================================================== -->
<?php if (!empty($testimonials)): ?>
<section class="lp-testimonials-section lp-section">
    <div class="lp-testimonials-bg-glow"></div>
    <div class="container">
        <div class="lp-section-header" data-aos="fade-up">
            <div class="lp-section-badge">
                <i class="fa fa-star" style="color: #F59E0B;"></i> Student Stories &amp; Reviews
            </div>
            <h2 class="lp-section-title">
                What Our <span class="accent">Learners Say</span>
            </h2>
            <p class="lp-section-sub">
                Real experiences from real students who transformed their careers with us.
            </p>
            <div class="lp-testimonials-trust-bar">
                <div class="lp-trust-rating">
                    <span class="lp-trust-score">4.9</span>
                    <span class="lp-trust-stars">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </span>
                    <span class="lp-trust-count">(2,500+ Reviews)</span>
                </div>
                <div class="lp-trust-divider"></div>
                <div class="lp-trust-badge">
                    <i class="fa fa-check-circle" style="color:#10B981;"></i> 100% Verified Graduates
                </div>
            </div>
        </div>

        <div class="owl-carousel lp-testimonials-carousel" data-items="3" data-desktop="3" data-desktopsmall="2" data-tablet="1" data-mobile="1"
            data-margin="30" data-loop="true" data-autoplay="true" data-nav="false" data-dots="true">
            <?php foreach ($testimonials as $key => $val): ?>
                <div class="item" data-aos="fade-up" data-aos-delay="<?php echo ($key % 3) * 100; ?>">
                    <div class="lp-testimonial-card">
                        <div class="lp-testimonial-card-header">
                            <div class="lp-testimonial-stars">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <span class="lp-rating-num">5.0</span>
                            </div>
                            <span class="lp-verified-pill"><i class="fa fa-shield"></i> Verified Learner</span>
                        </div>
                        <div class="lp-quote-watermark">“</div>
                        <p class="lp-testimonial-text"><?php echo $val->t_feedback; ?></p>
                        <div class="lp-testimonial-author">
                            <div class="lp-avatar-wrapper">
                                <img class="lp-testimonial-avatar"
                                    src="<?php echo base_url('upload/testimonials/images/' . ($val->image ? $val->image : 'default_avatar.png')) ?>"
                                    alt="<?php echo $val->t_name ?>"
                                    onerror="this.src='<?php echo base_url('upload/expert_mentor_avatar.png'); ?>'">
                                <span class="lp-avatar-check"><i class="fa fa-check"></i></span>
                            </div>
                            <div class="lp-author-info">
                                <div class="lp-author-name"><?php echo $val->t_name ?></div>
                                <div class="lp-author-role">
                                    <i class="fa fa-graduation-cap"></i> <?php echo $val->t_type ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ======================================================
     CTA BANNER
     ====================================================== -->
<section class="lp-cta-section lp-section">
    <div class="container">
        <div class="lp-cta-content" data-aos="fade-up">
            <div class="lp-section-badge" style="background:rgba(165,180,252,0.15); border-color:rgba(165,180,252,0.3); color:#a5b4fc; margin-bottom:20px;">
                🚀 Get Started Today
            </div>
            <h2>
                Ready to <span>Transform</span><br>Your Career?
            </h2>
            <p>
                Join thousands of learners who have already taken the first step toward a brighter professional future.
            </p>
            <div class="lp-cta-buttons">
                <a href="<?php echo site_url('auth/register') ?>" class="btn-lp-primary" style="font-size:1.05rem; padding:16px 40px;">
                    <i class="fa fa-user-plus"></i> Create Free Account
                </a>
                <a href="<?php echo site_url('courses') ?>" class="btn-lp-outline" style="font-size:1.05rem; padding:16px 40px;">
                    <i class="fa fa-search"></i> Browse Courses
                </a>
            </div>
        </div>
    </div>
</section>





<?php
$CI =& get_instance();
$settings = $CI->settings;
?>
<?php if (isset($settings->promo_modal_enabled) && $settings->promo_modal_enabled == 1): ?>
<!-- ======================================================
     OFFER MODAL — Controlled by backend (Admin > Settings > promo_modal_enabled)
     ====================================================== -->
<div id="offerModal" class="modal fade" role="dialog" style="z-index: 100000;">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content offer-modal-content">

            <!-- Decorative gradient top bar -->
            <div class="offer-modal-bar"></div>

            <!-- Floating close button -->
            <button type="button" class="offer-close-btn" data-dismiss="modal" aria-label="Close">&times;</button>

            <!-- Offer Badge -->
            <div class="offer-modal-badge">
                <span class="offer-badge-dot"></span>
                <span>Special Offer</span>
            </div>

            <!-- Header -->
            <div class="offer-modal-header">
                <h3 class="offer-modal-title">
                    <?php echo isset($settings->promo_modal_title) && !empty($settings->promo_modal_title)
                        ? htmlspecialchars($settings->promo_modal_title)
                        : '🎉 Exclusive Offer Just For You!'; ?>
                </h3>
            </div>

            <!-- Body -->
            <div class="offer-modal-body">
                <?php if (isset($settings->promo_modal_image) && !empty($settings->promo_modal_image)): ?>
                    <div class="offer-modal-img-wrap">
                        <img src="<?php echo base_url('upload/home/' . $settings->promo_modal_image); ?>"
                             alt="Offer" class="offer-modal-img">
                    </div>
                <?php endif; ?>

                <?php if (isset($settings->promo_modal_content) && !empty($settings->promo_modal_content)): ?>
                    <p class="offer-modal-text">
                        <?php echo nl2br(htmlspecialchars($settings->promo_modal_content)); ?>
                    </p>
                <?php else: ?>
                    <p class="offer-modal-text">
                        Don't miss out on our latest courses and exclusive discounts. Enroll today and start your learning journey!
                    </p>
                <?php endif; ?>
            </div>

            <!-- Footer CTA -->
            <div class="offer-modal-footer">
                <?php if (isset($settings->promo_modal_btn_text) && !empty($settings->promo_modal_btn_text)): ?>
                    <a href="<?php echo isset($settings->promo_modal_btn_url) && !empty($settings->promo_modal_btn_url) ? $settings->promo_modal_btn_url : site_url('courses'); ?>"
                       class="offer-modal-cta" data-dismiss="modal">
                        <i class="fa fa-arrow-right"></i>
                        <?php echo htmlspecialchars($settings->promo_modal_btn_text); ?>
                    </a>
                <?php else: ?>
                    <a href="<?php echo site_url('courses'); ?>" class="offer-modal-cta" data-dismiss="modal">
                        <i class="fa fa-graduation-cap"></i> Browse Courses Now
                    </a>
                <?php endif; ?>
                <button class="offer-modal-skip" data-dismiss="modal">Maybe later</button>
            </div>

        </div>
    </div>
</div>

<?php endif; // promo_modal_enabled ?>

<?php if (isset($settings->promo_modal_enabled) && $settings->promo_modal_enabled == 1): ?>
<style>
/* ---- Offer Modal Styles ---- */
.offer-modal-content {
    border: none;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(79,70,229,0.25), 0 8px 32px rgba(0,0,0,0.15);
    background: #fff;
    position: relative;
}
.offer-modal-bar {
    height: 5px;
    background: linear-gradient(90deg, #4F46E5, #7C3AED, #06B6D4);
    width: 100%;
}
.offer-close-btn {
    position: absolute;
    top: 14px; right: 16px;
    width: 32px; height: 32px;
    border-radius: 50%;
    background: rgba(79,70,229,0.08);
    border: none;
    font-size: 20px;
    line-height: 1;
    color: #6B7280;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
    z-index: 10;
}
.offer-close-btn:hover {
    background: rgba(79,70,229,0.15);
    color: #4F46E5;
    transform: rotate(90deg);
}
.offer-modal-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(79,70,229,0.08);
    border: 1px solid rgba(79,70,229,0.2);
    border-radius: 50px;
    padding: 5px 16px;
    margin: 24px auto 0;
    font-size: 0.78rem;
    font-weight: 700;
    color: #4F46E5;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: flex;
    width: fit-content;
    margin-left: auto;
    margin-right: auto;
    margin-top: 24px;
}
.offer-badge-dot {
    width: 7px; height: 7px;
    background: #06B6D4;
    border-radius: 50%;
    animation: lp-pulse 2s ease-in-out infinite;
    flex-shrink: 0;
}
.offer-modal-header {
    padding: 16px 32px 8px;
    text-align: center;
}
.offer-modal-title {
    font-size: 1.45rem;
    font-weight: 800;
    color: #1F2937;
    letter-spacing: -0.03em;
    line-height: 1.25;
    margin: 0;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.offer-modal-body {
    padding: 16px 32px 20px;
    text-align: center;
}
.offer-modal-img-wrap {
    margin-bottom: 16px;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.offer-modal-img {
    width: 100%;
    display: block;
    border-radius: 14px;
}
.offer-modal-text {
    font-size: 15px;
    color: #6B7280;
    line-height: 1.7;
    margin: 0;
}
.offer-modal-footer {
    padding: 0 32px 32px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}
.offer-modal-cta {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #06B6D4 100%);
    color: #fff !important;
    text-decoration: none !important;
    padding: 14px 36px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1rem;
    width: 100%;
    transition: all 0.3s ease;
    box-shadow: 0 8px 24px rgba(79,70,229,0.35);
    border: none;
    cursor: pointer;
}
.offer-modal-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 36px rgba(79,70,229,0.45);
    color: #fff !important;
}
.offer-modal-skip {
    background: none;
    border: none;
    color: #9CA3AF;
    font-size: 13px;
    cursor: pointer;
    padding: 4px 8px;
    transition: color 0.2s;
    text-decoration: underline;
    text-underline-offset: 2px;
}
.offer-modal-skip:hover { color: #6B7280; }

/* Backdrop darker for impact */
#offerModal .modal-backdrop, .modal-backdrop { background: rgba(10,5,30,0.7); }
</style>

<script>
/* Auto-open offer modal — only rendered when promo_modal_enabled == 1 */
document.addEventListener('DOMContentLoaded', function () {
    var checkJquery = setInterval(function () {
        if (window.jQuery) {
            clearInterval(checkJquery);
            /* Small delay so page renders first */
            setTimeout(function () {
                jQuery('#offerModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                jQuery('#offerModal').modal('show');
            }, 800);
        }
    }, 50);
});
</script>
<?php endif; // promo_modal_enabled ?>