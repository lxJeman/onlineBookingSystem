<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');     // Change to your MySQL username
define('DB_PASS', '');         // Change to your MySQL password
define('DB_NAME', 'booking_system');

try {
    // Create MySQL connection
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create users table
    $createTableQuery = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    // Create events table
    $createTable2Query = "
    CREATE TABLE IF NOT EXISTS events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        person VARCHAR(255) NOT NULL,
        contact VARCHAR(255) NOT NULL,
        date DATE NOT NULL,
        time TIME NOT NULL,
        extra TEXT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $db->exec($createTableQuery);
    $db->exec($createTable2Query);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Insert a user into the database
function insertUser($name, $password) {
    global $db;
    try {
        $stmt = $db->prepare("INSERT INTO users (name, password) VALUES (:name, :password)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        echo "User inserted successfully.\n";
    } catch (PDOException $e) {
        echo "Error inserting user: " . $e->getMessage() . "\n";
    }
}

// Access a user from the database
function accessUser($name, $password) {
    global $db;
    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE name = :name AND password = :password");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        echo "User successfully login.\n";
    } catch (PDOException $e) {
        echo "Error inserting user: " . $e->getMessage() . "\n";
    }
}

// Insert an event into the database
function insertEvent($name, $person, $contact, $date, $time, $extra) {
    global $db;
    try {
        $stmt = $db->prepare("INSERT INTO events (name, person, contact, date, time, extra) VALUES (:name, :person, :contact, :date, :time, :extra)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":person", $person);
        $stmt->bindParam(":contact", $contact);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":time", $time); // Bind the time parameter
        $stmt->bindParam(":extra", $extra);
        $stmt->execute();
        echo "Event inserted successfully.\n";
    } catch (PDOException $e) {
        echo "Error inserting event: " . $e->getMessage() . "\n";
    }
}
?>