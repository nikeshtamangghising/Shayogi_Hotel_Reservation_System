<?php
// Database connection setup
include '../db.php';
$date = $_POST['Date'];

$sql = "SELECT Reservations.*, Guests.FullName, Guests.Email, Guests.Country, Guests.ID_Verification, Guests.Phone, Rooms.RoomType, Rooms.CustomNo, Rooms.RoomName, Rooms.Price, Rooms.TotalOccupancy, Rooms.AttachBathroom, Rooms.NonSmokingRoom
        FROM Reservations
        INNER JOIN Guests ON Reservations.GuestID = Guests.GuestID
        INNER JOIN Rooms ON Reservations.RoomId = Rooms.RoomId
        WHERE '{$date}' >= Reservations.CheckInDate AND '{$date}' < Reservations.CheckOutDate ";

$result = mysqli_query($conn, $sql);

$data = array(); // Initialize an empty array to store the results

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
