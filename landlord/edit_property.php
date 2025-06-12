<?php

require_once '../includes/db.php';

$title = trim($_POST['title']);
$description = trim($_POST['description']);
$price = trim($_POST['price']);
$bedrooms = trim($_POST['bedrooms']);
$latitude = trim($_POST['lat']);
$longitude = trim($_POST['lng']);
$cover_index = isset($_POST['cover_index']);


$get_id = $_GET['id'];
// update property
if (isset($_POST['update'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $bedrooms = trim($_POST['bedrooms']);
    $latitude = trim($_POST['lat']);
    $longitude = trim($_POST['lng']);
    $cover_index = isset($_POST['cover_index']);
    $query = mysqli_query($conn, "UPDATE property_imgs 
    SET title='$title', description='$description', price='$price', bedrooms ='$bedrooms', latitude = '$latitude', longitude = '$longitude', cover_index = '$cover_index' WHERE id='$get_id'");
    if ($query) {
        echo "<script>
            alert('Updated successfully !!');
        </script>";
    }
}
?>