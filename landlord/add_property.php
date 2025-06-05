<?php
session_start();
header('Content-Type: application/json');

// Database connection  
require_once '../includes/db.php';

// 1. Authenticate User: Check if landlord_id is in session
if (!isset($_SESSION['id'])) { // Assuming 'landlord_id' is set upon user login
    echo json_encode(['success' => false, 'error' => 'Authentication required. Please login.']);
    $conn->close();
    exit;
}
$landlord_id = (int)$_SESSION['id'];

// 2. Initialize variables and collect errors
$errors = [];
$responseData = ['success' => false];

// Retrieve and sanitize POST data
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = trim($_POST['price'] ?? '');
$bedrooms = trim($_POST['bedrooms'] ?? '');
$latitude = trim($_POST['lat'] ?? '');
$longitude = trim($_POST['lng'] ?? '');
$cover_index = isset($_POST['cover_index']) ? (int)$_POST['cover_index'] : -1;

// 3. Validate Inputs
if (empty($title)) {
    $errors[] = "Title is required.";
} elseif (strlen($title) < 5 || strlen($title) > 100) {
    $errors[] = "Title must be between 5 and 100 characters.";
}

if (empty($description)) {
    $errors[] = "Description is required.";
} elseif (strlen($description) < 20 || strlen($description) > 255) {
    $errors[] = "Description must be between 20 and 255 characters.";
}

if (empty($price)) {
    $errors[] = "Price is required.";
} elseif (!is_numeric($price) || (float)$price <= 0) {
    $errors[] = "Price must be a valid positive number.";
} else {
    $price = (float)$price; // Ensure it's a float for DB
}

if (empty($bedrooms) || $bedrooms === 'Select') {
    $errors[] = "Number of bedrooms is required.";
} elseif (strlen($bedrooms) > 10) {
    $errors[] = "Bedrooms value is too long (max 10 characters).";
}


if (empty($latitude) || !is_numeric($latitude)) {
    $errors[] = "A valid latitude is required.";
} else {
    $latitude = (float)$latitude;
}

if (empty($longitude) || !is_numeric($longitude)) {
    $errors[] = "A valid longitude is required.";
} else {
    $longitude = (float)$longitude;
}

if ($cover_index < 0 || $cover_index > 2) { // Assuming 3 images, so index 0, 1, or 2
    $errors[] = "Invalid cover image selection.";
}

// 4. Validate Uploaded Files
$uploadedFiles = $_FILES['files'] ?? null;
$processedImagePaths = []; // To store paths of successfully moved files for potential cleanup
$finalImagePaths = []; // To store paths relative to web root for DB
$coverImagePathForDB = null;
$otherImagePathsForDB = [];

define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$uploadDir = '../uploads/properties/'; // Relative to this script's location

if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0775, true)) {
        $errors[] = "Failed to create upload directory. Check server permissions.";
    }
}

if (empty($uploadedFiles) || !isset($uploadedFiles['name']) || count($uploadedFiles['name']) !== 3) {
    $errors[] = "Please upload exactly 3 images.";
} elseif (is_dir($uploadDir) && is_writable($uploadDir)) {
    for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
        if ($uploadedFiles['error'][$i] !== UPLOAD_ERR_OK) {
            $errors[] = "Error with image '" . htmlspecialchars($uploadedFiles['name'][$i]) . "': " . getUploadErrorMessage($uploadedFiles['error'][$i]);
            continue;
        }
        if ($uploadedFiles['size'][$i] > MAX_FILE_SIZE) {
            $errors[] = "Image '" . htmlspecialchars($uploadedFiles['name'][$i]) . "' exceeds 5MB limit.";
            continue;
        }
        
        // More robust MIME type check
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $uploadedFiles['tmp_name'][$i]);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedMimeTypes)) {
            $errors[] = "Invalid file type for '" . htmlspecialchars($uploadedFiles['name'][$i]) . "'. Allowed: JPEG, PNG, GIF, WEBP.";
            continue;
        }

        $fileExtension = strtolower(pathinfo($uploadedFiles['name'][$i], PATHINFO_EXTENSION));
        // Ensure extension matches mime type for common cases if desired, though mime check is primary
        if (($mimeType == 'image/jpeg' && !in_array($fileExtension, ['jpg', 'jpeg'])) ||
            ($mimeType == 'image/png' && $fileExtension != 'png') ||
            ($mimeType == 'image/gif' && $fileExtension != 'gif') ||
            ($mimeType == 'image/webp' && $fileExtension != 'webp')) {
            // $errors[] = "File extension mismatch for image '" . htmlspecialchars($uploadedFiles['name'][$i]) . "'.";
            // Allow if mime type is correct, extension is just for filename.
        }


        $newFileName = uniqid('img_', true) . '.' . $fileExtension;
        $destinationPath = $uploadDir . $newFileName;

        if (move_uploaded_file($uploadedFiles['tmp_name'][$i], $destinationPath)) {
            $processedImagePaths[] = $destinationPath; // Full path for cleanup
            $finalImagePaths[] = $destinationPath; // Path for DB (e.g., 'uploads/img_random.jpg')
        } else {
            $errors[] = "Failed to move uploaded image '" . htmlspecialchars($uploadedFiles['name'][$i]) . "'.";
        }
    }

    if (empty($errors) && count($finalImagePaths) === 3) {
        if (isset($finalImagePaths[$cover_index])) {
            $coverImagePathForDB = $finalImagePaths[$cover_index];
            for ($j = 0; $j < 3; $j++) {
                if ($j !== $cover_index) {
                    $otherImagePathsForDB[] = $finalImagePaths[$j];
                }
            }
        } else {
             // This case should ideally be caught by $cover_index validation or count($finalImagePaths) !== 3
            $errors[] = "Cover image index is invalid or mismatch with uploaded files.";
        }
    } elseif (count($finalImagePaths) !== 3 && empty($errors)) {
        // If loop completed without errors but not 3 images processed (e.g. move_uploaded_file failed silently for some)
        $errors[] = "An issue occurred processing images. Ensure 3 valid images were uploaded and processed.";
    }
} elseif (!is_dir($uploadDir) || !is_writable($uploadDir)) {
    $errors[] = "Upload directory is not writable or does not exist. Check server configuration.";
}


// 5. If errors, respond and exit
if (!empty($errors)) {
    // Clean up any files that were successfully moved before an error occurred
    foreach ($processedImagePaths as $path) {
        if (file_exists($path)) {
            unlink($path);
        }
    }
    $responseData['error'] = implode("\n", $errors);
    echo json_encode($responseData);
    $conn->close();
    exit;
}

// 6. Database Operations (Transaction)
$conn->begin_transaction();

try {
    // Insert into properties table
    $sql_property = "INSERT INTO properties (landlord_id, title, description, price, bedrooms, latitude, longitude, property_image) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_property = $conn->prepare($sql_property);
    if (!$stmt_property) {
        throw new Exception("Prepare statement failed (properties): " . $conn->error);
    }
    $stmt_property->bind_param("isssdsss", $landlord_id, $title, $description, $price, $bedrooms, $latitude, $longitude, $coverImagePathForDB);
    
    if (!$stmt_property->execute()) {
        throw new Exception("Execute failed (properties): " . $stmt_property->error);
    }
    $property_id = $conn->insert_id;
    $stmt_property->close();

    if ($property_id > 0 && !empty($otherImagePathsForDB)) {
        // Insert into property_imgs table
        $sql_property_img = "INSERT INTO property_imgs (property_id, img_name) VALUES (?, ?)";
        $stmt_img = $conn->prepare($sql_property_img);
        if (!$stmt_img) {
            throw new Exception("Prepare statement failed (property_imgs): " . $conn->error);
        }
        foreach ($otherImagePathsForDB as $imgPath) {
            $stmt_img->bind_param("is", $property_id, $imgPath);
            if (!$stmt_img->execute()) {
                // Log specific image path that failed if needed
                throw new Exception("Execute failed (property_imgs for path {$imgPath}): " . $stmt_img->error);
            }
        }
        $stmt_img->close();
    } elseif (empty($otherImagePathsForDB) && count($finalImagePaths) === 3) {
        // This implies cover_index was such that otherImagePathsForDB became empty,
        // which shouldn't happen if 3 images are processed and cover_index is 0, 1, or 2.
        // However, if logic allows for only 1 or 2 images and others are optional, this might be fine.
        // For "exactly 3 images", this is an anomaly if reached.
    }


    $conn->commit();
    $responseData['success'] = true;
    $responseData['message'] = "Property added successfully!";
    echo json_encode($responseData);

} catch (Exception $e) {
    $conn->rollback();
    // Clean up all processed images if DB operations fail
    foreach ($processedImagePaths as $path) {
        if (file_exists($path)) {
            unlink($path);
        }
    }
    http_response_code(500); // Internal Server Error
    $responseData['error'] = "An error occurred while saving the property: " . $e->getMessage();
    // For production, you might want a more generic error:
    // $responseData['error'] = "An internal error occurred. Please try again later.";
    echo json_encode($responseData);
}

$conn->close();

/**
 * Helper function to get user-friendly messages for UPLOAD_ERR_ constants.
 */
function getUploadErrorMessage($errorCode) {
    switch ($errorCode) {
        case UPLOAD_ERR_INI_SIZE:
            return "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
        case UPLOAD_ERR_FORM_SIZE:
            return "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
        case UPLOAD_ERR_PARTIAL:
            return "The uploaded file was only partially uploaded.";
        case UPLOAD_ERR_NO_FILE:
            return "No file was uploaded.";
        case UPLOAD_ERR_NO_TMP_DIR:
            return "Missing a temporary folder on the server.";
        case UPLOAD_ERR_CANT_WRITE:
            return "Failed to write file to disk on the server.";
        case UPLOAD_ERR_EXTENSION:
            return "A PHP extension stopped the file upload.";
        default:
            return "Unknown upload error.";
    }
}