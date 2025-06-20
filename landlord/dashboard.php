<?php
if(session_id() == ""){
   session_start();
}

if (!isset($_SESSION['name']) || $_SESSION['role'] !== 'landlord') {
    header('Location: ../login.php');
}
else {
    require_once '../includes/db.php';
    $landlord_id = $_SESSION['id'];
    $sql = 'SELECT * FROM properties where landlord_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $landlord_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $properties = $result->fetch_all(MYSQLI_ASSOC);
    $count = count($properties);
    $rented = 0;
    $available = 0;
    foreach($properties as $property){
        if($property['status'] === 'rented'){
            $rented++;
        }
        elseif($property['status'] === 'available') {
            $available++;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habnest | Dashboard</title>
    <link rel="shortcut icon" href="../assets/imgs/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css<?php echo "?v=" . time()?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../assets/JS/dashboard-landlord.js<?php echo "?v=" . time()?>" defer type="module"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
</head>
<body>
    <div class="wrapper-dashboard">
        <!-- dashboard sidebar start -->
        <div class="dashboard_sidebar">
            <ul class="nav-links">
                <li class="nav-link active"><a href="#home">
                    <i class="fas fa-home nav-icon"></i>
                    <div class="nav-name">Dashboard</div>
                </a></li>
                <li class="nav-link"><a href="#properties">
                    <i class="fas fa-building nav-icon"></i>
                    <div class="nav-name">View Properties</div>
                </a></li>
                <li class="nav-link"><a href="#add-properties">
                    <i class="fas fa-square-plus nav-icon"></i>
                    <div class="nav-name">Add Properties</div>
                </a></li>
                <li class="nav-link logout-btn"><a href="../includes/logout.php">
                    <i class="fas fa-sign-out-alt nav-icon"></i>
                    <div class="nav-name">Logout</div>
                </a></li>
            </ul>
            <div class="admin-info">Landlord <span><?php echo $_SESSION['name'] ?></span></div>
        </div>
        <!-- dashboard sidebar end -->
        <!-- dashboard content start-->
        <div class="dashboard_content">
            <!-- home section start -->
            <section id="home">
                <!-- dashboard header start -->
                <div class="dashboard_header">
                    <h2>Dashboard</h2>
                </div>
                <!-- dashboard header end -->
                 <!-- section content start -->
                <div class="section_body">
                    <!-- statistics start -->
                    <div class="dashboard_statistics">
                        <div class="dashboard_card stats_card property_total_stats">
                            <i class="fas fa-building stats-icon"></i>
                            <h2 class="stats_number"><?php echo $count ?></h2>
                            <p class="stats_title">Properties</p>
                        </div>
                        <div class="dashboard_card stats_card property_rented_stats">
                            <i class="fas fa-building stats-icon"></i>
                            <h2 class="stats_number"><?php echo $rented?></h2>
                            <p class="stats_title">Rented</p>
                        </div>
                        <div class="dashboard_card stats_card property_available_stats">
                            <i class="fas fa-building stats-icon"></i>
                            <h2 class="stats_number"><?php echo $available?></h2>
                            <p class="stats_title">Available</p>
                        </div>
                    </div>
                    <!-- statistics end -->
                </div>
                <!-- section content end -->
            </section>
            <!-- home section end -->
            <!-- properties section start -->
            <section id="properties">
                <div class="section_body">
                    <h2 class="section_title">Properties</h2>
                        <div class="search_table properties_search dashboard_card">
                            <div class="search-bar">
                                <input type="search" name="search_ppties" id="searchPpties" placeholder="Search properties...">
                                <i class="fas fa-search search-icon"></i>
                            </div>
                            <div class="filter_table filter-ppties">
                                <div class="select">
                                    <div class="selected">
                                        <div class="selected_text">Location</div>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                    <div class="options">
                                        <div class="option">Addis Ababa</div>
                                        <div class="option">Dire Dawa</div>
                                        <div class="option">Debre Markos</div>
                                    </div>
                                </div>
                                <div class="select">
                                    <div class="selected">
                                        <div class="selected_text">Status</div>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                    <div class="options">
                                        <div class="option">Rented</div>
                                        <div class="option">Available</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ppties table start -->
                         <div class="table_filterable properties_table">
                            <div class="thead">
                                <div class="row">
                                    <p>Image</p>
                                    <p>Name</p>
                                    <p>Location</p>
                                    <p>Status</p>
                                    <p>Actions</p>
                                </div>
                            </div>
                            <div class="tbody properties-list">
                                
                            </div>
                            <div class="page-controls">
                                <div class="control previous">
                                    <i class="fas fa-arrow-left prev-btn"></i>
                                    <p>Previous</p>
                                </div>
                                <p class="current-page">2</p>
                                <div class="control next">
                                    <p>Next</p>
                                    <i class="fas fa-arrow-right nxt-btn"></i>
                                </div>
                            </div>
                         </div>
                        <!-- ppties table end -->
                </div>
            </section>
            <!-- properties section end -->
            <!-- add properties section start -->
             <section id="add-properties">
                <div class="section_body">
                    <h2 class="section_title">Add New Property</h2>
                    <form class="dashboard_card ppty-form" id="addNewPptyForm">
                        <div class="flex-container">
                            <div class="ppty-data">
                                <div class="ppty-details">
                                    <h3>Property Details</h3>
                                    <div class="userInput">
                                        <label for="property_title">Property title</label>
                                        <div class="input-field">
                                            <i class="fas fa-home"></i>
                                            <input type="text" id="property_title" placeholder="e.g. Spacious Apartment" name="title">
                                        </div>
                                        <div class="ppty-error hidden" data-input="property_title"></div>
                                    </div>
                                    <div class="userInput">
                                        <label for="property_description">Description</label>
                                        <div class="input-field descInputContainer">
                                            <i class="fas fa-home"></i>
                                            <textarea id="property_description" placeholder="Describe your property..." name="description"></textarea>
                                            <div class="charcount hidden">
                                                <span class="count"></span>
                                                <span class="maxcharlength">/ 150</span>
                                            </div>
                                        </div>
                                        <div class="ppty-error hidden" data-input="property_description"></div>
                                    </div>
                                    <div class="group-input">
                                        <div class="userInput">
                                            <label for="property_price">Price per Month (Br) </label>
                                            <div class="input-field">
                                                <i class="fas fa-dollar"></i>
                                                <input type="text" id="property_price" placeholder="e.g. 3000" name="price">
                                            </div>
                                            <div class="ppty-error hidden" data-input="property_price"></div>
                                        </div>
                                        <div class="userInput">
                                            <label for="property_bedrooms">Bedrooms</label>
                                            <div class="select" id="property_bedrooms">
                                                <div class="selected">
                                                    <div class="selected_text">Select</div>
                                                    <i class="fas fa-chevron-down"></i>
                                                </div>
                                                <div class="options">
                                                    <div class="option">1</div>
                                                    <div class="option">2</div>
                                                    <div class="option">3</div>
                                                    <div class="option">4</div>
                                                    <div class="option">5+</div>
                                                </div>
                                            </div>
                                            <div class="ppty-error hidden" data-input="bedrooms"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ppty-location">
                                    <h3>Location</h3>
                                    <div class="location-map" id="location-map">
                                    </div>
                                    <div class="location-data" id="location-data">
                                        <div class="latitude">
                                            <label>Latitude</label>
                                            <div class="location-box latitude-box" data-lat="10.33451">10.33</div>
                                        </div>
                                        <div class="longitude">
                                            <label>Longitude</label>
                                            <div class="location-box longitude-box" data-lng="37.72851">37.72</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ppty-data ppty-media">
                                <h3>Property Media</h3>
                                <div class="upload-media">
                                    <label for="upload-media" id="label_upload">
                                        <i class="fas fa-cloud"></i>
                                        <p>Click to select files</p>
                                    </label>
                                    <input type="file" id="upload-media" name="files[]" multiple>
                                </div>
                                <div class="uploaded-media">
                                    <label>Uploaded images</label>
                                    <div class="imgs">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit">Submit</button>
                    </form>
                </div>
             </section>
            <!-- add properties section end -->
        </div>
        <!-- dashboard content end-->
        <!--modals start -->
        <!-- delete property modal -->
        <div class="modal modal-delete-ppty">
            <p>Are you sure you want to delete this property?</p>
            <div class="modal-btns">
                <div class="modal-btn delete-modal">Yes, delete</div>
                <div class="modal-btn close-modal" data-modal="modal-delete-ppty">Cancel</div>
            </div>
        </div>
        <!-- edit property modal -->
        <div class="modal modal-edit-ppty">
            <i class="fas fa-close close-modal" data-modal="modal-edit-ppty"></i>
            <form class="ppty-form" id="editPptyForm">
                    
            </form>
        </div>
        <!-- bg layer when modal is active -->
        <div class="layer"></div>
        <!-- modals end -->
        <!-- status -->
        <div class="status">
        </div>
    </div>
</body>
</html>