<?php
include '../db/connect.php';
include '../functions/auth_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = hashPassword($_POST['password']); 

    // Checking if email already exists in database.
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Error: Sorry, the email already exists!";
        exit;
    }

    // Insert user into the database table and update password.
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
    $role = 2; // Default role: Admin
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $password, $role);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: ../view/login.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

