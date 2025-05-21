<?php

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../includes/db.php';

    $first_name = ucfirst(trim($_POST['first_name']));
    $last_name = ucfirst(trim($_POST['last_name']));
    $username = trim($_POST['username']);
    $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
    $phone_number = trim($_POST['phone_number']);

    $query = "INSERT INTO users (first_name, last_name, username, pwd, phone_number, role) VALUES (?,?,?,?,?, 'landlord')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssss', $first_name, $last_name, $username, $pwd, $phone_number);
    $stmt->execute();

    if($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => true]);
    }

    $stmt->close();
    $conn->close();
} 
else {
    header("Location: dashboard.php");
    die();
}