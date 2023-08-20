<?php
// Database connection setup
include 'db.php';
$sql = "SELECT * FROM Guests";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode($data);
$conn->close();
