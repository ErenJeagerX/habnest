<?php

require_once 'db.php';

// Fetch properties from the database

$sql = "SELECT * FROM properties";
$result = $conn->query($sql);
if ($result === false) {
    echo json_encode(["success" => false, "message" => "There is a problem with the server."]);
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