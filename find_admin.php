<?php
// Script to list admin users
$mysqli = new mysqli("localhost", "root", "root", "zeyobron");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$sql = "SELECT u.id, u.username, u.email, ug.group_id 
        FROM users u 
        JOIN users_groups ug ON u.id = ug.user_id 
        WHERE ug.group_id = 1 
        LIMIT 5";

$result = $mysqli->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo "Error: " . $mysqli->error;
}
