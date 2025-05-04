<?php
try {
    $db = new PDO("sqlite:local.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $createTableQuery = "
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        password TEXT NOT NULL
    );";

    $createTable2Query = "
    CREATE TABLE IF NOT EXISTS events (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        person TEXT NOT NULL,
        contact TEXT NOT NULL,
        date TEXT NOT NULL,
        extra TEXT NOT NULL
    );";

    $db->exec($createTableQuery);
    $db->exec($createTable2Query);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n"; 
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
?>