<?php
error_reporting(E_ALL);          // Report all PHP errors
ini_set('display_errors', 1);  
// Include config file
require '../db/config.php';

// Start session
session_start();

// Function to validate if the user is logged in
function validate_user_session() {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
        // If the user is not logged in, redirect to login.php
        header("Location: ./login.php");
        exit();
    }
}

validate_user_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get user email from session
    $user_email = $_SESSION['email'];

    // Gather form input
    $name = trim($_POST['property-name']);
    $location = trim($_POST['property-location']);
    $description = trim($_POST['property-description']);
    $price = (float)$_POST['property-price'];

    // Initialize images array
    $images = [];
    $upload_errors = []; // Collect errors for debugging or user feedback

    // Handle file uploads
    if (isset($_FILES['property-images'])) {
        foreach ($_FILES['property-images']['tmp_name'] as $key => $tmp_name) {
            // Check if the file was uploaded
            if (!is_uploaded_file($tmp_name)) {
                $upload_errors[] = "No file uploaded for key: $key.";
                continue;
            }

            // Validate file extension
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
            $file_extension = pathinfo($_FILES['property-images']['name'][$key], PATHINFO_EXTENSION);

            if (!in_array(strtolower($file_extension), $allowed_extensions)) {
                $upload_errors[] = "Invalid file type: " . $_FILES['property-images']['name'][$key];
                continue;
            }

            // Define upload path and filename
            $filename = uniqid() . "-" . basename($_FILES['property-images']['name'][$key]);
            $upload_path = "../uploads/" . $filename;

            // Attempt to move the uploaded file
            if (!move_uploaded_file($tmp_name, $upload_path)) {
                $error_code = $_FILES['property-images']['error'][$key];
                switch ($error_code) {
                    case UPLOAD_ERR_INI_SIZE:
                        $upload_errors[] = "File exceeds the upload_max_filesize directive in php.ini.";
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $upload_errors[] = "File exceeds the MAX_FILE_SIZE directive in the HTML form.";
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $upload_errors[] = "File was only partially uploaded.";
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $upload_errors[] = "Missing a temporary folder.";
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $upload_errors[] = "Failed to write file to disk.";
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        $upload_errors[] = "File upload stopped by a PHP extension.";
                        break;
                    default:
                        $upload_errors[] = "Unknown error occurred.";
                }
            } else {
                // Add successfully uploaded file to images array
                $images[] = $upload_path;
            }
        }
    }

    // Convert images array to a comma-separated string
    $images_path = !empty($images) ? implode(',', $images) : null;

    // Insert the listing into the database
    $stmt = $conn->prepare("INSERT INTO listings (property_name, location, description, price, images, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("sssds", $name, $location, $description, $price, $images_path);


    if ($stmt->execute()) {
        // Redirect the user to the home page after successful insertion
        header("Location: ./home_2.php");
        exit();
    } else {
        echo "Error inserting listing: " . $stmt->error;
    }

    // Log upload errors (optional, for debugging)
    if (!empty($upload_errors)) {
        foreach ($upload_errors as $error) {
            echo "<p>Error: $error</p>";
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
