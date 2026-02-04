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
            --bg-dark: #0f172a;
            --bg-sidebar: #1e293b;
            --accent: #3b82f6;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --header-height: 60px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            margin: 0;
            overflow: hidden;
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
            background: #111;
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-bottom: 1px solid #333;
            z-index: 1001;
        }

        .btn-back {
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .btn-back:hover {
            color: var(--accent);
            text-decoration: none;
        }

        .btn-back i {
            margin-right: 8px;
            font-size: 18px;
        }

        .header-content {
            margin-left: 20px;
            flex: 1;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .course-title {
            font-size: 14px;
            font-weight: 600;
            display: block;
        }

        .lecture-name {
            font-size: 12px;
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
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Sidebar */
        .sidebar {
            width: 350px;
            background: var(--bg-sidebar);
            display: flex;
            flex-direction: column;
            border-left: 1px solid #334155;
        }

        .sidebar-header {
            padding: 15px 20px;
            border-bottom: 1px solid #334155;
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .lecture-list {
            flex: 1;
            overflow-y: auto;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .lecture-item {
            border-bottom: 1px solid #334155;
        }

        .lecture-link {
            display: flex;
            padding: 15px 20px;
            color: var(--text-main);
            text-decoration: none;
            transition: all 0.2s;
            align-items: center;
        }

        .lecture-link:hover {
            background: rgba(255, 255, 255, 0.05);
            text-decoration: none;
            color: var(--text-main);
        }

        .lecture-item.active .lecture-link {
            background: rgba(59, 130, 246, 0.15);
            border-left: 4px solid var(--accent);
            padding-left: 16px;
        }

        .lecture-number {
            font-size: 12px;
            color: var(--text-muted);
            margin-right: 15px;
            min-width: 20px;
        }

        .lecture-info {
            flex: 1;
        }

        .lecture-title {
            font-size: 14px;
            line-height: 1.4;
            display: block;
        }

        .lecture-meta {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Custom Scrollbar */
        .lecture-list::-webkit-scrollbar {
            width: 6px;
        }

        .lecture-list::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 3px;
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
                border-top: 1px solid #334155;
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
                padding: 0 15px;
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
            <a href="<?php echo site_url('courses/detail/' . str_replace(' ', '+', $lecture['cl_course_id'])); ?>"
                class="btn-back">
                <i class="fa fa-arrow-left"></i>
                <span>Back to Course</span>
            </a>
            <div class="header-content">
                <span
                    class="course-title"><?php echo $lecture['cl_course_id']; // This might be the ID, usually CI replaces it with name if joined ?></span>
                <span class="lecture-name"><?php echo $lecture['cl_name']; ?></span>
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
                        <div class="text-center" style="padding: 100px 20px;">
                            <i class="fa fa-file-text-o fa-4x" style="color: var(--text-muted);"></i>
                            <h4 style="margin-top: 20px;">Interactive Content</h4>
                            <p class="text-muted">Loading standard content...</p>
                            <div id="lec_content"
                                style="background:#fff; border-radius: 8px; overflow: hidden; margin-top: 30px;">
                                <span id="loading">Loading content structure...</span>
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
                        foreach ($all_leture as $lec): ?>
                            <li class="lecture-item <?php echo ($this->active_lecture == $lec['id']) ? 'active' : ''; ?>">
                                <a href="<?php echo base_url('courses/lecture/' . $lec['cl_course_id'] . '/' . $lec['id']); ?>"
                                    class="lecture-link">
                                    <span class="lecture-number"><?php echo $i++; ?>.</span>
                                    <div class="lecture-info">
                                        <span class="lecture-title"><?php echo $lec['cl_name']; ?></span>
                                        <div class="lecture-meta">
                                            <i class="fa fa-play-circle-o"></i> Video Lecture
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; else: ?>
                        <li class="padding-20 text-center color-muted">No lectures found.</li>
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
                settings: ['captions', 'quality', 'speed', 'loop']
            });

            if (videoId) {
                player.source = {
                    type: 'video',
                    sources: [{
                        src: videoId,
                        provider: 'youtube',
                    }],
                };
            }
        <?php endif; ?>
    </script>

</body>

</html>