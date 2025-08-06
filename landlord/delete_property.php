<?php
session_start();
$landlord_id = $_SESSION['id'];
if (!isset($landlord_id)) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

require_once '../includes/db.php';

$property_id = $_POST['property_id'];

if(!isset($property_id) || empty($property_id)) {
    echo json_encode(["success" => false, "message" => "Property ID is required."]);
    exit;
}
// Prepare and execute the delete statement
$sql = "DELETE FROM properties WHERE id = ? AND landlord_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $property_id, $landlord_id);
$stmt->execute();
$stmt->close();
if($conn->affected_rows > 0) {
    echo json_encode(["success" => true, "message" => "Property deleted successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Internal errors"]);
}
$conn->close();