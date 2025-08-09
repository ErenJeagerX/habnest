<?php
require_once '../includes/db.php';

// Fetch properties from the database

$sql = "SELECT * FROM properties";
$result = $conn->query($sql);
if ($result === false) {
    echo json_encode(["success" => false, "message" => "Database query failed."]);
    exit;
}
$properties = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $properties[] = $row;
    }
    $sanitizedProperties = array_map(function($property) {
        foreach($property as $data => $value) {
            $property[$data] = htmlspecialchars($value);
        }
        return $property;
    }, $properties);
    echo json_encode(["success" => true, "properties" => $sanitizedProperties]);
} 
else {
    echo json_encode(["success" => false, "message" => "No properties found."]);
}