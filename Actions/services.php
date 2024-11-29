<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewsport" content="width=device-width, initial-scale=1.0">
    <title>Services - CasaConnect</title>
    <link rel="stylesheet" href="../css/services.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">CasaConnect</div>
            <ul class="nav-links">
                <li><a href="./home.php">Home</a></li>
                <li><a href="./explore.php">Explore</a></li>
            </ul>
        </nav>
    </header>
    <div class="video-background">
        <video autoplay loop muted playsinline>
            <source src="../assets/video/services.mp4" type="video/mp4" alt="Real estate video background">
        </video>
    </div>
    <main>
        <section class="services-container">
            <div class="service-tab">
                <img src="../assets/static/consult.jpg" alt="Consultation Icon">
                <button class="service-button" onclick="navigateTo('./consultation.php')">Consultation</button>
                <p class="service-description">
                    Get expert advice tailored to your real estate needs. We help you make informed decisions for buying, selling, or investing in properties.
                </p>
            </div>
            <div class="service-tab">
                <img src="../assets/static/property_valuation.avif" alt="Property Evaluation Icon">
                <button class="service-button" onclick="navigateTo('./property_valuation.php')">Property Valuation</button>
                <p class="service-description">
                    Discover the true value of your property with our comprehensive evaluation services, ensuring accurate market insights and pricing.
                </p>
            </div>
        </section>
    </main>

    <script>
        function navigateTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
