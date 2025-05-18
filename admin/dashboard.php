<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habnest | Admin Dashboard</title>
    <link rel="shortcut icon" href="../assets/imgs/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css<?php echo "?v=" . time()?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../assets/JS/dashboard-admin.js?v=<?php echo time() ?>" defer type="module"></script>
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
                    <div class="nav-name">Properties</div>
                </a></li>
                <li class="nav-link"><a href="#landlords">
                    <i class="fas fa-user-group nav-icon"></i>
                    <div class="nav-name">Landlords</div>
                </a></li>
            </ul>
            <div class="admin-info">Admin <span>Biniyam</span></div>
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
                        <div class="dashboard_card stats_card property_stats">
                            <i class="fas fa-building stats-icon"></i>
                            <h2 class="stats_number">1,200</h2>
                            <p class="stats_title">Properties</p>
                        </div>
                        <div class="dashboard_card stats_card landlords_stats">
                            <i class="fas fa-user-group stats-icon"></i>
                            <h2 class="stats_number">1,200</h2>
                            <p class="stats_title">Landlords</p>
                        </div>
                        <div class="dashboard_card stats_card admins_stats">
                            <i class="fas fa-user-shield stats-icon"></i>
                            <h2 class="stats_number">3</h2>
                            <p class="stats_title">Admins</p>
                        </div>
                    </div>
                    <!-- statistics end -->
                     <!-- recent listings start -->
                    <div class="dashboard_card dashboard_recent-listings">
                        <h3>Recent Listings</h3>
                        <div class="row thead">
                            <p>Property Name</p>
                            <p>Location</p>
                            <p>Landlord</p>
                            <p>Date Added</p>
                        </div>
                        <div class="tbody">
                            <div class="row row_body">
                                <p class="property-name">Spacious Villa</p>
                                <p class="property-location">Addis Ababa</p>
                                <p class="property-landlord">Abebe</p>
                                <p class="property-date">2025 - 08 - 06</p>
                            </div>
                            <div class="row row_body">
                                <p class="property-name">Spacious Villa</p>
                                <p class="property-location">Addis Ababa</p>
                                <p class="property-landlord">Abebe</p>
                                <p class="property-date">2025 - 08 - 06</p>
                            </div>
                            <div class="row row_body">
                                <p class="property-name">Spacious Villa</p>
                                <p class="property-location">Addis Ababa</p>
                                <p class="property-landlord">Abebe</p>
                                <p class="property-date">2025 - 08 - 06</p>
                            </div>
                        </div>
                    </div>
                    <!-- recent listings end -->
                </div>
                <!-- section content end -->
            </section>
            <!-- home section end -->
            <!-- properties section start -->
            <section id="properties">
                <div class="section_body">
                    <h2 class="section_title">View Properties</h2>
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
                                        <div class="selected_text">Size</div>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                    <div class="options">
                                        <div class="option">Very Small</div>
                                        <div class="option">Small</div>
                                        <div class="option">Medium</div>
                                        <div class="option">Large</div>
                                        <div class="option">Very Large</div>
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
                                    <p>Landlord</p>
                                    <p>Address</p>
                                    <p>Actions</p>
                                </div>
                            </div>
                            <div class="tbody">
                                <div class="row">
                                    <div class="ppty-img">
                                        <img src="../assets/imgs/Property 1.jpg" alt="property 1" class="property_image">
                                    </div>
                                    <p class="property_name">Modern Apartment</p>
                                    <p class="property_landlord">Abebe kebede</p>
                                    <p class="property_address">Bole street 123</p>
                                    <div class="actions">
                                        <div class="action edit-ppty">
                                            <i class="fas fa-pencil edit-icon"></i>
                                            <div class="action_title">View</div>
                                        </div>
                                        <div class="action delete-ppty open-modal" data-modal="modal-delete-ppty">
                                            <i class="fas fa-trash delete-icon"></i>
                                            <div class="action_title">Delete</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="ppty-img">
                                        <img src="../assets/imgs/Property 2.jpg" alt="property 2" class="property_image">
                                    </div>
                                    <p class="property_name">Modern Apartment</p>
                                    <p class="property_landlord">Abebe kebede</p>
                                    <p class="property_address">Bole street 123</p>
                                    <div class="actions">
                                        <div class="action edit-ppty">
                                            <i class="fas fa-pencil edit-icon"></i>
                                            <div class="action_title">View</div>
                                        </div>
                                        <div class="action delete-ppty open-modal" data-modal="modal-delete-ppty">
                                            <i class="fas fa-trash delete-icon"></i>
                                            <div class="action_title">Delete</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="ppty-img">
                                        <img src="../assets/imgs/Property 3.jpg" alt="property 3" class="property_image">
                                    </div>
                                    <p class="property_name">Modern Apartment</p>
                                    <p class="property_landlord">Abebe kebede</p>
                                    <p class="property_address">Bole street 123</p>
                                    <div class="actions">
                                        <div class="action edit-ppty">
                                            <i class="fas fa-pencil edit-icon"></i>
                                            <div class="action_title">View</div>
                                        </div>
                                        <div class="action delete-ppty open-modal" data-modal="modal-delete-ppty">
                                            <i class="fas fa-trash delete-icon"></i>
                                            <div class="action_title">Delete</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="ppty-img">
                                        <img src="../assets/imgs/Property 1.jpg" alt="property 4" class="property_image">
                                    </div>
                                    <p class="property_name">Modern Apartment</p>
                                    <p class="property_landlord">Abebe kebede</p>
                                    <p class="property_address">Bole street 123</p>
                                    <div class="actions">
                                        <div class="action edit-ppty">
                                            <i class="fas fa-pencil edit-icon"></i>
                                            <div class="action_title">View</div>
                                        </div>
                                        <div class="action delete-ppty open-modal" data-modal="modal-delete-ppty">
                                            <i class="fas fa-trash delete-icon"></i>
                                            <div class="action_title">Delete</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="ppty-img">
                                        <img src="../assets/imgs/Property 2.jpg" alt="property 5" class="property_image">
                                    </div>
                                    <p class="property_name">Modern Apartment</p>
                                    <p class="property_landlord">Abebe kebede</p>
                                    <p class="property_address">Bole street 123</p>
                                    <div class="actions">
                                        <div class="action edit-ppty">
                                            <i class="fas fa-pencil edit-icon"></i>
                                            <div class="action_title">View</div>
                                        </div>
                                        <div class="action delete-ppty open-modal" data-modal="modal-delete-ppty">
                                            <i class="fas fa-trash delete-icon"></i>
                                            <div class="action_title">Delete</div>
                                        </div>
                                    </div>
                                </div>
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
            <!-- landlords section start -->
            <section id="landlords">
                <div class="section_body">
                    <div class="section_header">
                        <h1 class="section_title">Landlords</h1>
                        <div class="add-landlords-btn open-modal" data-modal="modal-landlords">
                            <i class="fas fa-plus"></i>
                            <div>Add Landlords</div>
                        </div>
                    </div>
                    <!-- search landlords start -->
                    <div class="search_table landlords_search dashboard_card">
                        <div class="search-bar">
                            <input type="search" name="search_landlords" id="searchLandlords" placeholder="Search landlords...">
                            <i class="fas fa-search search-icon"></i>
                        </div>
                        <div class="filter_table filter-ppties">
                            <div class="select">
                                <div class="selected">
                                    <div class="selected_text">Properties Count</div>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="options">
                                    <div class="option">Ascending</div>
                                    <div class="option">Descending</div>
                                </div>
                            </div>
                            <div class="select">
                                <div class="selected">
                                    <div class="selected_text">Last Active</div>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="options">
                                    <div class="option">Most Active</div>
                                    <div class="option">Least Active</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- search landlords end -->
                    <!-- landlords table start -->
                     <div class="landlords_table dashboard_card">
                        <div class="thead">
                            <div class="row">
                                <p>Name</p>
                                <p>Phone Number</p>
                                <p>Properties</p>
                                <p>Last Active</p>
                                <p>Actions</p>
                            </div>
                        </div>
                        <div class="tbody">
                            
                        </div>
                     </div>
                    <!-- landlords table end -->
                </div>
            </section>
            <!-- landlords section end -->
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
        <!-- delete landlord modal -->
        <div class="modal modal-delete-landlord">
            <p>Are you sure you want to delete this landlord?</p>
            <div class="modal-btns">
                <div class="modal-btn delete-modal">Yes, delete</div>
                <div class="modal-btn close-modal" data-modal="modal-delete-landlord">Cancel</div>
            </div>
        </div>
        <!-- add landlords modal-->
        <div class="modal modal-landlords">
            <h2>Add landlord</h2>
            <i class="fas fa-close close-modal" data-modal="modal-landlords"></i>
            <form id="add-landlords">
                <div class="userInput">
                    <div class="input-field">
                        <input data-name="First Name" type="text" name="fName" id="fName" placeholder="First Name" class="nameInput">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="errors">
                        <p data-error="emptyInput"></p>
                        <p data-error="invalidInput"></p>
                        <p data-error="length"></p>
                    </div>
                </div>
                <div class="userInput">
                    <div class="input-field">
                        <input data-name="Last Name" type="text" name="lName" id="lName" placeholder="Last Name" class="nameInput">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="errors">
                        <p data-error="emptyInput"></p>
                        <p data-error="invalidInput"></p>
                        <p data-error="length"></p>
                    </div>
                </div>
                <div class="userInput">
                    <div class="input-field">
                        <input data-name="Username" type="text" name="username" id="username" placeholder="Username">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="errors">
                        <p data-error="emptyInput"></p>
                        <p data-error="invalidInput"></p>
                        <p data-error="length"></p>
                    </div>
                </div>
                <div class="userInput">
                    <div class="input-field">
                        <input data-name="Password" type="password" name="pwd" id="pwd" placeholder="Password">
                        <i class="fas fa-lock"></i> <i class="fas fa-pencil-slash show-pwd hidden" id="showPwd"></i>
                    </div>
                    <div class="errors">
                        <p data-error="emptyInput"></p>
                        <p data-error="invalidInput"></p>
                        <p data-error="length"></p>
                    </div>
                </div>
                <div class="userInput">
                    <div class="input-field">
                        <input data-name="Phone Number" type="text" name="pNum" id="pNum" placeholder="Phone number">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="errors">
                        <p data-error="emptyInput"></p>
                        <p data-error="invalidInput"></p>
                        <p data-error="length"></p>
                    </div>
                </div>
                <button type="submit">Add Landlord</button>
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