<?php
require "database.php";
session_start();

$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $person = htmlspecialchars($_POST["person"]);
    $contact = htmlspecialchars($_POST["contact"]);
    $date = htmlspecialchars($_POST["date"]);
    $time = htmlspecialchars($_POST["time"]);
    $extra = htmlspecialchars($_POST["extra"]);

    try {
        $stmt = $db->prepare("INSERT INTO events (name, person, contact, date, time, extra) VALUES (:name, :person, :contact, :date, :time, :extra)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":person", $person);
        $stmt->bindParam(":contact", $contact);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":time", $time);
        $stmt->bindParam(":extra", $extra);
        $stmt->execute();
        
        // Redirect to prevent form resubmission
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    } catch (PDOException $e) {
        echo "<script>alert('Error inserting event: " . $e->getMessage() . "');</script>";
    }
}

// Update the generateCalendar function:
function generateCalendar($db, $year, $month) {
    // Validate month and year
    if ($month < 1) {
        $month = 12;
        $year--;
    }
    if ($month > 12) {
        $month = 1;
        $year++;
    }

    $daysInMonth = date('t', strtotime("$year-$month-01"));
    $firstDayOfMonth = date('w', strtotime("$year-$month-01"));
    
    // Fetch events for current month
    $stmt = $db->prepare("SELECT * FROM events WHERE strftime('%Y-%m', date) = ?");
    $currentYearMonth = date('Y-m', strtotime("$year-$month-01"));
    $stmt->execute([$currentYearMonth]);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Group events by date
    $eventsByDate = [];
    foreach ($events as $event) {
        $date = date('Y-m-d', strtotime($event['date']));
        $eventsByDate[$date][] = $event;
    }
    
    // Navigation buttons
    $prevMonth = $month - 1;
    $prevYear = $year;
    $nextMonth = $month + 1;
    $nextYear = $year;
    
    if ($prevMonth < 1) {
        $prevMonth = 12;
        $prevYear--;
    }
    if ($nextMonth > 12) {
        $nextMonth = 1;
        $nextYear++;
    }
    
    // Build calendar HTML with navigation
    $calendar = "<div class='calendar'>";
    $calendar .= "<div class='calendar-nav'>";
    $calendar .= "<a href='?month=$prevMonth&year=$prevYear' class='nav-btn'>&lt; Previous</a>";
    $calendar .= "<h3>" . date('F Y', strtotime("$year-$month-01")) . "</h3>";
    $calendar .= "<a href='?month=$nextMonth&year=$nextYear' class='nav-btn'>Next &gt;</a>";
    $calendar .= "</div>";
    
    $calendar .= "<table border='1'>";
    $calendar .= "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>";
    
    // Add empty cells for days before start of month
    $calendar .= "<tr>";
    for ($i = 0; $i < $firstDayOfMonth; $i++) {
        $calendar .= "<td></td>";
    }
    
    // Fill in the days
    $currentDay = 1;
    $currentCell = $firstDayOfMonth;
    
    while ($currentDay <= $daysInMonth) {
        if ($currentCell == 7) {
            $calendar .= "</tr><tr>";
            $currentCell = 0;
        }
        
        $date = date('Y-m-d', strtotime("$year-$month-$currentDay"));
        $calendar .= "<td class='day-cell'>";
        $calendar .= "<div class='day-number'>$currentDay</div>";
        
        // Add events for this day
        if (isset($eventsByDate[$date])) {
            foreach ($eventsByDate[$date] as $event) {
                $calendar .= "<div class='event' onclick='showEventDetails(\"" . 
                    htmlspecialchars($event['name'], ENT_QUOTES) . "\", \"" .
                    htmlspecialchars($event['person'], ENT_QUOTES) . "\", \"" .
                    htmlspecialchars($event['contact'], ENT_QUOTES) . "\", \"" .
                    htmlspecialchars($event['time'], ENT_QUOTES) . "\", \"" .
                    htmlspecialchars($event['extra'], ENT_QUOTES) . "\")'>";
                $calendar .= htmlspecialchars($event['time']) . " - ";
                $calendar .= htmlspecialchars($event['name']);
                $calendar .= "</div>";
            }
        }
        
        $calendar .= "</td>";
        
        $currentDay++;
        $currentCell++;
    }
    
    // Complete the table
    while ($currentCell < 7) {
        $calendar .= "<td></td>";
        $currentCell++;
    }
    
    $calendar .= "</tr></table></div>";
    return $calendar;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        .calendar {
            max-width: 1200px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        .calendar table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        .calendar th {
            background: #f0f0f0;
            padding: 10px;
            text-align: center;
        }
        .day-cell {
            height: 120px;
            vertical-align: top;
            padding: 5px;
            border: 1px solid #ddd;
        }
        .day-number {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .event {
            background: #e3f2fd;
            margin: 2px;
            padding: 4px;
            font-size: 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .event:hover {
            background: #bbdefb;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }
        .modal-content {
            background: white;
            margin: 15% auto;
            padding: 20px;
            width: 70%;
            max-width: 500px;
            border-radius: 5px;
        }
        .close {
            float: right;
            cursor: pointer;
            font-size: 20px;
        }
        form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        form input {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        form input[type="submit"] {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background: #45a049;
        }
        /* Add these to your existing styles */
        .calendar-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .nav-btn {
            padding: 8px 16px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
        }
        
        .nav-btn:hover {
            background: #45a049;
        }
        
        .calendar-nav h3 {
            margin: 0;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
    
    <?php echo generateCalendar($db, $year, $month); ?>

    <!-- Event Details Modal -->
    <div id="eventModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Event Details</h2>
            <p><strong>Event Name:</strong> <span id="modalEventName"></span></p>
            <p><strong>Person:</strong> <span id="modalPerson"></span></p>
            <p><strong>Contact:</strong> <span id="modalContact"></span></p>
            <p><strong>Time:</strong> <span id="modalTime"></span></p>
            <p><strong>Extra Info:</strong> <span id="modalExtra"></span></p>
        </div>
    </div>

    <form method="POST" action="">
        <h3>Add a new event:</h3>
        <label for="name">Event Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="person">Person Name:</label>
        <input type="text" id="person" name="person" required>
        
        <label for="contact">Contact info:</label>
        <input type="tel" id="contact" name="contact" required>
        
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        
        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required>
        
        <label for="extra">Extra information:</label>
        <input type="text" id="extra" name="extra" required>
        
        <input type="submit" value="Add New Event">
    </form>

    <script>
        function showEventDetails(name, person, contact, time, extra) {
            document.getElementById('modalEventName').textContent = name;
            document.getElementById('modalPerson').textContent = person;
            document.getElementById('modalContact').textContent = contact;
            document.getElementById('modalTime').textContent = time;
            document.getElementById('modalExtra').textContent = extra;
            document.getElementById('eventModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('eventModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == document.getElementById('eventModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>