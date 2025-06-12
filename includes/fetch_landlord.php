<?php

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $landlord_id = $_POST['landlord_id'];

    require_once 'db.php';

    //fetch landlord details from the database
    $sql = "SELECT * FROM users WHERE id = ? and role = 'landlord'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $landlord_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $landlords = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $landlords[] = $row;
        }
        echo json_encode(["success" => true, "landlords" => $landlords]);
    } 
    else {
        echo json_encode(["success" => false, "message" => "No landlords found."]);
    }
}