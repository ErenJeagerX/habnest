<?php
header('Content-Type: application/json');

// --- CONFIG ---
$uploadDir = __DIR__ . '/../uploads/properties/';
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$presetLat = "10.33";
$presetLng = "37.72";

// --- VALIDATION ---
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = $_POST['price'] ?? '';
$bedrooms = $_POST['bedrooms'] ?? '';
$lat = $_POST['lat'] ?? '';
$lng = $_POST['lng'] ?? '';
$coverImageName = $_POST['cover_image'] ?? '';

$error = '';

// Basic validation (bedrooms: only check empty or 'select'))
if (
    $title === '' || strlen($title) < 10
) $error = "Title must be at least 10 characters.";
elseif (
    $description === '' || strlen($description) < 20
) $error = "Description must be at least 20 characters.";
elseif (
    $price === '' || !is_numeric($price) || $price < 1
) $error = "Price must be a positive number.";
elseif (
    $bedrooms === '' || strtolower($bedrooms) === 'select'
) $error = "Please select a number of bedrooms.";
elseif (
    $lat === '' || $lng === '' || ($lat == $presetLat && $lng == $presetLng)
) $error = "Please select a valid location.";
elseif (
    !isset($_FILES['files']) || count($_FILES['files']['name']) !== 3
) $error = "Please upload exactly 3 images.";

// File type validation
if (!$error) {
    foreach ($_FILES['files']['type'] as $type) {
        if (!in_array($type, $allowedTypes)) {
            $error = "All files must be valid images (jpg, png, gif, webp).";
            break;
        }
    }
}

// --- FILE UPLOAD ---
$savedFiles = [];
if (!$error) {
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    foreach ($_FILES['files']['tmp_name'] as $idx => $tmpName) {
        $originalName = $_FILES['files']['name'][$idx];
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $uniqueName = uniqid('img_', true) . '.' . $ext;
        $relativePath = 'uploads/properties/' . $uniqueName;
        $targetPath = $uploadDir . $uniqueName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            $savedFiles[$originalName] = $relativePath;
        } else {
            $error = "Failed to upload image: $originalName";
            break;
        }
    }
    if (!$error && count($savedFiles) !== 3) {
        $error = "Failed to save all images.";
    }
}

// --- DB INSERT ---
if (!$error) {
    require_once '../includes/db.php'; // adjust path as needed

    $coverUnique = $savedFiles[$coverImageName] ?? reset($savedFiles);

    // Cast to correct types for DB
    $price = floatval($price);
    $lat = floatval($lat);
    $lng = floatval($lng);

    $stmt = $conn->prepare("INSERT INTO properties (title, description, price, bedrooms, latitude, longitude, property_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdddds", $title, $description, $price, $bedrooms, $lat, $lng, $coverUnique);
    if (!$stmt->execute()) {
        $error = "Database error: could not insert property.";
    } else {
        $propertyId = $conn->insert_id;
        $imgStmt = $conn->prepare("INSERT INTO property_imgs (property_id, img_name) VALUES (?, ?)");
        foreach ($savedFiles as $orig => $relativePath) {
            if ($relativePath !== $coverUnique) {
                $imgStmt->bind_param("is", $propertyId, $relativePath);
                if (!$imgStmt->execute()) {
                    $error = "Database error: could not insert images.";
                    break;
                }
            }
        }
    }
}

// --- RESPONSE ---
echo json_encode([
    'success' => $error === '',
    'error' => $error
]);