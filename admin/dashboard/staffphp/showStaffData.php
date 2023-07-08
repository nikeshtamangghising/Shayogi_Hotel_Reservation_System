<?php
// Database connection setup
include '../db.php';
$sql = "SELECT * FROM Staff";
$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode($data);
$conn->close();
