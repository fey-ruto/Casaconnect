<?php
include "../actions/update_listing.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewsport" content="width=device-width, initial-scale=1.0">
    <title>Update Listing - CasaConnect</title>
    <link rel="stylesheet" href="../css/create_listing.css"> <!-- Styles for this page -->
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">CasaConnect</div>
            <ul class="nav-links">
                <li><a href="../views/listing_management.php">Back</a></li> <!-- Link back to regular admin home page -->
            </ul>
        </nav>
    </header>
    <main>
        <section class="create-listing-section">
            <div class="form-container">
                <h2>Update Listing</h2>
                <form id="create-listing-form" action="#" method="post" enctype="multipart/form-data">
                    <label for="property-name">Property Name:</label>
                    <input type="text" id="property-name" name="property-name" placeholder="Enter property name" required>

                    <label for="property-location">Location:</label>
                    <input type="text" id="property-location" name="property-location" placeholder="Enter your location" required>

                    <label for="property-description">Description:</label>
                    <textarea id="property-description" name="property-description" placeholder="Describe the property you want/need." required></textarea>

                    <label for="property-price">Price:</label>
                    <input type="number" id="property-price" name="property-price" placeholder="Enter your preferred price." required>

                    <label for="property-images">Images:</label>
                    <input type="file" id="property-images" name="property-images[]" accept="image/*" multiple required>

                    <button type="submit" class="btn create-btn">Save</button>
                    <button type="button" class="btn cancel-btn" onclick="window.location.href='../views/listing_management.php'">Cancel</button>
                </form>
            </div>
        </section>
    </main>
    <script src="../js/validate_listing.js" defer></script>
</body>
</html>