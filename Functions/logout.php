<?php
// Start the session
session_start();

// Destroy all session variables
session_unset();

// Destroy the session itself
session_destroy();

// Redirect to the home page
header("Location: ../Actions/home.php");
exit();
?>
