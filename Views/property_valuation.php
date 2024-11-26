<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Valuation Booking</title>
    <link rel="stylesheet" href="../css/property_valuation.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../Js/property_valuation.js" defer></script> <!-- External JS File -->
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">CasaConnect</div>
            <ul class="nav-links">
                <li><a href="services.php">Back to Services</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Book a Property Valuation</h1>
        <div id="available-slots">
            <h2>Available Slots</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Slots will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>