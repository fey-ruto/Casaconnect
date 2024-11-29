<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection file
$servername = "localhost";
$username = "root";       
$password = "";      
$database = "casaconnect"; 

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
}
?>
