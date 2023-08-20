<?php
// Database connection setup
include '../db.php';
$date = $_POST['Date'];

$sql = $sql = "SELECT Calendar.*, Rooms.RoomType, Rooms.CustomNo, Rooms.RoomName, Rooms.Price, Rooms.TotalOccupancy, Rooms.AttachBathroom, Rooms.NonSmokingRoom
        FROM Calendar
        INNER JOIN Rooms ON Calendar.RoomId = Rooms.RoomId
        WHERE Calendar.Date = '{$date}'";

$result = mysqli_query($conn, $sql);

$data = array(); // Initialize an empty array to store the results

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
