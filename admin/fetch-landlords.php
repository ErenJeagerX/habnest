<?php

require_once '../includes/db.php';

$query = "SELECT * FROM users where role = 'landlord'";

$users = $conn->query($query)->fetch_all(MYSQLI_ASSOC);

$sanitizedUsers = array_map(function($user) {
    foreach($user as $data => $value) {
        $user[$data] = htmlspecialchars($value);
    }
    return $user;
}, $users);

echo json_encode($sanitizedUsers);