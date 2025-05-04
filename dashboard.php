<?php
session_start(); // Start the session

if (isset($_SESSION['user'])) {
    $name = htmlspecialchars($_SESSION['user']);
    echo "<p>Welcome, $name!</p>";
} else {
    echo "<h1>No user is logged in. Please log in first.</h1>";
    // Optionally redirect to the login page
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

</head>
<body>
    <form method="POST" action="">
        <h3>Add a new event:</h3>
        <br>
        <label for="name">Event Name:</label>
        <input type="text" id="name" name="name" required>
        <br>

        <label for="person">Person Name:</label>
        <input type="text" id="person" name="person" required>
        <br>

        <label for="contact">Contact info:</label>
        <input type="tel" id="contact" name="contact" required>
        <br>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <br>

        <label for="extra">Extra information</label>
        <input type="text" id="extra" name="extra" required>
        <br>
        <br>

        <input type="submit" value="Add New Event">
    </form>
</body>
</html>