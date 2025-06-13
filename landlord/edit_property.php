<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

$landlord_id = $_SESSION['id'];

require_once '../includes/db.php';

$property_id = $_POST['property_id'] ?? null;
if (empty($property_id)) {
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "message" => "Property ID is required."]);
    exit;
}

$title = trim($_POST['title']);
$description = trim($_POST['description']);
$price = trim($_POST['price']);
$bedrooms = trim($_POST['bedrooms']);
$latitude = trim($_POST['lat']);
$longitude = trim($_POST['lng']);
$cover_index = isset($_POST['cover_index']) ? trim($_POST['cover_index']) : 0;

$get_id = $_GET['id'] ?? null;

if (!$get_id) {
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "message" => "Missing property ID in URL."]);
    exit;
}

if (isset($_POST['update'])) {
    $query = mysqli_query($conn, "UPDATE property_imgs 
        SET title='$title', description='$description', price='$price', bedrooms ='$bedrooms', latitude = '$latitude', longitude = '$longitude', cover_index = '$cover_index' 
        WHERE id='$get_id'");
    
    if ($query) {
        echo "<script>alert('Updated successfully !!');</script>";
    } else {
        echo "<script>alert('Update failed.');</script>";
    }
}
?>