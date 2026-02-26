<?php
// Standalone script to test get_users_by_id query
$mysqli = new mysqli("localhost", "root", "root", "zeyobron");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$id = 16279; // User ID from logs

$sql = "SELECT 
    users.id,
    users.first_name,
    users.last_name,
    users.username,
    users.email,
    users.mobile,
    users.address,
    users.gender,
    users.dob,
    users.profession,
    users.experience,
    users.about,
    users.image,
    users.language,
    users.active,
    users.role,
    users.date_added,
    users.date_updated,
    users.secure_key,
    (SELECT gr.name FROM `groups` gr WHERE gr.id = (SELECT ug.group_id FROM users_groups ug WHERE ug.user_id = users.id)) group_name
FROM users
WHERE id = $id";

$result = $mysqli->query($sql);

if (!$result) {
    echo "Query Error: " . $mysqli->error;
} else {
    $row = $result->fetch_assoc();
    print_r($row);
}
