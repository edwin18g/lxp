<?php
$mysqli = new mysqli("127.0.0.1", "root", "root", "zeyobron");
if ($mysqli->connect_errno) {
    echo "Failed: " . $mysqli->connect_error;
    exit();
}
$columns = $mysqli->query("SHOW COLUMNS FROM users");
while ($row = $columns->fetch_assoc()) {
    echo $row['Field'] . " " . $row['Type'] . "\n";
}
$groups = $mysqli->query("SELECT * FROM `groups`");
while ($row = $groups->fetch_assoc()) {
    echo $row['id'] . ": " . $row['name'] . " - " . $row['description'] . "\n";
}
$mysqli->close();
