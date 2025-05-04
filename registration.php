<?php
require "database.php";

$passwordAuth = "KSDSIPHP";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $password = htmlspecialchars($_POST["password"]);
    $passwordAuthInput = htmlspecialchars($_POST["passwordAuth"]);

    if ($passwordAuthInput !== $passwordAuth) {
        echo "Invalid LICENSE_KEY authentication.";
    } else {
        insertUser($name, $password);
        echo "User registered successfully.";

        // Redirect to prevent form resubmission
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
</head>
<body>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <label for="passwordAuth">LICENSE_KEY Authentication:</label>
        <input type="text" id="passwordAuth" name="passwordAuth" required>
        <br>

        <input type="submit" value="Register">
    </form>
</body>
</html>