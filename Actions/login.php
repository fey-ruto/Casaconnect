<?php
// Import the configuration file
require '../db/config.php';

// Start the session
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'casaconnect');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user details securely
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $stored_hashed_password = $user['password'];

        // Verify the password
        if (password_verify($password, $stored_hashed_password)) {
            // Update the hash if needed
            if (password_needs_rehash($stored_hashed_password, PASSWORD_DEFAULT)) {
                $new_hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Update the database with the new hash
                $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
                $update_stmt->bind_param("ss", $new_hashed_password, $email);
                $update_stmt->execute();
            }

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_role'] = $user['user_role'];

            // Redirect based on user role
            if ($user['user_role'] == 2) {
                header("Location: ./home_2.php");
                exit;
            } 
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "No account found with that email.";
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
    <title>Login - CasaConnect</title>
    <link rel="stylesheet" href="../css/front.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">CasaConnect</div>
            <class="nav-links">
                <li><a href="./home.php">Home</a></li>
                <li><a href="./admin_login.php">Administrator</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="login-section">
            <div class="form-container">
                <h2>Login</h2>
                <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
                <form id="login-form" class="form" action="" method="post">
                    <label for="login-email">Email:</label>
                    <input type="text" id="login-email" name="email" placeholder="Enter your username" required>

                    <label for="login-password">Password:</label>
                    <input type="password" id="login-password" name="password" placeholder="Enter your password" required>

                    <button type="submit" class="btn">Login</button>
                </form>
                <p class="toggle-link">
                    Don't have an account? <a href="register.php">Sign Up</a>
                </p>
            </div>
        </section>
    </main>
</body>

</html>
