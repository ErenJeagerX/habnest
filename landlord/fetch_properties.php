<?php
session_start();
require_once '../includes/db.php';

$landlord_id = $_SESSION['id'];
if (!isset($landlord_id)) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

// Fetch properties from the database

$sql = "SELECT * FROM properties where landlord_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $landlord_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
if ($result === false) {
    echo json_encode(["success" => false, "message" => "Database query failed."]);
    exit;
}
$properties = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $properties[] = $row;
    }
    echo json_encode(["success" => true, "properties" => $properties]);
} 
else {
    echo json_encode(["success" => false, "message" => "No properties found."]);
}