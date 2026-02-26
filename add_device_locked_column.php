<?php
// Script to add device_locked column to users table
define('BASEPATH', 'scripts');
define('ENVIRONMENT', 'development');

require_once('application/config/database.php');

$db = $db['default'];

$mysqli = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if column exists
$checkSql = "SHOW COLUMNS FROM `users` LIKE 'device_locked'";
$result = $mysqli->query($checkSql);

if ($result->num_rows == 0) {
    // Disable strict mode to avoid '0000-00-00' date errors during ALTER
    $mysqli->query("SET SESSION sql_mode = ''");

    $sql = "ALTER TABLE `users` ADD COLUMN `device_locked` TINYINT(1) DEFAULT 0 AFTER `active`";
    if ($mysqli->query($sql) === TRUE) {
        echo "Column 'device_locked' added successfully.\n";
    } else {
        echo "Error adding column: " . $mysqli->error . "\n";
    }
} else {
    echo "Column 'device_locked' already exists.\n";
}

$mysqli->close();
?>