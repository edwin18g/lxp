<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $lecture['cl_name']; ?> - <?php echo $this->settings->site_name; ?></title>

    <!-- Core Dependencies -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.10/plyr.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-page: #ffffff;
            --bg-sidebar: #f8f9fa;
            --accent: #0056d2;
            /* Coursera Blue */
            --accent-hover: #0041a3;
            --text-main: #1f1f1f;
            --text-muted: #5e5e5e;
            --border-color: #d1d7dc;
            --header-height: 64px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-main);
            margin: 0;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Layout */
        .player-wrapper {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* Header */
        .player-header {
            height: var(--header-height);
            background: #ffffff;
            display: flex;
            align-items: center;
            padding: 0 24px;
            border-bottom: 1px solid var(--border-color);
            z-index: 1001;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .btn-back {
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            padding: 8px 12px;
            border-radius: 4px;
        }

        .btn-back:hover {
            background-color: #f1f3f5;
            color: var(--accent);
            text-decoration: none;
        }

        .btn-back i {
            margin-right: 8px;
            font-size: 16px;
        }

        .header-content {
            margin-left: 24px;
            flex: 1;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .course-title {
            font-size: 14px;
            font-weight: 600;
            display: block;
            color: var(--text-main);
        }

        .lecture-name {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Main Content */
        .player-container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        /* Video Area */
        .video-main {
            flex: 1;
            background: #000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .plyr-container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .plyr--full-ui {
            width: 100%;
            max-height: 100%;
        }

        /* Start the YouTube iframe at 1080p size so YouTube picks HD from the first frame (scaled to fit by fitHqPlayer) */
        @media (min-width: 768px) {
            .plyr__video-embed iframe {
                width: 1920px;
                height: 1080px;
                transform-origin: 0 0;
            }
        }

        /* Quality menu in the player's control bar */
        .quality-menu { position: relative; }
        .quality-btn { font-size: 13px; font-weight: 600; white-space: nowrap; }
        .quality-list {
            position: absolute;
            right: 0;
            bottom: calc(100% + 10px);
            min-width: 130px;
            padding: 6px;
            background: rgba(255, 255, 255, 0.97);
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            z-index: 10;
        }
        .quality-list[hidden] { display: none; }
        .quality-item {
            display: block;
            width: 100% !important;
            min-width: 118px;
            padding: 8px 12px;
            border: 0;
            border-radius: 6px;
            background: none;
            color: #1e293b;
            font-size: 13px;
            font-weight: 500;
            text-align: left;
            cursor: pointer;
        }
        .quality-item:hover { background: #eef2ff; }
        .quality-item.is-active { background: #4f46e5; color: #fff; }

        /* Sidebar */
        .sidebar {
            width: 380px;
            background: var(--bg-sidebar);
            display: flex;
            flex-direction: column;
            border-left: 1px solid var(--border-color);
        }

        .sidebar-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-sidebar);
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-main);
        }

        .lecture-list {
            flex: 1;
            overflow-y: auto;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .lecture-item {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .lecture-link {
            display: flex;
            padding: 16px 24px;
            color: var(--text-main);
            text-decoration: none;
            transition: all 0.2s;
            align-items: flex-start;
        }

        .lecture-link:hover {
            background: rgba(0, 86, 210, 0.05);
            text-decoration: none;
            color: var(--accent);
        }

        .lecture-item.active .lecture-link {
            background: white;
            border-left: 4px solid var(--accent);
            padding-left: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .lecture-item.active .lecture-title {
            color: var(--accent);
            font-weight: 600;
        }

        .lecture-link .fa-check-circle {
            color: #28a745;
            margin-left: auto;
            font-size: 16px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .lecture-item.completed .fa-check-circle {
            opacity: 1;
        }

        .btn-complete {
            background: #fff;
            border: 1px solid var(--accent);
            color: var(--accent);
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
        }

        .btn-complete.active {
            background: #28a745;
            border-color: #28a745;
            color: #fff;
        }

        .btn-complete:hover {
            background: var(--accent);
            color: #fff;
        }

        .lecture-number {
            font-size: 13px;
            color: var(--text-muted);
            margin-right: 12px;
            min-width: 20px;
            margin-top: 2px;
        }

        .lecture-info {
            flex: 1;
        }

        .lecture-title {
            font-size: 15px;
            line-height: 1.4;
            display: block;
            margin-bottom: 4px;
        }

        .lecture-meta {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
        }

        .lecture-meta i {
            margin-right: 6px;
            font-size: 14px;
        }

        /* Custom Scrollbar */
        .lecture-list::-webkit-scrollbar {
            width: 8px;
        }

        .lecture-list::-webkit-scrollbar-track {
            background: #f1f3f5;
        }

        .lecture-list::-webkit-scrollbar-thumb {
            background: #adb5bd;
            border-radius: 4px;
            border: 2px solid #f1f3f5;
        }

        .lecture-list::-webkit-scrollbar-thumb:hover {
            background: #868e96;
        }

        /* Interactive Content View */
        .content-placeholder {
            padding: 60px 24px;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .player-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: 40vh;
                border-left: none;
                border-top: 1px solid var(--border-color);
            }

            body {
                overflow: auto;
            }

            .player-wrapper {
                height: auto;
                min-height: 100vh;
            }
        }

        @media (max-width: 767px) {
            .player-header {
                padding: 0 16px;
            }

            .header-content {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="player-wrapper">
        <!-- Header -->
        <header class="player-header">
            <a href="<?php echo site_url('courses/detail/' . str_replace(' ', '+', $lecture['course_title'])); ?>"
                class="btn-back">
                <i class="fa fa-chevron-left"></i>
                <span>Back to Course</span>
            </a>
            <div class="header-content">
                <span class="course-title"><?php echo $lecture['cl_course_id']; ?></span>
                <span class="lecture-name"><?php echo $lecture['cl_name']; ?></span>
            </div>
            <div class="header-actions">
                <button id="btnMarkComplete"
                    class="btn-complete <?php echo in_array($lecture['id'], $completed_lectures) ? 'active' : ''; ?>">
                    <?php echo in_array($lecture['id'], $completed_lectures) ? '<i class="fa fa-check"></i> Completed' : 'Mark as Complete'; ?>
                </button>
            </div>
        </header>

        <!-- Main Container -->
        <div class="player-container">
            <!-- Video Main -->
            <main class="video-main">
                <div class="plyr-container">
                    <?php if ($lecture['cl_type'] == '3'): ?>
                        <video id="player" controls crossorigin playsinline></video>
                    <?php else: ?>
                        <div class="content-placeholder">
                            <div style="margin-bottom: 24px;">
                                <div
                                    style="width: 80px; height: 80px; background: #eef4ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fa fa-file-text-o" style="font-size: 32px; color: var(--accent);"></i>
                                </div>
                            </div>
                            <h2 style="font-weight: 700; font-size: 24px; margin-bottom: 12px;">Reading Material</h2>
                            <p style="color: var(--text-muted); font-size: 16px; margin-bottom: 32px;">This module contains
                                interactive content and reading materials.</p>

                            <div id="lec_content"
                                style="text-align: left; background:#f8f9fa; padding: 20px; border-radius: 8px; border: 1px dashed var(--border-color);">
                                <span id="loading" style="color: var(--text-muted);"><i class="fa fa-spinner fa-spin"></i>
                                    Loading content structure...</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </main>

            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="sidebar-header">
                    <h3>Course Content</h3>
                </div>
                <ul class="lecture-list">
                    <?php if (!empty($all_leture)):
                        $i = 1;
                        foreach ($all_leture as $lec):
                            $is_completed = in_array($lec['id'], $completed_lectures);
                            ?>
                            <li
                                class="lecture-item <?php echo ($this->active_lecture == $lec['id']) ? 'active' : ''; ?> <?php echo $is_completed ? 'completed' : ''; ?>">
                                <a href="<?php echo base_url('courses/lecture/' . $lec['cl_course_id'] . '/' . $lec['id']); ?>"
                                    class="lecture-link">
                                    <span class="lecture-number"><?php echo $i++; ?>.</span>
                                    <div class="lecture-info">
                                        <span class="lecture-title"><?php echo $lec['cl_name']; ?></span>
                                        <div class="lecture-meta">
                                            <i
                                                class="fa <?php echo ($lec['cl_type'] == '3') ? 'fa-play-circle' : 'fa-file-text'; ?>"></i>
                                            <span><?php echo ($lec['cl_type'] == '3') ? 'Video Lecture' : 'Reading Material'; ?></span>
                                        </div>
                                    </div>
                                    <i class="fa fa-check-circle"></i>
                                </a>
                            </li>
                        <?php endforeach; else: ?>
                        <li class="padding-24 text-center" style="color: var(--text-muted); padding: 40px 20px;">
                            <i class="fa fa-folder-open-o fa-3x"
                                style="opacity: 0.3; margin-bottom: 15px; display: block;"></i>
                            No lectures found.
                        </li>
                    <?php endif; ?>
                </ul>
            </aside>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
    <script>
        <?php if ($lecture['cl_type'] == '3'): ?>
            function getYoutubeId(url) {
                var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                var match = url.match(regExp);
                return (match && match[2].length == 11) ? match[2] : null;
            }

            const videoFile = '<?php echo $lecture['cl_file_name']; ?>';
            const videoId = getYoutubeId(videoFile);

            const player = new Plyr('#player', {
                // No 'quality' item: Plyr's quality menu only works for self-hosted video, not YouTube
                settings: ['captions', 'speed', 'loop'],
                youtube: {
                    noCookie: true,
                    rel: 0,
                    showinfo: 0,
                    iv_load_policy: 3,
                    modestbranding: 1
                }
            });

            if (videoId) {
                player.source = {
                    type: 'video',
                    sources: [{
                        src: videoId,
                        provider: 'youtube',
                    }],
                };

                // YouTube removed every API for choosing quality (setPlaybackQuality / vq= are ignored) and picks
                // it from the player's pixel size + connection speed. So the iframe is rendered at the pixel size of
                // the wanted quality and scaled to fit: the Quality menu below sets that size. Auto uses 1080p size on
                // tablets/desktops and the default on phones (saves mobile data). YouTube still drops lower on slow
                // connections, so a choice is the quality to aim for, not a guarantee.
                const QUALITIES = {
                    hd2160: { width: 3840, label: '2160p 4K' },
                    hd1440: { width: 2560, label: '1440p' },
                    hd1080: { width: 1920, label: '1080p' },
                    hd720: { width: 1280, label: '720p' },
                    large: { width: 854, label: '480p' },
                    medium: { width: 640, label: '360p' },
                    small: { width: 426, label: '240p' },
                    tiny: { width: 256, label: '144p' }
                };
                const QUALITY_KEY = 'lecture_quality';
                let chosenQuality = 'auto';
                try { chosenQuality = localStorage.getItem(QUALITY_KEY) || 'auto'; } catch (e) { }
                if (chosenQuality !== 'auto' && !QUALITIES[chosenQuality]) chosenQuality = 'auto';
                let availableLevels = [];

                // Quality in use for this video: a saved choice this video doesn't have falls back to Auto
                function activeQuality() {
                    return (chosenQuality !== 'auto' && (!availableLevels.length || availableLevels.indexOf(chosenQuality) !== -1)) ? chosenQuality : 'auto';
                }

                function fitHqPlayer() {
                    const wrap = document.querySelector('.plyr__video-embed');
                    const frame = wrap && wrap.querySelector('iframe');
                    if (!frame || !wrap.clientWidth) return;
                    const q = activeQuality();
                    const width = q !== 'auto' ? QUALITIES[q].width : (window.innerWidth >= 768 ? 1920 : 0);
                    if (!width) {
                        frame.style.width = frame.style.height = frame.style.transform = '';
                        return;
                    }
                    const scale = wrap.clientWidth / width;
                    frame.style.transformOrigin = '0 0';
                    frame.style.width = width + 'px';
                    frame.style.height = (wrap.clientHeight / scale) + 'px';
                    frame.style.transform = 'scale(' + scale + ')';
                }

                // Quality button + menu in Plyr's control bar
                function buildQualityMenu() {
                    const controls = document.querySelector('.plyr__controls');
                    if (!controls || document.getElementById('qualityMenu')) return;
                    const box = document.createElement('div');
                    box.id = 'qualityMenu';
                    box.className = 'plyr__controls__item quality-menu';
                    box.innerHTML = '<button type="button" class="plyr__control quality-btn" aria-haspopup="true" aria-expanded="false" aria-label="Video quality"><span class="quality-btn-text">Auto</span></button><div class="quality-list" role="menu" hidden></div>';
                    const anchor = controls.querySelector('[data-plyr="fullscreen"]');
                    controls.insertBefore(box, anchor || null);

                    const btn = box.querySelector('.quality-btn');
                    const list = box.querySelector('.quality-list');
                    const toggle = function (open) {
                        list.hidden = !open;
                        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                    };
                    btn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        toggle(list.hidden);
                    });
                    list.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const item = e.target.closest('[data-quality]');
                        if (!item) return;
                        chosenQuality = item.getAttribute('data-quality');
                        try { localStorage.setItem(QUALITY_KEY, chosenQuality); } catch (err) { }
                        fitHqPlayer();
                        renderQualityMenu();
                        toggle(false);
                    });
                    document.addEventListener('click', function () { toggle(false); });
                    renderQualityMenu();
                }

                function renderQualityMenu() {
                    const list = document.querySelector('#qualityMenu .quality-list');
                    if (!list) return;
                    const active = activeQuality();
                    let html = '';
                    availableLevels.forEach(function (level) {
                        if (QUALITIES[level]) {
                            html += '<button type="button" role="menuitemradio" data-quality="' + level + '" aria-checked="' + (active === level) + '" class="quality-item' + (active === level ? ' is-active' : '') + '">' + QUALITIES[level].label + '</button>';
                        }
                    });
                    html += '<button type="button" role="menuitemradio" data-quality="auto" aria-checked="' + (active === 'auto') + '" class="quality-item' + (active === 'auto' ? ' is-active' : '') + '">Auto</button>';
                    list.innerHTML = html;
                    updateQualityLabel();
                }

                // Button shows the choice, and for Auto what is playing right now
                function updateQualityLabel() {
                    const text = document.querySelector('#qualityMenu .quality-btn-text');
                    if (!text) return;
                    const active = activeQuality();
                    const playing = player.embed && player.embed.getPlaybackQuality ? player.embed.getPlaybackQuality() : '';
                    text.textContent = active !== 'auto' ? QUALITIES[active].label : ('Auto' + (QUALITIES[playing] ? ' (' + QUALITIES[playing].label + ')' : ''));
                }

                // YouTube only reports a video's levels once it has started loading
                setInterval(function () {
                    const embed = player.embed;
                    if (!embed || !embed.getAvailableQualityLevels) return;
                    const levels = (embed.getAvailableQualityLevels() || []).filter(function (l) { return QUALITIES[l]; });
                    if (levels.length && levels.join() !== availableLevels.join()) {
                        availableLevels = levels;
                        fitHqPlayer();
                        renderQualityMenu();
                    } else {
                        updateQualityLabel();
                    }
                }, 2000);

                player.on('ready', function () {
                    fitHqPlayer();
                    buildQualityMenu();
                    const wrap = document.querySelector('.plyr__video-embed');
                    if (wrap && window.ResizeObserver) new ResizeObserver(fitHqPlayer).observe(wrap); // resize + fullscreen
                });
                window.addEventListener('resize', fitHqPlayer);
            }

            player.on('ended', event => {
                markAsComplete();
            });
        <?php endif; ?>

        const btnMarkComplete = document.getElementById('btnMarkComplete');
        btnMarkComplete.addEventListener('click', function () {
            markAsComplete();
        });

        function markAsComplete() {
            const lectureId = '<?php echo $lecture['id']; ?>';
            const courseId = '<?php echo $lecture['cl_course_id']; ?>';

            const formData = new FormData();
            formData.append('lecture_id', lectureId);
            formData.append('course_id', courseId);
            formData.append(csrf_name, csrf_token);

            fetch('<?php echo site_url('courses/mark_complete'); ?>', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        btnMarkComplete.innerHTML = '<i class="fa fa-check"></i> Completed';
                        btnMarkComplete.classList.add('active');
                        // Mark sidebar item as completed
                        const activeItem = document.querySelector('.lecture-item.active');
                        if (activeItem) activeItem.classList.add('completed');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

</body>

</html>