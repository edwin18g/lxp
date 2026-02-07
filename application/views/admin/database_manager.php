<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Manager - Admin</title>
    <!-- Assuming Admin theme has Bootstrap/Tailwind. Using generic styles for standalone safety -->
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 25px;
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .h1 {
            margin: 0;
            font-size: 1.5rem;
            color: #333;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .status-synced {
            background: #d4edda;
            color: #155724;
        }

        .status-diff {
            background: #f8d7da;
            color: #721c24;
        }

        .status-empty {
            background: #e2e3e5;
            color: #383d41;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .diff-viewer {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: monospace;
            white-space: pre;
            margin-top: 20px;
            display: none;
        }

        .actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .loader {
            display: none;
            color: #666;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="header">
            <h1 class="h1">Database Manager</h1>
            <span id="status-badge" class="status-badge status-empty">Unknown</span>
        </div>

        <div id="content-area">
            <p class="loader" id="loader">Processing...</p>

            <div id="status-message">
                Checking database status...
            </div>

            <div id="diff-container" class="diff-viewer"></div>

            <div class="actions">
                <button id="btn-check" class="btn btn-primary" onclick="checkSync()">Check Status</button>
                <button id="btn-install" class="btn btn-success" style="display:none;" onclick="installDB()">Install
                    Only (Empty DB)</button>
                <button id="btn-migrate-auto" class="btn btn-warning" style="display:none;"
                    onclick="autoMigrate()">Update Live Database (Deploy)</button>
                <button id="btn-update-schema" class="btn btn-danger" style="display:none; margin-left: 10px;"
                    onclick="updateSchema()">Force Update DB from File</button>
            </div>

            <div id="migration-container"
                style="display:none; margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px;">
                <h3 class="h1" style="font-size: 1.2rem; margin-bottom: 15px;">Pending Migrations (Missing Tables)</h3>
                <div id="migration-list" style="margin-bottom: 15px;"></div>
                <button id="btn-migrate" class="btn btn-warning" onclick="runMigration()">Execute Selected
                    Migrations</button>
            </div>
        </div>
    </div>

    <script>
        /* Use regex to extract base path up to database_manager, handling case sensitivity and trailing paths */
        const match = window.location.href.match(/^(.*\/database_manager)/i);
        const baseUrl = match ? match[1] + '/' : '<?php echo site_url("database_manager/"); ?>';

        /* Initial State from Controller */
        const isEmpty = <?php echo json_encode($is_empty); ?>;

        document.addEventListener('DOMContentLoaded', () => {
            if (isEmpty) {
                setStatus('empty', 'Database is Empty');
                document.getElementById('btn-install').style.display = 'inline-block';
            } else {
                checkSync();
            }
        });

        function setStatus(type, message) {
            const badge = document.getElementById('status-badge');
            const msgDiv = document.getElementById('status-message');

            badge.className = 'status-badge status-' + type;

            if (type === 'synced') badge.textContent = 'Synced';
            else if (type === 'diff') badge.textContent = 'Changes Detected';
            else if (type === 'empty') badge.textContent = 'Empty';
            else badge.textContent = 'Unknown';

            msgDiv.innerHTML = message;
        }

        function checkSync() {
            showLoader(true);
            fetch(baseUrl + 'get_diff')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok: ' + response.statusText);
                    return response.text();
                })
                .then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('JSON Parse Error:', e, 'Response Body:', text);
                        throw new Error('Invalid JSON response from server.');
                    }
                })
                .then(data => {
                    showLoader(false);
                    if (data.status === 'synced') {
                        setStatus('synced', 'Database is in sync with Code Schema.');
                        document.getElementById('diff-container').style.display = 'none';
                        document.getElementById('btn-migrate-auto').style.display = 'none';
                    } else if (data.status === 'diff') {
                        setStatus('diff', 'Differences detected between Code Schema and Live Database.');
                        const diffBox = document.getElementById('diff-container');
                        diffBox.textContent = data.diff;
                        diffBox.style.display = 'block';
                        /* Also check for migrations if diff exists */
                        checkMigration();
                    }
                })
                .catch(err => {
                    showLoader(false);
                    setStatus('error', 'Error checking sync: ' + err.message);
                });
        }

        function installDB() {
            if (!confirm('Are you sure? This will install the schema.sql file.')) return;

            showLoader(true);
            fetch(baseUrl + 'install')
                .then(response => response.json())
                .then(data => {
                    showLoader(false);
                    alert(data.message);
                    if (data.status === 'success') {
                        setTimeout(() => location.reload(), 1000);
                    }
                });
        }



        function autoMigrate() {
            /* Scroll to migration container or trigger the check */
            const container = document.getElementById('migration-container');
            if (container.style.display === 'none' || container.innerHTML === '') {
                alert('No automatic migrations available. Please check the diff manually.');
            } else {
                container.scrollIntoView({ behavior: 'smooth' });
                /* Optionally auto-click? No, let user confirm. */
            }
        }

        /* Migration Logic */
        function updateSchema() {
            if (!confirm('WARNING: You are about to run a Force Update. If the backend logic contains DROP statements, THIS WILL WIPE DATA.\n\nAre you sure you want to proceed?')) return;

            showLoader(true);
            fetch(baseUrl + 'update_schema')
                .then(response => response.json())
                .then(data => {
                    showLoader(false);
                    alert(data.message);
                    checkSync();
                });
        }

        function checkMigration() {
            fetch(baseUrl + 'get_migration')
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.migrations.length > 0) {
                        renderMigrations(data.migrations);
                        /* Show the auto migrate button if migrations exist */
                        document.getElementById('btn-migrate-auto').style.display = 'inline-block';
                        document.getElementById('btn-update-schema').style.display = 'inline-block';
                    } else {
                        document.getElementById('migration-container').style.display = 'none';
                        document.getElementById('btn-migrate-auto').style.display = 'none';
                        document.getElementById('btn-update-schema').style.display = 'inline-block';
                    }
                })
                .catch(console.error);
        }

        function renderMigrations(migrations) {
            const container = document.getElementById('migration-container');
            const list = document.getElementById('migration-list');
            list.innerHTML = '';

            migrations.forEach((mig, index) => {
                const div = document.createElement('div');
                div.style.marginBottom = '10px';
                div.style.background = '#fff3cd';
                div.style.padding = '10px';
                div.style.borderRadius = '5px';
                div.style.border = '1px solid #ffeeba';

                div.innerHTML = `
                    <label style="display:block;cursor:pointer;color:#856404;">
                        <input type="checkbox" class="mig-check" value="${index}" checked>
                        <strong>Add Missing Table:</strong> <code>${mig.table}</code>
                    </label>
                    <pre style="background:#fff;padding:5px;font-size:0.85em;margin-top:5px;border:1px solid #ddd;overflow-x:auto;">${mig.sql}</pre>
                `;
                list.appendChild(div);
            });

            container.style.display = 'block';
            window.currentMigrations = migrations;
        }

        function runMigration() {
            const checks = document.querySelectorAll('.mig-check:checked');
            if (checks.length === 0) return;

            const selectedQueries = [];
            checks.forEach(chk => {
                selectedQueries.push(window.currentMigrations[chk.value].sql);
            });

            if (!confirm('Run ' + selectedQueries.length + ' SQL statements to update the database?')) return;

            showLoader(true);
            fetch(baseUrl + 'execute_migration', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ queries: selectedQueries })
            })
                .then(res => res.json())
                .then(data => {
                    showLoader(false);
                    alert(data.message);
                    if (data.status === 'success' || data.status === 'partial_error') {
                        location.reload();
                    }
                });
        }

        function showLoader(show) {
            document.getElementById('loader').style.display = show ? 'block' : 'none';
        }
    </script>

</body>

</html>