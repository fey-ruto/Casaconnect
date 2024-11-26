<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - CasaConnect User</title>
    <link rel="stylesheet" href="../css/front.css"> <!-- Base styles -->
    <link rel="stylesheet" href="../css/home_2.css"> <!-- Specific styles for home_2 page -->
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">CasaConnect</div>
            <ul class="nav-links">
                <li><a href="./about.php">About</a></li>
                <li><a href="./services.php">Services</a></li>
                <li><a href="./explore.php">Explore</a></li>
                <li><a href="../functions/logout.php">Logout</a></li>
            </ul>
        </nav>
        <div class="video-background">
            <video autoplay loop muted playsinline>
                <source src="../assets/video/Drone Residential Neighborhood.mp4" type="video/mp4" alt="Drone shot of neighbouhood">
            </video>
        </div>
        <div class="hero-section">
            <div class="hero-content">
                <h1>Discover Your Dream Home</h1>
                <p>With CasaConnect</p>
                <button class="explore-btn">Explore</button>
            </div>
        </div>
    </header>

    <main>
        <section class="left-panel">
            <h2>Your Listings</h2>
            <ul class="listing-list">
                <!-- Example listings (These should be dynamically generated based on user data) -->
                <li>Property 1 - $500,000</li>
                <li>Property 2 - $750,000</li>
                <li>Property 3 - $1,000,000</li>
            </ul>
            <button class="create-listing-btn" onclick="window.location.href='./create_listing.php'">Create New Listing</button>
        </section>

        <section class="main-content">
            <h2>Welcome to Your Dashboard</h2>
            <p>Here you can manage your uploaded listings, view statistics, and more.</p>
        </section>
    </main>
    <script src="../js/logout.js"></script>
</body>
</html>