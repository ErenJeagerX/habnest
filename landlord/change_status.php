<?php

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    require_once '../includes/db.php';
    if($_GET['status'] === 'available'){
        $sql = "UPDATE properties SET status = 'rented' where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            echo json_encode(['success' => true]);
            exit;
        }
        else {
            echo json_encode(['success' => false]);
            exit;
        }
        $stmt->close();
    }
    elseif($_GET['status'] === 'rented'){
        $sql = "UPDATE properties SET status = 'available' where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            echo json_encode(['success' => true]);
            exit;
        }
        else {
            echo json_encode(['success' => false]);
            exit;
        }
        $stmt->close();
    }
}
else {
    header("Location: ../index.php");
}