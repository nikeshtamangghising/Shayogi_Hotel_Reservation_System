<?php
// Database connection setup
include 'db.php';
$sql = "SELECT Rooms.*, BedTypes.BedType, BedTypes.NumberOfBeds, BedTypes.BedTypeId FROM Rooms LEFT JOIN BedTypes ON Rooms.RoomId = BedTypes.RoomId";
$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode($data);
$conn->close();
