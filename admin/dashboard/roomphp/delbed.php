<?php

// Include the database connection setup
include '../db.php';
$BID = $_POST['BID'];
$sql = "DELETE FROM BedTypes WHERE BedTypeId = $BID";
if (mysqli_query($conn, $sql)) {
    // Deletion successful
    echo "Bed Deleted Sucessfully";
    exit;
} else {
    // Failed to delete the record
    echo "Error Unable To Delete Bed";
    exit;
}
$conn->close();
