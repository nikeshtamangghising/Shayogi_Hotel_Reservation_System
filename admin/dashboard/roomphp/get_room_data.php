<?php
// Replace with your actual database credentials
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$database = "event_calendar";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["date"])) {
    $date = $_POST["date"];

    // Fetch room data and availability for the selected date
    $sql = "SELECT * FROM rooms";
    $result = $conn->query($sql);
    $rooms = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $room = array(
                "room_number" => $row["room_number"],
                "capacity" => $row["capacity"],
                "availability" => $row["availability"],
            );
            array_push($rooms, $room);
        }
    }

    // You can fetch booking details for the selected date here and modify the $rooms array accordingly.

    echo json_encode($rooms);
}

$conn->close();
