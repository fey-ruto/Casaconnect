<?php
include '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['property-name']);
    $location = trim($_POST['property-location']);
    $description = trim($_POST['property-description']);
    $price = (float)$_POST['property-price'];

    // Handle file uploads
    $images = [];
    foreach ($_FILES['property-images']['tmp_name'] as $key => $tmp_name) {
        $filename = uniqid() . "-" . $_FILES['property-images']['name'][$key];
        move_uploaded_file($tmp_name, "../uploads/" . $filename);
        $images[] = "../uploads/" . $filename;
    }

    $images_path = implode(',', $images);

    $stmt = $conn->prepare("INSERT INTO listings (property_name, location, description, price, images, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("sssd", $name, $location, $description, $price, $images_path);

    if ($stmt->execute()) {
        echo "Listing submitted for approval!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Listing - CasaConnect</title>
    <link rel="stylesheet" href="../css/create_listing.css"> <!-- Styles for this page -->
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">CasaConnect</div>
            <ul class="nav-links">
                <li><a href="home_2.php">Home</a></li> <!-- Link back to regular admin home page -->
            </ul>
        </nav>
    </header>

    <main>
        <section class="create-listing-section">
            <div class="form-container">
                <h2>Create New Listing</h2>
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

                    <button type="submit" class="btn create-btn">Create</button>
                    <button type="button" class="btn cancel-btn" onclick="window.location.href='home_2.html'">Cancel</button>
                </form>
            </div>
        </section>
    </main>
</body>

</html>
