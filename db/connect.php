<?php
// Database connection file
$servername = "localhost";
$username = "faith.ruto";       
$password = "Fr@17005566";      
$database = "casaconnect"; 

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
