<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <input type="submit" value="Login">
    </form>
<?php
require "database.php";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $password = htmlspecialchars($_POST["password"]);

    if (empty($name) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        accessUser($name, $password);
        $_SESSION['user'] = $name;
        header("Location: dashboard.php");
        exit();
    }

}
?>
</body>
</html>