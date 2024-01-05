<?php

// Include the database connection setup
include '../db.php';
$ID = $_POST['ID'];
$BedType = $_POST['BedType'];
$NumberOfBeds = $_POST['NumberOfBeds'];

$sql = "INSERT INTO BedTypes (RoomId, BedType, NumberOfBeds) VALUES ('$ID', '$BedType', '$NumberOfBeds')";
if (mysqli_query($conn, $sql)) {
    // Deletion successful
    echo "Bed Add Sucessfully";
    exit;
} else {
    // Failed to delete the record
    echo "Error Unable To Add Bed";
    exit;
}
$conn->close();
