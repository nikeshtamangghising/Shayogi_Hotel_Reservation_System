<?php
// Database connection setup
include '../../../php/db.php';

$data = array();
$sql = "SELECT BedTypes.*, Rooms.CustomNo, Rooms.RoomType, Rooms.RoomName 
        FROM BedTypes 
        LEFT JOIN Rooms ON BedTypes.RoomId = Rooms.RoomId 
        GROUP BY BedTypes.BedTypeId";
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
