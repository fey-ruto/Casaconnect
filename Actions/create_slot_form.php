<!DOCTYPE html>
<html>
<head>
    <title>Create Slot</title>
</head>
<body>
    <form action="../actions/create_slot.php" method="POST">
        <label>Date:</label>
        <input type="date" name="date" required><br>
        <label>Time:</label>
        <input type="time" name="time" required><br>
        <label>Type:</label>
        <select name="table">
            <option value="consultation_slots">Consultation</option>
            <option value="property_valuation_slots">Property Valuation</option>
        </select><br>
        <button type="submit">Create Slot</button>
    </form>
</body>
</html>
