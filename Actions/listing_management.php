<?php
require '../db/config.php';

// Fetch all listings from the database
$query = "SELECT * FROM listings";
$result = $conn->query($query);

// Check if the result is not empty
$listings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $listings[] = $row;
    }
}
?>