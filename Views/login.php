<?php
// Import the configuration file
require 'connect.php';

// Start the session
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'casconnect'); // Update 'database' with your DB name

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Secure query to check user credentials
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verify user credentials
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the password matches
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['user_role'];

            // Redirect based on user role
            if ($user['user_role'] === '1') { // Admin role
                header("Location: dashboard.php");
                exit;
            } else { // Regular user role
                header("Location: home.php");
                exit;
            }
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "No account found with that email.";
    }

    // Close the connection
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
    <link rel="stylesheet" href="../Css/front.css"> <!-- Reusing the same CSS for consistent styling -->
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">CasaConnect</div>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li> <!-- Home nav-link -->
                <li><a href="dashboard.php">Administrator</a></li> <!-- Administrator nav-link -->
            </ul>
        </nav>
    </header>

    <main>
        <section class="login-section">
            <div class="form-container">
                <h2>Login</h2>
                <?php
                // Display error message if login fails
                if (isset($error)) {
                    echo "<p style='color: red;'>$error</p>";
                }
                ?>
                <form id="login-form" class="form" action="" method="post">
                    <label for="login-email">Email:</label>
                    <input type="email" id="login-email" name="email" placeholder="Enter your email" required>

                    <label for="login-password">Password:</label>
                    <input type="password" id="login-password" name="password" placeholder="Enter your password" required>

                    <button type="submit" class="btn">Login</button>
                </form>
                <p class="toggle-link">
                    Don't have an account? <a href="register.php">Sign Up</a> <!-- Sign-up link -->
                </p>
            </div>
        </section>
    </main>
</body>

</html>
