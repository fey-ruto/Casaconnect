<?php
// Import the configuration file
require '../db/config.php';

// Start the session
session_start();

// Initialize variables
$error = '';
$success = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fname = htmlspecialchars(trim($_POST['firstname']));
    $lname = htmlspecialchars(trim($_POST['lastname']));
    $email = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    // Basic validation
    // if (empty($firstname) || empty($lastname) || empty($username) || empty($password) || empty($confirm_password)) {
    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'casaconnect');

        // Check connection
        if ($conn->connect_error) {
            $error = "Unable to connect to the database. Please try again later.";
        }
        

        // Check if username already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = 'An account with this username already exists.';
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            // $stmt = $conn->prepare("INSERT INTO users (fname, lname, username, password, user_role) VALUES (?, ?, ?, ?, 2)");
            // $stmt->bind_param("ssss", $firstname, $lastname, $username, $hashed_password);
            
            $stmt = $conn->prepare("INSERT INTO users (fname, lname, email, password, user_role) VALUES (?, ?, ?, ?, 2)");
            $stmt->bind_param("ssss", $fname, $lname, $username, $hashed_password);


            if ($stmt->execute()) {
                $success = 'Account created successfully!';
                header("Location: ../viewss/home_2.html");
            } else {
                $error = 'An error occurred. Please try again.';
            }
        }
        // Close the connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewsport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - CasaConnect</title>
    <link rel="stylesheet" href="../css/front.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">CasaConnect</div>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="signup-section">
            <div class="form-container">
                <h2>Sign Up</h2>
                <?php
                if (!empty($error)) echo "<p style='color: red;'>$error</p>";
                if (!empty($success)) echo "<p style='color: green;'>$success</p>";
                ?>
                <form id="signup-form" class="form" action="register.php" method="post">
                    <label for="signup-firstname">First Name:</label>
                    <input type="text" id="signup-firstname" name="firstname" placeholder="Enter your first name" required>

                    <label for="signup-lastname">Last Name:</label>
                    <input type="text" id="signup-lastname" name="lastname" placeholder="Enter your last name" required>

                    <label for="signup-email">Email:</label>
                    <input type="text" id="signup-email" name="email" placeholder="Enter your email" required>

                    <label for="signup-password">Password:</label>
                    <input type="password" id="signup-password" name="password" placeholder="Create a password" required>

                    <label for="signup-confirm-password">Confirm Password:</label>
                    <input type="password" id="signup-confirm-password" name="confirm_password" placeholder="Confirm your password" required>

                    <button type="submit" class="btn">Sign Up</button>
                </form>
                <p class="toggle-link">
                    Already have an account? <a href="login.php">Login</a>
                </p>
            </div>
        </section>
    </main>
</body>

</html>
