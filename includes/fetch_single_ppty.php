<?php

if(isset($_SESSION['id']) && isset($_GET['ppty_id'])){
    $landlord_id = $_SESSION['id'];
    require_once 'db.php';
    $ppty_id = $_GET['ppty_id'];
    $stmt = $conn->prepare("SELECT * FROM properties WHERE id = ? && landlord_id = ?");
    $stmt->bind_param("ii", $ppty_id, $landlord_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
        $property = $result->fetch_assoc();
        echo json_encode(['success' => 'true', 'property' => $property]);
    } else {
        echo json_encode(['success' => 'false']);
    }
}
else {
    header("Location: ../index.php");
    exit();
}