<?php
include 'db.php';
$checkInDate = $_POST['checkInDate'];
$checkOutDate = $_POST['checkOutDate'];
$numberGuest = $_POST['numberGuest'];

$sql = "
 SELECT DISTINCT r.*,c.Availabilities
        FROM Rooms r
        INNER JOIN Calendar c ON r.RoomId = c.RoomId
        WHERE c.Date BETWEEN '$checkInDate' AND '$checkOutDate'
        AND r.TotalOccupancy >= '$numberGuest' AND c.Availabilities >= 1
        ORDER BY r.RoomId";

$result = mysqli_query($conn, $sql);

$availableRooms = array();
while ($row = mysqli_fetch_assoc($result)) {
    $availableRooms[] = $row;
}

echo json_encode($availableRooms);

mysqli_close($conn);
