<?php
// Comprehensive System Verification Script

// 1. Database Check
echo "=== Database Check ===\n";
try {
    $mysqli = new mysqli("localhost", "root", "root", "zeyobron");
    if ($mysqli->connect_errno) {
        throw new Exception("Failed to connect to MySQL: " . $mysqli->connect_error);
    }
    $result = $mysqli->query("SELECT 1");
    if ($result) {
        echo "[Pass] Database connection successful.\n";
    } else {
        throw new Exception("Simple query failed: " . $mysqli->error);
    }
} catch (Exception $e) {
    echo "[Fail] Database Error: " . $e->getMessage() . "\n";
}
echo "\n";

// 2. Memcached Check
echo "=== Memcached Check ===\n";
if (class_exists('Memcached')) {
    try {
        $memcached = new Memcached();
        $memcached->addServer('127.0.0.1', 11211);
        $memcached->set('test_key', 'test_value', 60);
        $val = $memcached->get('test_key');
        if ($val === 'test_value') {
            echo "[Pass] Memcached works correctly. Value stored and retrieved.\n";
        } else {
            echo "[Fail] Memcached value mismatch. Expected 'test_value', got '$val'.\n";
        }
    } catch (Exception $e) {
        echo "[Fail] Memcached Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "[Fail] Memcached class not found.\n";
}
echo "\n";

// 3. File Permissions Check
echo "=== File Permissions Check ===\n";
$dirs = [
    'application/logs',
    'application/cache'
];
foreach ($dirs as $dir) {
    if (is_writable($dir)) {
        echo "[Pass] $dir is writable.\n";
    } else {
        echo "[Fail] $dir is NOT writable.\n";
    }
}
echo "\n";

// 4. HTTP Endpoint Check
echo "=== HTTP Endpoint Check ===\n";
function check_url($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true); // HEAD request
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 400) {
        echo "[Pass] $url returned HTTP $httpCode.\n";
    } else {
        echo "[Fail] $url returned HTTP $httpCode.\n";
    }
}

check_url('http://local.zeyobron.com/');
check_url('http://local.zeyobron.com/auth/login');
echo "\n";

// 5. Check SaaS Subdomains (if applicable)
echo "=== SaaS Subdomain Check ===\n";
check_url('http://one.account.saas.local/');
check_url('http://one.lms.saas.local/');
