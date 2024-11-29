<?php
require '../db/config.php';
require '../utils/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $role = (int)$_POST['role'];

    // Debugging
    echo "ID: $id, First Name: $fname, Last Name: $lname, Role: $role"; // Check if values are correct

    $stmt = $conn->prepare("UPDATE users SET fname = ?, lname = ?, user_role = ? WHERE id = ?");
    $stmt->bind_param("ssii", $fname, $lname, $role, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }

    $stmt->close();
    $conn->close();
}
?>