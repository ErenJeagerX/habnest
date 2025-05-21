<?php

if($_SERVER['CONTENT_TYPE'] === 'application/json') {
    require_once '../includes/db.php';

    $landlord_data = json_decode(file_get_contents("php://input"), 1);
    $landlord_id = $landlord_data['id'];
    $landlord_name = $landlord_data['first_name'];

    $query = "DELETE FROM users WHERE id = ? && role = 'landlord'";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $landlord_id);
    $stmt->execute();
    if($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => true, 'first_name' => $landlord_name]);
    }
    $stmt->close();
    $conn->close();
}
else {
    header("Location: dashboard.php");
    die();
}