<?php
// Database connection setup
include '../../../php/db.php';

$data = array();
// Fix: Use GROUP_CONCAT to avoid duplicate rows from JOIN
$sql = "SELECT Rooms.RoomId, Rooms.CustomNo, Rooms.RoomType, Rooms.RoomName, Rooms.AttachBathroom, Rooms.NonSmokingRoom, Rooms.Price, Rooms.TotalOccupancy, Rooms.imgpath,
               GROUP_CONCAT(BedTypes.BedType) as BedType, GROUP_CONCAT(BedTypes.NumberOfBeds) as NumberOfBeds, GROUP_CONCAT(BedTypes.BedTypeId) as BedTypeId
        FROM Rooms 
        LEFT JOIN BedTypes ON Rooms.RoomId = BedTypes.RoomId
        GROUP BY Rooms.RoomId";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}
header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
?>
