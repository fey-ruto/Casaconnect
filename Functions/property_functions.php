<?php
// Function to add a new property
function addProperty($conn, $title, $description, $price, $location, $created_by) {
    $stmt = $conn->prepare("INSERT INTO properties (title, description, price, location, created_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $title, $description, $price, $location, $created_by);
    return $stmt->execute();
}

// Function to fetch all properties
function getAllProperties($conn) {
    $result = $conn->query("SELECT * FROM properties");
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
