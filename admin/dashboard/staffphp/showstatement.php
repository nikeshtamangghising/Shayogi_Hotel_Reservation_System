<?php
// Database connection setup
include '../db.php';
$staff_id = $_POST['staff_id'];

$sql = "SELECT * FROM Withdrawals WHERE staff_id = '{$staff_id}' ";
$result = mysqli_query($conn, $sql);

$data = array(); // Initialize an empty array to store the results

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
