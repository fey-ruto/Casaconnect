<?php
// Include config file
require '../db/config.php';

// Start session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user email from session
    $user_email = $_SESSION['user_email'];

    // Gather form input
    $name = trim($_POST['property-name']);
    $location = trim($_POST['property-location']);
    $description = trim($_POST['property-description']);
    $price = (float)$_POST['property-price'];

    // Initialize images array
    $images = [];

    // Handle file uploads
    foreach ($_FILES['property-images']['tmp_name'] as $key => $tmp_name) {
        // Validate file extension
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($_FILES['property-images']['name'][$key], PATHINFO_EXTENSION);

        // Skip invalid file types
        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
            continue; // Skip this file and move to the next one
        }

        $filename = uniqid() . "-" . basename($_FILES['property-images']['name'][$key]);
        $upload_path = "../uploads/" . $filename;

        // Attempt to move the uploaded file
        if (move_uploaded_file($tmp_name, $upload_path)) {
            $images[] = $upload_path; // Add successfully uploaded file to images array
        } elseif (!move_uploaded_file($tmp_name, $upload_path)) {
            $error_code = $_FILES['property-images']['error'][$key];
            switch ($error_code) {
                case UPLOAD_ERR_INI_SIZE:
                    die("Error uploading file: " . $_FILES['property-images']['name'][$key] . " - File exceeds the upload_max_filesize directive in php.ini.");
                case UPLOAD_ERR_FORM_SIZE:
                    die("Error uploading file: " . $_FILES['property-images']['name'][$key] . " - File exceeds the MAX_FILE_SIZE directive in the HTML form.");
                case UPLOAD_ERR_PARTIAL:
                    die("Error uploading file: " . $_FILES['property-images']['name'][$key] . " - File was only partially uploaded.");
                case UPLOAD_ERR_NO_FILE:
                    die("Error uploading file: No file was uploaded.");
                case UPLOAD_ERR_NO_TMP_DIR:
                    die("Error uploading file: Missing a temporary folder.");
                case UPLOAD_ERR_CANT_WRITE:
                    die("Error uploading file: " . $_FILES['property-images']['name'][$key] . " - Failed to write file to disk.");
                case UPLOAD_ERR_EXTENSION:
                    die("Error uploading file: " . $_FILES['property-images']['name'][$key] . " - File upload stopped by a PHP extension.");
                default:
                    die("Error uploading file: " . $_FILES['property-images']['name'][$key] . " - Unknown error.");
            }
        }
    }

    // Convert images array to a comma-separated string
    $images_path = !empty($images) ? implode(',', $images) : null;

    // Insert the listing into the database
    $stmt = $conn->prepare("INSERT INTO listings (property_name, location, description, price, images, status, user_email) VALUES (?, ?, ?, ?, ?, 'pending', ?)");
    $stmt->bind_param("sssds", $name, $location, $description, $price, $images_path, $user_email);

    if ($stmt->execute()) {
        // Redirect the user to the home page after successful insertion
        header("Location: ./home_2.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
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
