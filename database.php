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
        time TEXT NOT NULL, -- Added the time column
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