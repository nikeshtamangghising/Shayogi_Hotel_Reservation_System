<?php
// Database connection setup
include '../db.php';

// Make sure to sanitize and validate user inputs
$RoomId = mysqli_real_escape_string($conn, $_POST['RoomId']);

// Delete data from the Calendar table
$deleteSql = "DELETE FROM Calendar WHERE RoomId = '{$RoomId}'";
$deleteResult = mysqli_query($conn, $deleteSql);

// Check if the deletion was successful
$data = [];
if ($deleteResult) {
    $data[] = "Data deleted successfully.";
} else {
    $data[] = "Error deleting data: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);

// Return the result to the user
echo json_encode($data);
