<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habnest | Properties</title>
    <link rel="stylesheet" href="./assets/css/properties.css">
    <link rel="shortcut icon" href="./assets/imgs/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/home.css" />

    <script src="./assets/js/properties.js" defer></script>
</head>
<body>
    <?php
        include("./includes/navbar.php");
    ?>
    <div class="container">
        <header>
            <h1>All Properties</h1>
            <div class="header-actions">
                <span><i class="fa-solid fa-house-chimney"></i><span class="count"></span> Properties Available</span>
                <!-- <button class="filter-btn"><i class="fa-solid fa-filter"></i> Filters</button> -->
            </div>
        </header>

        <!-- <nav class="filter-bar">
            <div class="filter-group search-group">
                <label for="search">Search Properties</label>
                <input type="text" id="search" placeholder="Search by city or location...">
            </div>
            <div class="filter-group">
                <label for="price">Price Range</label>
                <input type="range" id="price" min="500" max="10000" value="7500">
                <span id="price-value-display" style="margin-left: 10px;"></span>
            </div>
            <div class="filter-group">
                <label for="location">Location</label>
                <select id="location">
                    <option>Select area</option>
                    <option>New York, USA</option>
                    <option>Miami, Florida</option>
                     <option>Austin, Texas</option>
                </select>
            </div>
        </nav> -->

        <main>
            <section class="property-section">
                <h2><span class="count"></span><span> Properties found</span></h2>
                <div class="property-grid all-properties">
                </div>
            </section>
        </main>
    </div>
</body>
</html>