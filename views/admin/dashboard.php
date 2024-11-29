<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewsport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CasaConnect</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js library -->
</head>
<body>
    <header>
    <nav class="navbar">
            <div class="logo">CasaConnect</div>
            <class="nav-links">
                <li><a href="../actions/home_2.php">Home</a></li>
                <li><a href="../actions/user_management.php">Users</a></li>
                <li><a href="../views/listing_management.php">Listings</a></li>
                <li><a href="../views/pending_listings.php">Pending Listings</a></li>
                <li><a href="../actions/admin_manage_services.php">Manage Services</a> </li>
            </ul>
        </nav>
    </header>
    <div id="dashboard">
        <h1>Analytics</h1>
        <div id="analytics">
            <div class="analytics-item">
                <h2>Recent Estate Purchases (Last Month)</h2>
                <canvas id="purchasesChart"></canvas> <!-- Bar chart -->
            </div>
            <div class="analytics-item">
                <h2>Recent User Sign-Ups</h2>
                <canvas id="signupsChart"></canvas> <!-- Bar chart -->
            </div>
            <div class="analytics-item">
                <h2>Top Brokers/Real Estate Agents</h2>
                <canvas id="brokersChart"></canvas> <!-- Bar chart -->
            </div>
            <div class="analytics-item">
                <h2>Cities with Most Posted Properties</h2>
                <canvas id="citiesChart"></canvas> <!-- Pie chart -->
            </div>
        </div>
    </div>
    <script src="../js/dashboard.js"></script>
</body>
</html>
