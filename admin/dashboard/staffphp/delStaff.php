<?php

// Include the database connection setup
include '../db.php';
$ID = $_POST['ID'];
$sql = "DELETE FROM Staff WHERE staff_id = $ID";
if (mysqli_query($conn, $sql)) {
    // Deletion successful
    echo "Room Deleted Sucessfully";
    exit;
} else {
    // Failed to delete the record
    echo "Error Unable To Delete Room";
    exit;
}
$conn->close();
