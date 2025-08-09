<?php
if(isset($_GET['pid'])) {
    $ppty_id = $_GET['pid'];
    require_once 'includes/db.php';
    
    $stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
    $stmt->bind_param("i", $ppty_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $property = $result->fetch_assoc();
    } else {
        header("Location: properties.php");
        exit();
    }
} else {
    header("Location: properties.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo ucfirst($property['title']) ?></title>
  <link rel="shortcut icon" href="./assets/imgs/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="./assets/css/property_details.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script src="./assets/JS/property_details.js?v=<?php echo time()?>" defer></script>
</head>

<body>
  <div class="container">
    <!-- LEFT SECTION -->
    <div class="left-section">
      <div class="property_image">
        <img src="<?php echo "includes/" . $property['property_image'] ?>" alt="Gallery 1">
      </div>

      <h1><?php echo ucfirst($property['title']) ?></h1>
      <div class="price"><?php echo $property['price'] ?>/Month</div>
      <p class="description"><?php echo $property['description'] ?></p>

      <div class="property-info">
        <div><i class="fa-solid fa-bed"></i> <?php echo $property['bedrooms'] ?> Bedrooms</div>
      </div>

      <div class="gallery">
        <?php 
         $sql = "SELECT * FROM property_imgs WHERE property_id = ?";
         $stmt = $conn->prepare($sql);
         $stmt->bind_param("i", $ppty_id);
         $stmt->execute();
          $result = $stmt->get_result();
          if($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo '<img src="includes/' . $row['img_name'] . '" alt="Gallery Image">';
              }
          } else {
              echo '<p>No additional images available.</p>';
          }
        ?>
      </div>
    </div>

    <!-- RIGHT SECTION -->
    <div class="right-section">
      <div class="landlord-info">
        <div class="landlord_name">
          <img src="
          <?php 
           $sql = 'SELECT * FROM users WHERE id = ? && role="landlord"';
           $stmt = $conn->prepare($sql);
           $stmt->bind_param("i", $property['landlord_id']);
           $stmt->execute();
           $result = $stmt->get_result();
           if($result->num_rows > 0) {
               $landlord = $result->fetch_assoc();
               echo $landlord['profile_pic'];
           }
          ?>
          " alt="Landlord">
          <h3><?php echo $landlord['first_name'] . " " . $landlord['last_name'] ?></h3>
        </div>
        <a href="tel:<?php echo $landlord['phone_number']?>" class="contact-btn">Contact Landlord</a>
      </div>
      <div class="location-map" id="ppty-map" data-lat="<?php echo $property['latitude']?>" data-lng="<?php echo $property['longitude']?>">
      </div>
    </div>
  </div>
</body>

</html>